<?php
namespace JasperFW\Core;

/**
 * Interface CollectibleInterface
 *
 * The collectible interface is intended for models that have a collection of members as a static property. This class
 * provides some functionality for looking up members of the collection.
 *
 * @package JasperFW\Core
 */
interface CollectibleInterface
{
    /**
     * @param int $id
     *
     * @return mixed
     */
    public static function lookup(int $id);

    /**
     * Access the collection
     *
     * @return Collection
     */
    public static function collection() : Collection;
}