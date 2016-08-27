<?php

namespace WebArch\BUser\Test\Tests;

use PHPUnit_Framework_Assert;

class UserAddTest extends TestBase
{

    public function testUserAdd()
    {
        $exitCode = $this->app->tester()->runAdd(
            [
                "--email"       => "test2@example.org",
                "--pasgen"      => true,
            ]
        );

        ob_end_flush();

        $display = $this->app->tester()->getDisplay(false);
        echo $display;

        PHPUnit_Framework_Assert::assertEquals(0, $exitCode, "Check exit status");

//        $display = $this->tester->getDisplay(true);
//        $statusCode = $this->tester->getStatusCode();
//        $output = $this->tester->getOutput();

    }

}
