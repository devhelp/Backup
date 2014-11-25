<?php

namespace Devhelp\Component\Backup\Type;

/**
 * File value object
 *
 * @author <michal@devhelp.pl>
 */
class File
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return pathinfo($this->path, PATHINFO_FILENAME);
    }

    /**
     * @return string
     */
    public function getDirName()
    {
        return pathinfo($this->path, PATHINFO_DIRNAME);
    }

    /**
     * @return string
     */
    public function getBasename()
    {
        return pathinfo($this->path, PATHINFO_BASENAME);
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }

    /**
     * @param File $file
     * @return bool
     */
    public function equals(File $file)
    {
        return (string) $this === (string) $file;
    }
}
