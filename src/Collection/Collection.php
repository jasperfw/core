<?php
namespace JasperFW\Core\Collection;

use IteratorAggregate;
use JasperFW\Core\Exception\CollectionException;

/**
 * Class Collection
 *
 * Collection handler. Models can extend this to allow iterating through members.
 *
 * @package JasperFW\Core\Collection
 */
class Collection implements IteratorAggregate
{
    protected $members = array();
    protected $onload;
    protected $is_loaded = false;

    /**
     * Set up the collection
     */
    public function __construct()
    {
        $this->members = array();
    }

    /**
     * Adds a new member to the collection
     *
     * @param mixed $object The object being added
     * @param null|string|int $key The key for the object being added
     *
     * @throws CollectionException
     */
    public function addItem($object, ?string $key = null) : void
    {
        $this->checkCallback();

        if (null !== $key) {
            if (isset($this->members[$key])) {
                throw new CollectionException('Unable to add to collection - key ' . $key . ' already used.');
            } else {
                $this->members[$key] = $object;
            }
        } else {
            $this->members[] = $object;
        }
    }

    /**
     * Add the specified object after the indicated key.
     *
     * @param mixed $object The object being added
     * @param string $previous_key The key that the item should be added after
     * @param string|null $key The key for the new element
     *
     * @throws CollectionException
     */
    public function addItemAfter($object, string $previous_key, ?string $key = null) : void
    {
        // If the previous key doesn't exist, just add the item to the end.
        if (!isset($this->members[$previous_key])) {
            $this->addItem($object, $key);
            return;
        }
        $position = array_search($previous_key, array_keys($this->members));
        $this->arrayInsert($object, $key, $position + 1);
    }

    /**
     * Add the object before the specified item.
     *
     * @param mixed $object The object being added
     * @param string $latter_key The key the object should be added before
     * @param string|null $key The key of the new object.
     *
     * @throws CollectionException
     */
    public function addItemBefore($object, string $latter_key, ?string $key = null) : void
    {
        // If the latter key doesn't exist, just add the item to the end.
        if (!isset($this->members[$latter_key])) {
            $this->arrayInsert($object, $key, 0);
            return;
        }
        $position = array_search($latter_key, array_keys($this->members));
        $this->arrayInsert($object, $key, $position);
    }

    /**
     * Add the object at a designated position in the array.
     *
     * @param mixed $object The object to add
     * @param string $key The key of the new object
     * @param int $position The position at which to add the object
     */
    private function arrayInsert($object, string $key, int $position) : void
    {
        if (0 == count($this->members)) {
            // The array is empty so just add the item
            $this->members[$key] = $object;
        } elseif ($position == count($this->members)) {
            // The item goes at the end of the array
            $this->members[$key] = $object;
        } else {
            $this->members = array_slice($this->members, 0, $position,
                    true) + array($key => $object) + array_slice($this->members, $position, null, true);
        }
    }

    /**\
     * Remove the item specified by the key from the collection
     *
     * @param string $key
     *
     * @throws CollectionException
     */
    public function removeItem(string $key) : void
    {
        $this->checkCallback();
        if (isset($this->members[$key])) {
            unset($this->members[$key]);
        }
    }

    /**
     * Returns the item represented by the key
     *
     * @param $key
     *
     * @return mixed
     * @throws CollectionException
     */
    public function getItem(string $key)
    {
        $this->checkCallback();
        if (isset($this->members[$key])) {
            return $this->members[$key];
        } else {
            throw new CollectionException('Unable to retrieve item from collection - key ' . $key . ' not found.');
        }
    }

    /**
     * Returns an array of keys in use
     *
     * @return array
     */
    public function keys() : array
    {
        $this->checkCallback();
        return array_keys($this->members);
    }

    /**
     * Returns the number of elements in the collection
     *
     * @return int
     */
    public function length() : int
    {
        $this->checkCallback();
        return sizeof($this->members);
    }

    /**
     * Checks if the key is in use
     *
     * @param string $key The name of the variable to check
     *
     * @return bool
     */
    public function exists(string $key) : bool
    {
        $this->checkCallback();
        return isset($this->members[$key]);
    }

    /**
     * Enable isset checking for form elements.
     *
     * @param string $key The name of the variable to check
     *
     * @return bool
     */
    public function __isset(string $key) : bool
    {
        return $this->exists($key);
    }

    /**
     * Specify a callback to be called to load the collection.
     * TODO: Figure out how to declare the arguments
     *
     * @param string $function_name
     * @param null $obj_or_class
     *
     * @throws CollectionException
     */
    public function setLoadCallback($function_name, $obj_or_class = null) : void
    {
        if ($obj_or_class) {
            $callback = array($obj_or_class, $function_name);
        } else {
            $callback = $function_name;
        }
        // Make sure the function is valid
        if (!is_callable($callback, false, $callableName)) {
            throw new CollectionException('Invalid callback specified.');
        }
        $this->onload = $callback;
    }

    /**
     * Call the specified callback if the collection is not loaded.
     */
    private function checkCallback() : void
    {
        if (isset($this->onload) && !$this->is_loaded) {
            $this->is_loaded = true;
            call_user_func($this->onload, $this);
        }
    }

    /**
     * Return an iterator for processing the collection as an array.
     *
     * @return CollectionIterator
     */
    public function getIterator() : CollectionIterator
    {
        $this->checkCallback();
        return new CollectionIterator(clone $this);
    }
}