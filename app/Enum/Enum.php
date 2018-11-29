<?php

namespace App\Enum;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use ReflectionClass;
use Illuminate\Support\Collection;

abstract class Enum
{

    /** @var Collection $repo */
    protected $repo;

    public function __construct()
    {
        $reflector  =   new ReflectionClass(static::class);
        $this->repo =   collect($reflector->getConstants());
    }

    public function normalizer(string $key)
    {
        return mb_strtoupper($key, 'UTF-8');
    }

    public function is_assoc($var)
    {
        return is_array($var) && array_diff_key($var, array_keys(array_keys($var)));
    }

    public function get(string  $key)
    {
        $output =   $this->repo->get($this->normalizer($key));
        if ($this->is_assoc($output)) {
            return (object) $output;
        }
        return $output;
    }

    public function all()   :   array
    {
        return $this->repo->all();
    }

    public function jsonSerialize()
    {
        return static::all();
    }
}
