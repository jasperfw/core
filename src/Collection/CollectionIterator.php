<?php
namespace JasperFW\Core\Collection;

use Iterator;
use JasperFW\Core\Exception\CollectionException;
use ReturnTypeWillChange;

/**
 * Class CollectionIterator
 *
 * Utility class to allow a collection to be iterated through in a foreach.
 *
 * @package JasperFW\Core\Collection
 */
class CollectionIterator implements Iterator
{
    /** @var Collection The collection being iterated over */
    private Collection $collection;
    /** @var int The pointer indicating the current element */
    private int $pointer = 0;
    /** @var array The keys of the collection */
    private array $keys;

    /**
     * Initialize the iterator
     *
     * @param Collection $collection
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
        $this->keys = $collection->keys();
    }

    public function rewind() : void
    {
        $this->pointer = 0;
    }

    /**
     * Check if there are unprocessed elements.
     *
     * @return bool True if there are more elements after the pointer position
     */
    public function hasMore() : bool
    {
        return $this->pointer < $this->collection->length() - 1;
    }

    /**
     * Returns the key of the element at the current position in the array.
     *
     * @return mixed The key of the element at the current position
     */
    public function key() : string
    {
        return $this->keys[$this->pointer];
    }

    /**
     * Returns the item at the current position in the collection.
     *
     * @return mixed
     * @throws CollectionException
     */
    #[ReturnTypeWillChange] public function current(): mixed
    {
        return $this->collection->getItem($this->keys[$this->pointer]);
    }

    /**
     * Advance the pointer to the next position.
     */
    public function next() : void
    {
        $this->pointer++;
    }

    /**
     * Move the pointer to the previous position.
     */
    public function previous() : void
    {
        $this->pointer--;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     *
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     *       Returns true on success or false on failure.
     */
    public function valid() : bool
    {
        if ($this->pointer >= 0 && $this->pointer < $this->collection->length()) {
            return true;
        } else {
            return false;
        }
    }
}
