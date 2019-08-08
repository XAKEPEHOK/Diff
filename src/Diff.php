<?php
/**
 * @author Timur Kasumov (aka XAKEPEHOK)
 * Datetime: 07.08.2019 12:34
 */

namespace XAKEPEHOK\Diff;


use XAKEPEHOK\Diff\Components\ArrayPusher;
use XAKEPEHOK\Diff\Components\Iterator\KeyValue;
use XAKEPEHOK\Diff\Components\State;
use XAKEPEHOK\Diff\Components\Iterator\EscortIterator;

class Diff
{

    /**
     * @var callable
     */
    protected $hasher;

    public function __construct(callable $hasher = null)
    {
        if (is_null($hasher)) {
            $hasher = function (array $array) {
                return md5(json_encode($array));
            };
        }
        $this->hasher = $hasher;
    }

    public function calc(array $left, array $right): array
    {
        $left = $this->arrayIndexByHash($left);
        $right = $this->arrayIndexByHash($right);

        $leftEscortIterator = new EscortIterator($left);
        $rightEscortIterator = new EscortIterator($right);

        $data = [];

        foreach ($leftEscortIterator as $leftEscort) {
            $deleted = true;

            foreach ($rightEscortIterator as $rightEscort) {
                $sameCurrent = $leftEscort->getCurrent()->getKey() == $rightEscort->getCurrent()->getKey();

                if ($sameCurrent) {
                    $deleted = false;
                    $data[$leftEscort->getCurrent()->getKey()] = new State(
                        State::OPERATION_NONE,
                        $rightEscort
                    );
                }
            }

            if ($deleted) {
                $data[$leftEscort->getCurrent()->getKey()] = new State(
                    State::OPERATION_DELETED,
                    $leftEscort
                );
            }
        }


        foreach ($rightEscortIterator as $rightEscort) {
            $inserted = true;

            foreach ($leftEscortIterator as $leftEscort) {
                $sameCurrent = $leftEscort->getCurrent()->getKey() == $rightEscort->getCurrent()->getKey();
                if ($sameCurrent) {
                    $inserted = false;
                    break;
                }
            }

            if ($inserted) {
                $data[$rightEscort->getCurrent()->getKey()] = new State(
                    State::OPERATION_INSERTED,
                    $rightEscort
                );
            }
        }

        $data = $this->sort($data);
        return $data;
    }

    /**
     * @param State[] $array
     * @return array
     */
    protected function sort($array)
    {
        $pusher = new ArrayPusher();
        while (!empty($array)) {
            foreach ($array as $key => $state) {
                $prev = $this->getKeyOrNull($state->getEscort()->getPrev());
                $next = $this->getKeyOrNull($state->getEscort()->getNext());

                $pushed = false;
                $value = [
                    'state' => $state->getOperation(),
                    'value' => $state->getEscort()->getCurrent()->getValue(),
                ];

                if ($prev) {
                    $pushed = $pusher->pushAfter($prev, $key, $value);
                }

                if ($next && !$pushed) {
                    $pushed = $pusher->pushBefore($next, $key, $value);
                }

                if ($pushed) {
                    unset($array[$key]);
                }
            }
        }

        $array = $pusher->getArray();

        do {
            $swapCount = 0;
            $keys = array_keys($array);
            for ($i = 0; $i < count($keys); $i++) {
                if ($i > 0) {
                    $prevKey = $keys[$i - 1];
                    $nextKey = $keys[$i];

                    $prevState = $array[$prevKey]['state'];
                    $nextState = $array[$nextKey]['state'];

                    if ($prevState == State::OPERATION_INSERTED && $nextState == State::OPERATION_DELETED) {
                        $swapCount++;
                        $array = $this->arraySwapKeys($array, $prevKey, $nextKey);
                        break;
                    }
                }
            }
        } while ($swapCount > 0);

        return  $array;
    }

    protected function arrayIndexByHash(array $array): array
    {
        $result = [];
        foreach ($array as $data) {
            $hash = ($this->hasher)($data);
            $result[$hash] = $data;
        }
        return $result;
    }

    private function arraySwapKeys(array $array, $key_1, $key_2): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            if ($key == $key_1) {
                $result[$key_1] = $array[$key_2];
            } elseif ($key == $key_2) {
                $result[$key_2] = $array[$key_1];
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    private function getKeyOrNull(?KeyValue $keyValue)
    {
        if (is_null($keyValue)) {
            return null;
        }
        return $keyValue->getKey();
    }


}