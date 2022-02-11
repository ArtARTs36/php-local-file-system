<?php

namespace ArtARTs36\FileSystem\Local;

use ArtARTs36\FileSystem\Contracts\FileNotFound;
use ArtARTs36\FileSystem\Contracts\FileSystem;

class LocalFileSystem implements FileSystem
{
    /** @var callable|string */
    protected $fileDateGetter;

    public function __construct(?callable $fileDateGetter = null)
    {
        $this->fileDateGetter = $fileDateGetter ?? 'filemtime';
    }

    public function removeFile(string $path): bool
    {
        $this->raiseFileNotFoundIfNotExists($path);

        return unlink($path);
    }

    public function removeDir(string $path): bool
    {
        if (! $this->exists($path)) {
            return true;
        }

        if (is_file($path)) {
            return $this->removeFile($path);
        }

        if (is_dir($path)) {
            foreach ($this->getFromDirectory($path) as $file) {
                $this->removeDir($file);
            }

            return rmdir($path);
        }

        return true;
    }

    /**
     * @return array<string>
     */
    public function getFromDirectory(string $path): array
    {
        $path = rtrim($path, DIRECTORY_SEPARATOR);

        return array_values(array_map(function (string $file) use ($path) {
            return $path . DIRECTORY_SEPARATOR . $file;
        }, array_diff(scandir($this->getAbsolutePath($path)), ['.', '..'])));
    }

    public function downPath(string $path): string
    {
        if ($this->exists($path)) {
            return $this->getAbsolutePath($path . '/../');
        }

        return dirname($path);
    }

    public function createDir(string $path, int $permissions = 0755): bool
    {
        if (! $this->exists($path)) {
            return mkdir($path, $permissions, true);
        }

        return true;
    }

    public function exists(string $path): bool
    {
        return file_exists($path);
    }

    public function createFile(string $path, string $content): bool
    {
        return file_put_contents($path, $content) !== false;
    }

    public function getFileContent(string $path): string
    {
        $this->raiseFileNotFoundIfNotExists($path);

        return file_get_contents($path); // @phpstan-ignore-line
    }

    public function getLastUpdateDate(string $path): \DateTimeInterface
    {
        $this->raiseFileNotFoundIfNotExists($path);

        $dateGetter = $this->fileDateGetter;

        return (new \DateTime())->setTimestamp($dateGetter($path));
    }

    public function getAbsolutePath(string $path): string
    {
        $this->raiseFileNotFoundIfNotExists($path);

        return realpath($path); // @phpstan-ignore-line
    }

    public function getTmpDir(): string
    {
        return sys_get_temp_dir();
    }

    /**
     * @throws FileNotFound
     */
    protected function raiseFileNotFoundIfNotExists(string $path): void
    {
        if (! $this->exists($path)) {
            throw new LocalFileNotFound($path);
        }
    }
}
