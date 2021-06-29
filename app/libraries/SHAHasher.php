<?php


namespace App\libraries;


use Illuminate\Contracts\Hashing\Hasher;

class SHAHasher implements Hasher
{

    public function info($hashedValue)
    {
        $this->driver()->info($hashedValue);
    }

    public function make($value, array $options = [])
    {
        return hash('sha1', $value);
    }

    public function check($value, $hashedValue, array $options = [])
    {
        return $this->make($value) === $hashedValue;
    }

    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }
}
