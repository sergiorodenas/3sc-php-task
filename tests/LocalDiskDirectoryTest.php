<?php

namespace Tsc\CatStorageSystem;

use DateTime;
use PHPUnit\Framework\TestCase;

class LocalDiskDirectoryTest extends TestCase {
    public function test_it_can_be_created(){
        $this->assertTrue(new LocalDiskDirectory instanceof LocalDiskDirectory);
    }

    public function test_it_can_get_and_set_name(){
        $directory = new LocalDiskDirectory;

        $directory->setName($exampleName = 'hello 3sc');

        $this->assertEquals($exampleName, $directory->getName());
    }

    public function test_it_can_get_and_set_created_time(){
        $directory = new LocalDiskDirectory;

        $directory->setCreatedTime($exampleDate = new DateTime);

        $this->assertEquals($exampleDate, $directory->getCreatedTime());
    }

    public function test_it_can_get_and_set_path(){
        $directory = new LocalDiskDirectory;

        $directory->setPath($examplePath = '/home/sergio');

        $this->assertEquals($examplePath, $directory->getPath());
    }
}