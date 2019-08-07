<?php
/**
 * @author Timur Kasumov (aka XAKEPEHOK)
 * Datetime: 07.08.2019 14:09
 */

namespace XAKEPEHOK\Diff\Components;


use XAKEPEHOK\Diff\Components\Iterator\KeyValueEscort;

class State
{

    const OPERATION_NONE = 'none';
    const OPERATION_DELETED = 'deleted';
    const OPERATION_INSERTED = 'inserted';
    /**
     * @var string
     */
    private $operation;
    /**
     * @var KeyValueEscort
     */
    private $escort;

    public function __construct(string $operation, KeyValueEscort $escort)
    {
        $this->operation = $operation;
        $this->escort = $escort;
    }

    /**
     * @return string
     */
    public function getOperation(): string
    {
        return $this->operation;
    }

    /**
     * @return KeyValueEscort
     */
    public function getEscort(): KeyValueEscort
    {
        return $this->escort;
    }

}