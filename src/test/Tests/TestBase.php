<?php

namespace WebArch\BUser\Test\Tests;

use PHPUnit_Framework_TestCase;
use WebArch\BUser\Test\AppManager\ApplicationManager;

abstract class TestBase extends PHPUnit_Framework_TestCase
{
    /**
     * @var ApplicationManager
     */
    protected $app;

    /**
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->app = new ApplicationManager();
    }

    /**
     *
     */
    protected function setUp()
    {
        $this->app->init();
    }

    /**
     *
     */
    protected function tearDown()
    {
        $this->app->stop();
    }

}
