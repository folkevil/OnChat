<?php

declare(strict_types=1);

namespace app\core\storage\driver;

use app\contract\StorageDriver;
use app\core\Result;
use think\File;
use think\Filesystem;

/**
 * 简易的本地 存储驱动
 */
class Local implements StorageDriver
{
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    private function getRoot()
    {
        $type = $this->filesystem->getDefaultDriver();
        return $this->filesystem->getDiskConfig($type, 'root') . DIRECTORY_SEPARATOR;
    }

    public function getRootPath(): string
    {
        return '';
    }

    public function save(string $path, string $file, $data): Result
    {
        $filename = $path . $file;

        switch (true) {
            case $data instanceof File:
                $result = $this->filesystem->putFileAs($path, $data, $file);

                if ($result === false) {
                    return new Result(Result::CODE_ERROR_UNKNOWN);
                }
                break;

            case is_string($data):
                $result = file_put_contents($this->getRoot() . $filename, $data);

                if ($result === false) {
                    return new Result(Result::CODE_ERROR_UNKNOWN);
                }
                break;
        }

        return Result::success();
    }

    public function clear(string $path, int $count): void
    {
        $path = $this->getRoot() . $path;

        $dir = array_map(function ($o) use ($path) {
            return $path . $o;
        }, scandir($path));

        $dir = array_filter($dir, function ($o) {
            return is_file($o);
        });

        $num = count($dir);

        if ($num > $count) {
            // 按照时间进行升序
            usort($dir, function ($a, $b) {
                return filemtime($a) - filemtime($b);
            });

            $num -= $count;
            for ($i = 0; $i < $num; $i++) {
                unlink($dir[$i]);
            }
        }
    }

    function delete(string $filename): Result
    {
        return new Result(unlink($filename) ? Result::CODE_SUCCESS : Result::CODE_ERROR_UNKNOWN);
    }


    function getOriginalImageUrl(string $filename): string
    {
        $type = $this->filesystem->getDefaultDriver();
        return '/onchat' . $this->filesystem->getDiskConfig($type, 'url') . '/' . $filename;
    }

    function getThumbnailImageUrl(string $filename): string
    {
        $type = $this->filesystem->getDefaultDriver();
        return '/onchat' . $this->filesystem->getDiskConfig($type, 'url') . '/' . $filename;
    }
}