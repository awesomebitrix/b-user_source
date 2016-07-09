<?php

namespace webarch\buser\test;

use PHPUnit_Framework_Assert;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Tester\ApplicationTester;
use WebArch\BUser\App\App;

class UserAddTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ApplicationTester
     */
    protected $tester;

    protected function setUp()
    {
        $commandlineApp = App::getInstance()->getCommandlineApp();
        $commandlineApp->setAutoExit(false);
        $this->tester = new ApplicationTester($commandlineApp);
    }

    public function testUserAdd()
    {
        $exitCode = $this->tester->run(
            [
                "command"       => "add",
                "document-root" => "/home/gripinskiy/www/tsum.loc/htdocs",
                "--email"       => "test2@example.org",
                "--pasgen"      => true,
            ],
            ['interactive' => false, 'decorated' => false, 'verbosity' => Output::VERBOSITY_NORMAL]
        );
        ob_end_flush();

        $display = $this->tester->getDisplay(false);
        echo $display;

        PHPUnit_Framework_Assert::assertEquals(0, $exitCode, "Check exit status");

//        $display = $this->tester->getDisplay(true);
//        $statusCode = $this->tester->getStatusCode();
//        $output = $this->tester->getOutput();

    }


    protected function tearDown()
    {
        $this->tester = null;
    }
}
