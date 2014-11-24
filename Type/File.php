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
     * @param File $file
     * @return bool
     */
    public function equals(File $file)
    {
        return (string) $this === (string) $file;
    }
}
