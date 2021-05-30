<?php

namespace Tsc\CatStorageSystem;

use PHPUnit\Framework\TestCase;
use DateTime;

class LocalDiskFileTest extends TestCase {
    public function test_it_can_get_and_set_name(){
        $file = new LocalDiskFile;

        $file->setName($exampleName = 'cv.pdf');

        $this->assertEquals($exampleName, $file->getName());
    }

    public function test_it_can_get_and_set_size(){
        $file = new LocalDiskFile;

        $file->setSize($exampleSize = 200);

        $this->assertEquals($exampleSize, $file->getSize());
    }

    public function test_it_can_get_and_set_created_time(){
        $file = new LocalDiskFile;

        $file->setCreatedTime($exampleCreatedTime = new Datetime);

        $this->assertEquals($exampleCreatedTime->getTimestamp(), $file->getCreatedTime()->getTimestamp());
    }

    public function test_it_can_get_and_set_modified_time(){
        $file = new LocalDiskFile;

        $file->setModifiedTime($exampleModifiedTime = new Datetime);

        $this->assertEquals($exampleModifiedTime->getTimestamp(), $file->getModifiedTime()->getTimestamp());
    }

    public function test_it_can_get_and_set_parent_directory(){
        $file = new LocalDiskFile;

        $file->setParentDirectory($exampleParentDirectory = new LocalDiskDirectory);

        $this->assertEquals($exampleParentDirectory, $file->getParentDirectory());
    }
}