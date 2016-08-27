<?php

namespace WebArch\BUser\Test\AppManager;


use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Tester\ApplicationTester;
use WebArch\BUser\App\App;

class TesterHelper
{
    /**
     * @var ApplicationManager
     */
    private $app;

    /**
     * @var ApplicationTester
     */
    private $applicationTester;

    /**
     * @param ApplicationManager $app
     */
    public function __construct(ApplicationManager $app)
    {
        $this->app = $app;
        $commandlineApp = App::getInstance()->getCommandlineApp();
        $commandlineApp->setAutoExit(false);
        $this->applicationTester = new ApplicationTester($commandlineApp);
    }

    /**
     * @param bool|false $normalize
     * @return string
     */
    public function getDisplay($normalize = false)
    {
        return $this->applicationTester->getDisplay($normalize);
    }

    /**
     * @param array $options
     * @return int
     */
    public function runAdd(array $options)
    {
        $input = [
            "command"       => "add",
            "document-root" => $this->app->config()["document-root"],
        ];
        $exitCode = $this->applicationTester->run(
            array_merge($input, $options),
            ['interactive' => false, 'decorated' => false, 'verbosity' => Output::VERBOSITY_NORMAL]
        );
        return $exitCode;
    }
}
