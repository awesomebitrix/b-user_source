<?php

namespace webarch\buser\app;

use RuntimeException;
use Symfony\Component\Console\Application;
use webarch\buser\command\AddCommand;
use webarch\buser\ErrorCode;

class App
{
    const BX_PROLOG_BEFORE_PATH = "/bitrix/modules/main/include/prolog_before.php";

    private $name = "b-user";
    private $version = "1.0";
    /**
     * @var UserHelper
     */
    protected $userHelper;

    /**
     * @var FormatHelper
     */
    protected $formatHelper;

    /**
     * @var App
     */
    private static $instance;

    private $commandlineApp;

    private function __construct()
    {
        //Singletone
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function run()
    {
        $this->commandlineApp = new Application($this->getName(), $this->getVersion());
        $this->commandlineApp->add(new AddCommand());
        $this->commandlineApp->run();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    public function getUserHelper()
    {
        if (is_null($this->userHelper)) {
            $this->userHelper = new UserHelper();
        }
        return $this->userHelper;
    }

    /**
     * @return FormatHelper
     */
    public function getFormatHelper()
    {
        if (is_null($this->formatHelper)) {
            $this->formatHelper = new FormatHelper();
        }
        return $this->formatHelper;
    }

    public function includeBitrix($documentRoot)
    {
        $documentRoot = trim($documentRoot);
        $realPath = realpath($documentRoot);
        if ($realPath === false) {
            throw new RuntimeException("Path doesn't exist: " . $documentRoot, ErrorCode::PATH_DOESNT_EXIST);
        }
        $documentRoot = rtrim($realPath, '/');
        if (!is_dir($documentRoot) || !is_file($documentRoot . self::BX_PROLOG_BEFORE_PATH)) {
            throw new RuntimeException( "Not a Bitrix project root: " . $documentRoot, ErrorCode::BAD_BITRIX_ROOT );
        }
        $_SERVER["DOCUMENT_ROOT"] = $documentRoot;
        define("NO_KEEP_STATISTIC", true);
        define("NOT_CHECK_PERMISSIONS", true);
        /** @noinspection PhpIncludeInspection */
        require($_SERVER["DOCUMENT_ROOT"] . self::BX_PROLOG_BEFORE_PATH);
        set_time_limit(120);
        ini_set("memory_limit", "512M");
    }

}
