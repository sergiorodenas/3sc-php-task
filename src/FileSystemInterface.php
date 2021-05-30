<?php

namespace Tsc\CatStorageSystem;

interface FileSystemInterface
{
  public function createFile(FileInterface $file, DirectoryInterface $parent): FileInterface;
  public function updateFile(FileInterface $file): FileInterface;
  public function renameFile(FileInterface $file, String $newName): FileInterface;
  public function deleteFile(FileInterface $file): bool;
  public function createRootDirectory(DirectoryInterface $directory): DirectoryInterface;
  public function createDirectory(DirectoryInterface $directory, DirectoryInterface $parent): DirectoryInterface;
  public function deleteDirectory(DirectoryInterface $directory): bool;
  public function renameDirectory(DirectoryInterface $directory, String $newName): DirectoryInterface;
  public function getDirectoryCount(DirectoryInterface $directory): int;
  public function getFileCount(DirectoryInterface $directory): int;
  public function getDirectorySize(DirectoryInterface $directory): int;

  /**
   * @return DirectoryInterface[]
   */
  public function getDirectories(DirectoryInterface $directory): array;

  /**
   * @return FileInterface[]
   */
  public function getFiles(DirectoryInterface $directory): array;
}
