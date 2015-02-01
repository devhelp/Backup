<?php

namespace Devhelp\Backup\Type;

/**
 * @author <michal@devhelp.pl>
 */
class RemoteResource
{
    const TYPE_FILE = 'file';
    const TYPE_DIRECTORY = 'dir';

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $type;

    public function __construct($path, $type = self::TYPE_FILE)
    {
        $this->path = $path;
        $this->type = $type;
    }

    public function __toString()
    {
        return $this->path;
    }

    public function getName()
    {
        return pathinfo($this->path, PATHINFO_FILENAME);
    }

    public function getDirName()
    {
        if ($this->type === self::TYPE_FILE) {
            return pathinfo($this->path, PATHINFO_DIRNAME);
        }

        return pathinfo($this->path, PATHINFO_FILENAME);
    }

    public function getBasename()
    {
        return pathinfo($this->path, PATHINFO_BASENAME);
    }

    public function getExtension()
    {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }

    public function equals(RemoteResource $resource)
    {
        return (string)$this === (string)$resource;
    }

    public function getType()
    {
        return $this->type;
    }
}
