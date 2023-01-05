<?php

namespace App\Http\Services\Cache;

use Illuminate\Support\Facades\Cache;

class MemoryCacheService implements ICache
{
    private  $cache;
    private int $cacheTime;

    public function __construct()
    {
        $this->cacheTime = 60;
    }


    /**
     * get
     *
     * @param  mixed $key
     * @param  mixed $default
     * @return array
     */
    public function get(string $key, $default = null)
    {
        $item =  Cache::get($key, $default);
        if (isset($item))
            return (json_decode($item));
        return $item;
    }

    public function set(string $key,  $value)
    {
        $item =   Cache::put($key, $value->toJson(), now()->addMinutes($this->cacheTime));
        return $item;
    }

    public function isSet(string $key)
    {
    }

    public function remove(string $key)
    {
    }

    public function removeByPattern(string $pattern)
    {
    }

    public function clear()
    {
    }
}
