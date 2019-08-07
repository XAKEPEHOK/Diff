<?php
/**
 * @author Timur Kasumov (aka XAKEPEHOK)
 * Datetime: 07.08.2019 14:51
 */

namespace XAKEPEHOK\Diff\Components;


class ArrayPusher
{

    /**
     * @var array
     */
    private $array;

    public function __construct()
    {
        $this->array = [];
    }

    public function pushBefore(string $beforeKey, string $key, $value): bool
    {
        if (empty($this->array)) {
            $this->array[$key] = $value;
            return true;
        }

        if (!array_key_exists($beforeKey, $this->array)) {
            return false;
        }

        $modified = [];
        foreach ($this->array as $arrayKey => $arrayValue) {
            if ($arrayKey == $beforeKey) {
                $modified[$key] = $value;
            }
            $modified[$arrayKey] = $arrayValue;
        }

        $this->array = $modified;
        return true;
    }

    public function pushAfter(string $afterKey, string $key, $value): bool
    {
        if (empty($this->array)) {
            $this->array[$key] = $value;
            return true;
        }

        if (!array_key_exists($afterKey, $this->array)) {
            return false;
        }

        $modified = [];
        foreach ($this->array as $arrayKey => $arrayValue) {
            $modified[$arrayKey] = $arrayValue;
            if ($arrayKey == $afterKey) {
                $modified[$key] = $value;
            }
        }

        $this->array = $modified;
        return true;
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        return $this->array;
    }


}