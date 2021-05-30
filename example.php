<?php

use Tsc\CatStorageSystem\LocalDiskDirectory;
use Tsc\CatStorageSystem\LocalDiskFile;
use Tsc\CatStorageSystem\LocalDiskFileSystem;

include __DIR__ . '/vendor/autoload.php';

$folder = new LocalDiskDirectory;
$folder->setPath('images');

$filesystem = new LocalDiskFileSystem;

$fileToRename = new LocalDiskFile;
$fileToRename->setName('cat_1.gif');
$fileToRename->setParentDirectory($folder);
$filesystem->renameFile($fileToRename, $newFileName = 'superfinalcat.gif');
echo "cat_1.gif image renamed to superfinalcat.gif !!\n";

$fileToDelete = new LocalDiskFile;
$fileToDelete->setName('cat_2.gif');
$fileToDelete->setParentDirectory($folder);
$filesystem->deleteFile($fileToDelete);
echo "cat_2.gif image deleted!!\n";

echo "The images folder size is: ".$filesystem->getDirectorySize($folder)." bytes !!\n";
echo "The images folder has: ".$filesystem->getFileCount($folder)." files !!\n";
echo "The images folder has: ".$filesystem->getDirectoryCount($folder)." folders !!\n";