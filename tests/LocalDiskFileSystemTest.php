<?php

namespace Tsc\CatStorageSystem;

use PHPUnit\Framework\TestCase;
use SplFileObject;
use Datetime;

class LocalDiskFileSystemTest extends TestCase {
    public function test_it_can_be_created(){
        $this->assertTrue(new LocalDiskFileSystem instanceof LocalDiskFileSystem);
    }

    public function test_it_can_create_a_file(){
        $folder = new LocalDiskDirectory;
        $folder->setPath('images');

        $file = new LocalDiskFile;
        $file->setName('cat_4.gif');
        
        $filesystem = new LocalDiskFileSystem;
        $newFile = $filesystem->createFile($file, $folder);

        $this->assertFileExists($newFile->getPath());

        unlink($newFile->getPath());
    }

    public function test_it_can_update_a_file(){
        new SplFileObject('images/cat_4.gif', 'w');

        sleep(0.01);
        
        $folder = new LocalDiskDirectory;
        $folder->setPath('images');

        $file = new LocalDiskFile;
        $file->setName('cat_4.gif');
        $file->setParentDirectory($folder);

        $testFile = new SplFileObject($folder->getPath().DIRECTORY_SEPARATOR.$file->getName());
        $oldModifiedTime = (new DateTime($testFile->getMTime()))->getTimestamp();
        
        $filesystem = new LocalDiskFileSystem;
        $updatedFile = $filesystem->updateFile($file, $folder);

        $newModifiedTime = $updatedFile->getModifiedTime()->getTimestamp();

        $this->assertTrue($oldModifiedTime !== $newModifiedTime);
    }

    public function test_it_can_rename_a_file(){
        $folder = new LocalDiskDirectory;
        $folder->setPath('images');

        $file = new LocalDiskFile;
        $file->setName('cat_1.gif');
        $file->setParentDirectory($folder);
        
        $filesystem = new LocalDiskFileSystem;
        $newFile = $filesystem->renameFile($file, $newFileName = 'cat_4.gif');

        $this->assertEquals($newFileName, $newFile->getName());
        $this->assertFileExists($newFile->getPath());

        rename($newFile->getPath(), $file->getParentDirectory()->getPath().DIRECTORY_SEPARATOR.'cat_1.gif');
    }

    public function test_it_can_delete_a_file(){
        new SplFileObject('images/cat_4.gif', 'w');
        
        $folder = new LocalDiskDirectory;
        $folder->setPath('images');

        $file = new LocalDiskFile;
        $file->setName('cat_4.gif');
        $file->setParentDirectory($folder);
        
        $filesystem = new LocalDiskFileSystem;

        $this->assertFileExists($file->getPath());

        $this->assertTrue($filesystem->deleteFile($file));

        $this->assertFileNotExists($file->getPath());
    }

    public function test_it_can_create_a_directory_on_current_folder(){
        $filesystem = new LocalDiskFileSystem;

        $folder = new LocalDiskDirectory;
        $folder->setName('first_folder');

        $newFolder = $filesystem->createRootDirectory($folder);

        $this->assertDirectoryExists($newFolder->getPath());

        rmdir($newFolder->getPath());
    }

    public function test_it_can_create_a_directory_on_a_directory(){
        $filesystem = new LocalDiskFileSystem;

        $folder = new LocalDiskDirectory;
        $folder->setPath('images');

        $folderToCreate = new LocalDiskDirectory;
        $folderToCreate->setName('second_folder');

        $newFolder = $filesystem->createDirectory($folderToCreate, $folder);

        $this->assertDirectoryExists($newFolder->getPath());

        rmdir($newFolder->getPath());
    }

    public function test_it_can_delete_a_directory(){
        mkdir('images/third_folder');

        $filesystem = new LocalDiskFileSystem;

        $folder = new LocalDiskDirectory;
        $folder->setPath('images/third_folder');

        $filesystem->deleteDirectory($folder);

        $this->assertDirectoryNotExists($folder->getPath());
    }

    public function test_it_can_rename_a_directory(){
        mkdir('images/sergio');

        $filesystem = new LocalDiskFileSystem;

        $folder = new LocalDiskDirectory;
        $folder->setName('sergio');
        $folder->setPath('images/sergio');

        $renamedFolder = $filesystem->renameDirectory($folder, 'rodenas');

        $this->assertDirectoryNotExists($folder->getPath());
        $this->assertDirectoryExists($renamedFolder->getPath());

        rmdir('images/rodenas');
    }

    public function test_it_can_count_directories_on_a_directory(){
        mkdir('images/other');
        mkdir('images/test');

        $filesystem = new LocalDiskFileSystem;

        $folder = new LocalDiskDirectory;
        $folder->setPath('images');

        $count = $filesystem->getDirectoryCount($folder);

        $this->assertEquals(2, $count);

        rmdir('images/other');
        rmdir('images/test');
    }

    public function test_it_can_count_files_on_a_directory(){
        $filesystem = new LocalDiskFileSystem;

        $folder = new LocalDiskDirectory;
        $folder->setPath('images');

        $count = $filesystem->getFileCount($folder);

        $this->assertEquals(3, $count);
    }

    public function test_it_can_get_the_size_of_a_directory(){
        $filesystem = new LocalDiskFileSystem;

        $folder = new LocalDiskDirectory;
        $folder->setPath('images');

        $size = $filesystem->getDirectorySize($folder);
        
        $this->assertEquals(23310572, $size);
    }

    public function test_it_can_get_directories_from_a_directory(){
        mkdir('images/other');
        mkdir('images/test');
        
        $filesystem = new LocalDiskFileSystem;

        $folder = new LocalDiskDirectory;
        $folder->setPath('images');

        $folderNames = ['other', 'test'];

        foreach($filesystem->getDirectories($folder) as $foundDirectory){
            $this->assertTrue(in_array($foundDirectory->getName(), $folderNames));
        }

        rmdir('images/other');
        rmdir('images/test');
    }

    public function test_it_can_get_files_from_a_directory(){
        $filesystem = new LocalDiskFileSystem;

        $folder = new LocalDiskDirectory;
        $folder->setPath('images');

        $fileNames = ['cat_1.gif', 'cat_2.gif', 'cat_3.gif'];

        foreach($filesystem->getFiles($folder) as $foundFile){
            $this->assertTrue(in_array($foundFile->getName(), $fileNames));
        }
    }
}