<?php

namespace Tsc\CatStorageSystem;

use SplFileObject;
use DateTime;
use DirectoryIterator;
use Exception;
use SplFileInfo;

class LocalDiskFileSystem implements FileSystemInterface
{
    public function createFile(FileInterface $file, DirectoryInterface $parent): FileInterface {
        $createdFile = new SplFileObject($parent->getPath().DIRECTORY_SEPARATOR.$file->getName(), 'w');
        
        return (new LocalDiskFile)
            ->setName($file->getName())
            ->setSize($createdFile->getSize())
            ->setCreatedTime((new Datetime)->setTimestamp($createdFile->getCTime()))
            ->setModifiedTime((new Datetime)->setTimestamp($createdFile->getMTime()))
            ->setParentDirectory($parent);
    }

    public function updateFile(FileInterface $file): FileInterface {
        $updatedFile = new SplFileObject($file->getPath(), 'w');

        return (new LocalDiskFile)
            ->setName($file->getName())
            ->setSize($updatedFile->getSize())
            ->setCreatedTime((new Datetime)->setTimestamp($updatedFile->getCTime()))
            ->setModifiedTime((new Datetime)->setTimestamp($updatedFile->getMTime()))
            ->setParentDirectory($file->getParentDirectory());
    }

    public function renameFile(FileInterface $file, String $newName): FileInterface {
        rename($file->getPath(), $newPath = $file->getParentDirectory()->getPath().DIRECTORY_SEPARATOR.$newName);

        $renamedFile = new SplFileObject($newPath);

        return (new LocalDiskFile)
            ->setName($newName)
            ->setSize($renamedFile->getSize())
            ->setCreatedTime((new Datetime)->setTimestamp($renamedFile->getCTime()))
            ->setModifiedTime((new Datetime)->setTimestamp($renamedFile->getMTime()))
            ->setParentDirectory($file->getParentDirectory());
    }

    public function deleteFile(FileInterface $file): bool {
        return unlink($file->getPath());
    }

    public function createRootDirectory(DirectoryInterface $directory): DirectoryInterface {
        if( ! mkdir($directory->getName())){
            throw new Exception('Directory couldnt be created');
        }

        $newDirectory = new SplFileInfo($directory->getName());

        return (new LocalDiskDirectory)
            ->setName($directory->getName())
            ->setPath($newDirectory->getRealPath())
            ->setCreatedTime((new Datetime)->setTimestamp($newDirectory->getCTime()));
    }

    public function createDirectory(DirectoryInterface $directory, DirectoryInterface $parent): DirectoryInterface {
        if( ! mkdir($newPath = $parent->getPath().DIRECTORY_SEPARATOR.$directory->getName())){
            throw new Exception('Directory couldnt be created');
        }

        $newDirectory = new SplFileInfo($newPath);

        return (new LocalDiskDirectory)
            ->setName($directory->getName())
            ->setPath($newDirectory->getRealPath())
            ->setCreatedTime((new Datetime)->setTimestamp($newDirectory->getCTime()));
    }

    public function deleteDirectory(DirectoryInterface $directory): bool {
        return rmdir($directory->getPath());
    }

    public function renameDirectory(DirectoryInterface $directory, String $newName): DirectoryInterface {
        if( ! rename($directory->getPath(), $newPath = str_replace($directory->getName(), $newName, $directory->getPath()))){
            throw new Exception('Directory couldnt be created');
        }

        $newDirectory = new SplFileInfo($newPath);

        return (new LocalDiskDirectory)
            ->setName($directory->getName())
            ->setPath($newDirectory->getRealPath())
            ->setCreatedTime((new Datetime)->setTimestamp($newDirectory->getCTime()));
    }

    public function getDirectoryCount(DirectoryInterface $directory): int {
        $count = 0;

        foreach(new DirectoryIterator($directory->getPath()) as $element){
            if($element->isDot()) continue;
            
            if($element->getType() === 'dir'){
                $count++;
            }
        }
        
        return $count;
    }

    public function getFileCount(DirectoryInterface $directory): int {
        $count = 0;

        foreach(new DirectoryIterator($directory->getPath()) as $element){
            if($element->isDot()) continue;
            
            if($element->getType() === 'file'){
                $count++;
            }
        }
        
        return $count;
    }

    public function getDirectorySize(DirectoryInterface $directory): int {
        $size = 0;

        foreach(new DirectoryIterator($directory->getPath()) as $element){
            if($element->isDot()) continue;

            if($element->getType() === 'dir'){
                // Recursive
                $size += $this->getDirectorySize((new LocalDiskDirectory)->setPath($element->getRealPath()));
            }

            if($element->getType() === 'file'){
                $size += $element->getSize();
            }
        }
        
        return $size;
    }

    /**
     * @return DirectoryInterface[]
     */
    public function getDirectories(DirectoryInterface $directory): array {
        $directories = [];

        foreach(new DirectoryIterator($directory->getPath()) as $element){
            if($element->isDot()) continue;

            if($element->getType() === 'dir'){
                $directories[] = (new LocalDiskDirectory)
                    ->setName($element->getFilename())
                    ->setCreatedTime((new Datetime)->setTimestamp($element->getCTime()))
                    ->setPath($element->getRealPath());
            }
        }
        
        return $directories;
    }

    /**
     * @return FileInterface[]
     */
    public function getFiles(DirectoryInterface $directory): array {
        $files = [];

        foreach(new DirectoryIterator($directory->getPath()) as $element){
            if($element->isDot()) continue;
            
            if($element->getType() === 'file'){
                $files[] = (new LocalDiskFile)
                    ->setName($element->getFilename())
                    ->setSize($element->getSize())
                    ->setCreatedTime((new Datetime)->setTimestamp($element->getCTime()))
                    ->setModifiedTime((new Datetime)->setTimestamp($element->getMTime()))
                    ->setParentDirectory($directory);
            }
        }
        
        return $files;
    }
}
