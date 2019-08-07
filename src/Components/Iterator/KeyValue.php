<?php
/**
 * @author Timur Kasumov (aka XAKEPEHOK)
 * Datetime: 07.08.2019 12:35
 */

namespace XAKEPEHOK\Diff\Components\Iterator;


class KeyValue
{

    private $key;
    private $value;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    public static function fromArray($key, $array): self
    {
        return new self($key, $array[$key]);
    }

}