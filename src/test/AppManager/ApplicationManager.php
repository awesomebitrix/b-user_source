<?php

namespace WebArch\BUser\Test\AppManager;


class ApplicationManager
{

    /**
     * @var array
     */
    private $config;

    /**
     * @var TesterHelper
     */
    private $tester;

    /**
     *
     */
    public function init()
    {
        $this->tester = new TesterHelper($this);
    }

    /**
     *
     */
    public function stop()
    {
        $this->tester = null;
    }

    /**
     * @return array
     */
    public function config()
    {
        if (is_null($this->config)) {
            $this->config = parse_ini_file($this->getConfigFilename());
        }
        return $this->config;
    }

    /**
     * @return string
     */
    private function getConfigFilename()
    {
        $target = getenv('target');
        if ($target === false) {
            $target = 'local';
        }
        return sprintf(
            realpath("../../") . '/test-resources/%s.ini',
            $target
        );
    }

    /**
     * @return TesterHelper
     */
    public function tester()
    {
        return $this->tester;
    }
}
