<?php

namespace ArtARTs36\FileSystem\Local;

use ArtARTs36\FileSystem\Contracts\FileNotFound;
use Throwable;

class LocalFileNotFound extends \Exception implements FileNotFound
{
    /** @var string */
    private $invalidFilePath;

    public function __construct(string $invalidFilePath, int $code = 0, Throwable $previous = null)
    {
        $this->invalidFilePath = $invalidFilePath;

        parent::__construct("File '$invalidFilePath' not found!", $code, $previous);
    }

    public function getInvalidFilePath(): string
    {
        return $this->invalidFilePath;
    }
}
