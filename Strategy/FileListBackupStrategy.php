<?php

namespace Devhelp\Component\Backup\Strategy;

use Devhelp\Component\Backup\Type\File;
use League\Flysystem\FilesystemInterface;

/**
 * Class FileListBackupStrategy
 *
 * @author <michal@devhelp.pl>
 */
class FileListBackupStrategy implements BackupStrategyInterface
{

    /**
     * @var FilesystemInterface
     */
    private $remoteFilesystem;

    /**
     * @var array
     */
    private $ignoredDirectories = array();

    /**
     * @var File[]
     */
    private $ignoredFiles = array();

    /**
     * @var array
     */
    private $ignoredExtensions = array();

    /**
     * @param FilesystemInterface $remoteFilesystem
     */
    public function setRemoteAdapter(FilesystemInterface $remoteFilesystem)
    {
        $this->remoteFilesystem = $remoteFilesystem;
    }

    /**
     * @param $ignoredDirectory
     * @return $this
     */
    public function addIgnoredDirectory($ignoredDirectory)
    {
        $this->ignoredDirectories[] = $ignoredDirectory;

        return $this;
    }

    /**
     * @param File $ignoredFile
     * @return $this
     */
    public function addIgnoredFiles(File $ignoredFile)
    {
        $this->ignoredFiles[] = $ignoredFile;

        return $this;
    }

    /**
     * @param $ignoredExtension
     * @return $this
     */
    public function addIgnoredExtension($ignoredExtension)
    {
        $this->ignoredExtensions[] = $ignoredExtension;

        return $this;
    }

    /**
     * @return File[]
     */
    public function getFileList()
    {
        $list = array();

        foreach ($this->remoteFilesystem->listFiles('', true) as $file) {
            $file = new File($file['path']);

            if ($this->isValidFile($file)) {
                $list[] = $file;
            }
        }

        return $list;
    }

    /**
     * @param File $file
     * @return bool
     */
    private function isValidFile(File $file)
    {
        if (
            in_array($file, $this->ignoredFiles) ||
            in_array($file->getExtension(), $this->ignoredExtensions) ||
            $this->validateDirectories($file->getDirName())
        ) {
            return false;
        }

        return true;
    }

    /**
     * @param string $dirName
     * @return bool
     */
    private function validateDirectories($dirName)
    {
        foreach ($this->ignoredDirectories as $ignoredDirectory) {
            if (strpos($dirName."/", $ignoredDirectory, 0) !== false) {
                return true;
            }
        }

        return false;
    }

}
