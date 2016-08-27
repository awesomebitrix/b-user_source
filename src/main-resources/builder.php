#!/usr/bin/env php
<?php

use WebArch\BUser\Compiler;

require __DIR__ . "/../../vendor/autoload.php";

(new Compiler())->compile();

//
//$shebang = "#!/usr/bin/env php\n";
//$name = "b-user.phar";
//$srcRoot = __DIR__ . "/../../src";
//$buildRoot = __DIR__ . "../../build";
//$buildFilename = $buildRoot.'/'.$name;
//
//$phar = new Phar(
//    $buildFilename,
//    FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME
//);
//
//$phar->buildFromDirectory($srcRoot, '/\.php$/');
////$phar->setStub($shebang . $phar->createDefaultStub("app.php"));
//
//chmod($buildFilename, 0775);

