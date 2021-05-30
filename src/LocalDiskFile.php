<?php

namespace Tsc\CatStorageSystem;

use DateTime;
use DateTimeInterface;

class LocalDiskFile implements FileInterface
{
    protected String $name;
    protected int $size;
    protected DateTime $created_time;
    protected DateTime $modified_time;
    protected LocalDiskDirectory $parent_directory;

    public function getName(): String {
        return $this->name;
    }

    public function setName(String $name): self {
        $this->name = $name;
        return $this;
    }

    public function getSize(): int {
        return $this->size;
    }

    public function setSize(int $size): self {
        $this->size = $size;
        return $this;
    }

    public function getCreatedTime(): DateTime {
        return $this->created_time;
    }

    public function setCreatedTime(DateTimeInterface $created): self {
        $this->created_time = new DateTime('now', $created->getTimezone());
        $this->created_time->setTimestamp($created->getTimestamp());
        return $this;
    }

    public function getModifiedTime(): DateTimeInterface {
        return $this->modified_time;
    }

    public function setModifiedTime(DateTimeInterface $modified): self {
        $this->modified_time = new DateTime('now', $modified->getTimezone());
        $this->modified_time->setTimestamp($modified->getTimestamp());
        return $this;
    }

    public function getParentDirectory(): DirectoryInterface {
        return $this->parent_directory;
    }

    public function setParentDirectory(DirectoryInterface $parent): self {
        $this->parent_directory = $parent;
        return $this;
    }

    public function getPath(): String {
        return $this->parent_directory->getPath().DIRECTORY_SEPARATOR.$this->getName();
    }
}
