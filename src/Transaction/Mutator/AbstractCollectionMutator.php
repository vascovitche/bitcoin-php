<?php

namespace BitWasp\Bitcoin\Transaction\Mutator;

abstract class AbstractCollectionMutator implements \Iterator, \ArrayAccess, \Countable
{
    protected ?\Iterator $iter = null;

    /**
     * @var \SplFixedArray
     */
    protected $set;

    /**
     * @return array
     */
    public function all()
    {
        return $this->set->toArray();
    }

    /**
     * @return bool
     */
    public function isNull()
    {
        return count($this->set) === 0;
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->set->count();
    }

    /**
     *
     */
    public function rewind()
    {
        $this->iter = $this->set->getIterator();
        $this->iter->rewind();
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->iterator()->current();
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->iterator()->key();
    }

    /**
     *
     */
    public function next()
    {
        $this->iterator()->next();
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return $this->iterator()->valid();
    }

    /**
     * @param int $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->set->offsetExists($offset);
    }

    /**
     * @param int $offset
     */
    public function offsetUnset($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new \InvalidArgumentException('Offset does not exist');
        }

        $this->set->offsetUnset($offset);
    }

    /**
     * @param int $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if (!$this->set->offsetExists($offset)) {
            throw new \OutOfRangeException('Nothing found at this offset');
        }
        return $this->set->offsetGet($offset);
    }

    /**
     * @param int $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->set->offsetSet($offset, $value);
    }

    protected function iterator(): \Iterator
    {
        if ($this->iter === null) {
            $this->iter = $this->set->getIterator();
        }

        return $this->iter;
    }
}
