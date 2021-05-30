<?php

namespace Tsc\CatStorageSystem;

use DateTimeInterface;

class LocalDiskDirectory implements DirectoryInterface
{
    protected String $name;
    protected DateTimeInterface $created_time;
    protected String $path;

    public function getName(): String {
        return $this->name;
    }

    public function setName(String $name): self {
        $this->name = $name;
        return $this;
    }

    public function getCreatedTime(): DateTimeInterface {
        return $this->created_time;
    }

    public function setCreatedTime(DateTimeInterface $created): self {
        $this->created_time = $created;
        return $this;
    }

    public function getPath(): String {
        return $this->path;
    }

    public function setPath(String $path): self {
        $this->path = $path;
        return $this;
    }
}
