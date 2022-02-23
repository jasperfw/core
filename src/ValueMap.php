<?php
namespace JasperFW\Core;

use InvalidArgumentException;

/**
 * Class ValueMap
 *
 * The ValueMap class is intended to provide basic functionality for classes that represent hashes or maps of values.
 *
 * @package JasperFW\Core
 */
abstract class ValueMap
{
    /** @var array */
    protected array $map = array();

    /**
     * Retrieve a value
     *
     * @param string $index
     * @return string
     */
    public function get(string $index) : string
    {
        if (!$this->isValid($index)) {
            throw new InvalidArgumentException('The specified value does not exist');
        }
        return $this->map[$index];
    }

    /**
     * Checks if the type exists in the map.
     *
     * @param string $index
     *
     * @return bool
     */
    public function isValid(string $index): bool
    {
        return isset($this->map[$index]);
    }

    /**
     * Add a new value to the map
     *
     * @param string $key
     * @param string $value
     */
    public function addValue(string $key, string $value) : void
    {
        $this->map[$key] = $value;
    }

    /**
     * Delete a value from the map based on the key
     * @param string $key
     */
    public function deleteValue(string $key) : void
    {
        if (isset($this->map[$key])) {
            unset($this->map[$key]);
        }
    }

    /**
     * Returns an array of all of the values
     */
    public function getValues() : array
    {
        return $this->map;
    }
}
