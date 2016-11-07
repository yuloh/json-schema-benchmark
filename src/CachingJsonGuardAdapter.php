<?php

namespace Yuloh\JsonSchemaBenchmark;

use League;
use Redis;

class CachingJsonGuardAdapter implements ValidatorAdapter
{
    private $cache;

    public function __construct()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        $this->cache = new \Doctrine\Common\Cache\RedisCache();
        $this->cache->setRedis($redis);
    }

    /**
     * {@inheritdoc}
     */
    public function validate($data, $schemaPath)
    {
        $schema = $this->loadSchema($schemaPath);
        $validator = new League\JsonGuard\Validator($data, $schema);
        return $validator->passes();
    }

    private function loadSchema($path)
    {
        if ($this->cache->contains($path)) {
            return $this->cache->fetch($path);
        }

        $deref  = new League\JsonGuard\Dereferencer();
        $schema = $deref->dereference('file://' . $path);
        $this->cache->save($path, $schema);
        return $schema;
    }
}
