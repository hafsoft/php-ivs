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

    private function getCacheFileName($key)
    {
        return $this->cacheDir . '/' . $key;
    }

    public function get($key)
    {
        $file = $this->getCacheFileName($key);
        if (file_exists($file)) {
            $obj = unserialize(file_get_contents($file));
            if (time() < $obj['t']) {
                return $obj['o'];
            } else {
                unlink($file);
            }
        }

        return null;
    }

    public function set($key, $value, $ttl = 0)
    {
        $file = $this->getCacheFileName($key);
        $obj = array(
            'o' => $value,
            't' => $ttl <= 0 ? 0xffffffff : time() + $ttl,
        );
        file_put_contents($file, serialize($obj));
    }

    public function remove($key)
    {
        $file = $this->getCacheFileName($key);
        if (file_exists($file))
            unlink($file);
    }
}