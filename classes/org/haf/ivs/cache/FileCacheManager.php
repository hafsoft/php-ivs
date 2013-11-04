<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 2:41 PM
 */

namespace org\haf\ivs\cache;


class FileCacheManager extends AbstractCacheManager implements ICacheManager
{
    private $cacheDir;

    public function setCacheDir($dir)
    {
        $this->cacheDir = $dir;
        if (!is_dir($dir)) {
            mkdir($dir);
        }
    }

    private function getCacheName($key)
    {
        return $this->cacheDir . '/' . $key;
    }

    public function get($key)
    {
        $file = $this->getCacheName($key);
        if (file_exists($file)) {
            return unserialize(file_get_contents($file));
        } else
            return null;
    }

    public function set($key, $value)
    {
        $file = $this->getCacheName($key);
        file_put_contents($file, serialize($value));
    }

    public function remove($key)
    {
        $file = $this->getCacheName($key);
        if (file_exists($file))
            unlink($file);
    }
}