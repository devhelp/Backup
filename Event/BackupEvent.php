<?php

namespace Devhelp\Component\Backup\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class BackupEvent
 * @author <michal@devhelp.pl>
 */
class BackupEvent extends Event
{
    /**
     * @var int
     */
    protected $currentIndex;

    /**
     * @var int
     */
    protected $totalFiles;

    /**
     * @var int
     */
    protected $downloadedFiles;

    /**
     * @var int
     */
    protected $errors;

    /**
     * @param int $totalFiles
     */
    public function __construct($totalFiles)
    {
        $this->totalFiles = $totalFiles;
    }

    /**
     * @return int
     */
    public function getCurrentIndex()
    {
        return $this->currentIndex;
    }

    /**
     * @param int $currentIndex
     */
    public function setCurrentIndex($currentIndex)
    {
        $this->currentIndex = $currentIndex;
    }

    /**
     * @return int
     */
    public function getTotalFiles()
    {
        return $this->totalFiles;
    }

    /**
     * @return int
     */
    public function getDownloadedFiles()
    {
        return $this->downloadedFiles;
    }

    /**
     * @param int $downloadedFiles
     */
    public function setDownloadedFiles($downloadedFiles)
    {
        $this->downloadedFiles = $downloadedFiles;
    }

    /**
     * @return int
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param int $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }
} 