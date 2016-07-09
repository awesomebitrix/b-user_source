<?php

namespace webarch\buser\test;

use PHPUnit_Framework_TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Tester\ApplicationTester;
use WebArch\BUser\App\App;
use WebArch\BUser\Command\AddCommand;

class UserAddTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ApplicationTester
     */
    protected $tester;

    protected function setUp()
    {
        $buserApp = App::getInstance();
        $commandlineApp = new Application($buserApp->getName(), $buserApp->getVersion());
        $commandlineApp->add(new AddCommand());
        $commandlineApp->setAutoExit(false);

        $this->tester = new ApplicationTester($commandlineApp);
    }

    protected function tearDown()
    {
        $this->tester = null;
    }


    public function testUserAdd()
    {
        putenv('SHELL_INTERACTIVE=1');

        $a = 3;
        try {
            $this->tester->run(
                [
                    "command"       => "add",
                    "document-root" => "/home/gripinskiy/www/tsum.loc/htdocs",
                    "--email"         => "test@example.org",
                    "--pasgen"        => true,
                ],
                ['interactive' => true, 'decorated' => false, 'verbosity' => Output::VERBOSITY_VERBOSE]
            );
        } catch (\Exception $e) {

        }
        $display = $this->tester->getDisplay(true);
        $statusCode = $this->tester->getStatusCode();
        $output = $this->tester->getOutput();
        $a = 3;


    }
}
