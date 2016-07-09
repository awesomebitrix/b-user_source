<?php

namespace WebArch\BUser\Command;

use RuntimeException;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use WebArch\BUser\Enum\ErrorCode;
use WebArch\BUser\Model\UserData;

class AddCommand extends CommandBase
{
    /**
     * @var UserData
     */
    protected $user;

    protected function configure()
    {
        parent::configure();
        $this
            ->setName("add")
            ->setDescription("Add new user")
            ->addOption("email", "e", InputOption::VALUE_REQUIRED, "E-mail")
            ->addOption("login", "l", InputOption::VALUE_OPTIONAL, "Login")
            ->addOption("name", null, InputOption::VALUE_OPTIONAL, "First name")
            ->addOption("lastname", null, InputOption::VALUE_OPTIONAL, "Last name")
            ->addOption("secondname", null, InputOption::VALUE_OPTIONAL, "Second name")
            ->addOption("admin", "a", InputOption::VALUE_NONE, "Make new user admin")
            ->addOption("pasgen", "p", InputOption::VALUE_NONE, "Generate password and show it rather asking it");
        $this->user = new UserData();
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        //Если не выбрана генерация пароля, то спросить его
        if (!$input->getOption("pasgen")) {
            /** @var QuestionHelper $helper */
            $helper = $this->getHelper("question");
            $pasQuest = new Question("Set password: ");
            $pasQuest->setHidden(true);
            $pasQuest->setHiddenFallback(false);
            $pasConfirmQuest = new Question("Confirm password: ");
            $pasConfirmQuest->setHidden(true);
            $pasConfirmQuest->setHiddenFallback(false);
            $this->user->withPassword($helper->ask($input, $output, $pasQuest));
            $this->user->withPasswordConfirm($helper->ask($input, $output, $pasConfirmQuest));
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $exitCode = 0;
        try {

            $this->includeBitrix($input);

            $this->user
                ->withEmail($input->getOption("email"))
                ->withLogin($input->getOption("login"))
                ->withFirstName($input->getOption("name"))
                ->withLastName($input->getOption("lastname"))
                ->withSecondName($input->getOption("secondname"))
                ->withGroups($this->app->getUserHelper()->getFutureGroups($input->getOption("admin")));

            if ($input->getOption("pasgen")) {
                $password = $this->app->getUserHelper()->generatePassword($this->user->getGroups());
                $this->user
                    ->withPassword($password)
                    ->withPasswordConfirm($password);
            } elseif ($this->user->getPassword() !== $this->user->getPasswordConfirm()) {
                throw new RuntimeException("Wrong password confirmation", ErrorCode::PASSWORD_MISMATCH);
            }

            $this->user->withId($this->app->getUserHelper()->addUser($this->user));
            //Если пароль был введён с клавиатуры, то не показывать его
            if (!$input->getOption("pasgen")) {
                $this->user
                    ->withPassword(null)
                    ->withPasswordConfirm(null);
            }
            $output->writeln("New user created");
            $output->writeln($this->app->getFormatHelper()->formatUserInfo($this->user));

        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            $exitCode = $e->getCode();
        }
        return $exitCode;
    }

}
