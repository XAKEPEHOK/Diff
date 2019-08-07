<?php
/**
 * @author Timur Kasumov (aka XAKEPEHOK)
 * Datetime: 07.08.2019 12:46
 */

namespace XAKEPEHOK\Diff\Components\Iterator;


class KeyValueEscort
{

    /**
     * @var KeyValue|null
     */
    private $prev;
    /**
     * @var KeyValue
     */
    private $current;
    /**
     * @var KeyValue|null
     */
    private $next;

    public function __construct(?KeyValue $prev, KeyValue $current, ?KeyValue $next)
    {
        $this->prev = $prev;
        $this->current = $current;
        $this->next = $next;
    }

    /**
     * @return KeyValue|null
     */
    public function getPrev(): ?KeyValue
    {
        return $this->prev;
    }

    /**
     * @return KeyValue
     */
    public function getCurrent(): KeyValue
    {
        return $this->current;
    }

    /**
     * @return KeyValue|null
     */
    public function getNext(): ?KeyValue
    {
        return $this->next;
    }

}