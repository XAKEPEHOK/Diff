<?php
/**
 * @author Timur Kasumov (aka XAKEPEHOK)
 * Datetime: 07.08.2019 12:50
 */

namespace XAKEPEHOK\Diff\Components\Iterator;


use Iterator;

class EscortIterator implements Iterator
{

    /**
     * @var array
     */
    private $array;

    /**
     * @var array
     */
    private $keys;

    private $index = 0;

    public function __construct(array $array)
    {
        $this->array = $array;
        $this->keys = array_keys($array);
    }

    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return KeyValueEscort
     * @since 5.0.0
     */
    public function current()
    {
        $prev = null;
        if ($this->index > 0) {
            $prev = KeyValue::fromArray($this->keys[$this->index - 1], $this->array);
        }

        $current = KeyValue::fromArray($this->keys[$this->index], $this->array);

        $next = null;
        if ($this->index + 1 < count($this->keys)) {
            $next = KeyValue::fromArray($this->keys[$this->index + 1], $this->array);
        }

        return new KeyValueEscort($prev, $current, $next);
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->index++;
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->keys[$this->index];
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return array_key_exists($this->index, $this->keys);
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->index = 0;
    }
}