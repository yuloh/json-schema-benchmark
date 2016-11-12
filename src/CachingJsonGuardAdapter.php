<?php

namespace Yuloh\JsonSchemaBenchmark;

use League;
use Redis;
use League\jsonGuard\Loaders\FileLoader;
use League\JsonGuard\Cached\CachedLoader;
use Cache\Adapter\Doctrine\DoctrineCachePool;

class CachingJsonGuardAdapter implements ValidatorAdapter
{
    private $cache;

    public function __construct()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        $cache = new \Doctrine\Common\Cache\RedisCache();
        $cache->setRedis($redis);
        $cache = new DoctrineCachePool($cache);

        $cachedLoader = new CachedLoader(new FileLoader(), $cache);

        $this->deref = new League\JsonGuard\Dereferencer();
        $this->deref->registerLoader($cachedLoader, 'file');
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
        return $this->deref->dereference('file://' . $path);

        // if ($this->cache->contains($path)) {
        //     return $this->cache->fetch($path);
        // }

        // $deref  = new League\JsonGuard\Dereferencer();
        // $schema = $deref->dereference('file://' . $path);
        // $this->cache->save($path, $schema);
        // return $schema;
    }
}
