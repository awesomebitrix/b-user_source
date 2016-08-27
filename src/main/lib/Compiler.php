<?php

namespace WebArch\BUser;

use Phar;

class Compiler
{
    public function compile()
    {
        $pharFile = $this->getBuildFile();
        if (file_exists($pharFile) && is_file($pharFile)) {
            unlink($pharFile);
        }

        $phar = new Phar($pharFile);
        $phar->startBuffering();
        $phar->setSignatureAlgorithm(Phar::SHA1);
        $phar->setStub(
            "#!/usr/bin/env php\n"
            . $phar->createDefaultStub("src/main/app.php")
        );
        //TODO Улучшить сборку, добавить сжатие, попытаться исключить ненужные файлы
        $phar->buildFromDirectory($this->getSourceDir(), '/\.php$/');
        $phar->stopBuffering();
        chmod($this->getBuildFile(), 0775);
    }

    private function getSourceDir()
    {
        return realpath(__DIR__ . "/../../..");
    }

    private function getBuildFile()
    {
        return realpath(__DIR__ . "/../../../build") . '/b-user.phar';
    }

}
