<?php

namespace Tsc\CatStorageSystem;

use \DateTimeInterface;

interface DirectoryInterface
{
  public function getName(): String;
  public function setName(String $name): self;
  public function getCreatedTime(): DateTimeInterface;
  public function setCreatedTime(DateTimeInterface $created): self;
  public function getPath(): String;
  public function setPath(String $path): self;
}
