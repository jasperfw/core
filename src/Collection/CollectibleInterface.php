<?php
namespace JasperFW\Core\Collection;

/**
 * Interface CollectibleInterface
 *
 * The collectible interface is intended for models that have a collection of members as a static property. This class
 * provides some functionality for looking up members of the collection.
 *
 * @package JasperFW\Core\Collection
 */
interface CollectibleInterface
{
    /**
     * @param int $id
     *
     * @return mixed
     */
    public static function lookup(int $id): mixed;

    /**
     * Access the collection
     *
     * @return Collection
     */
    public static function collection() : Collection;
}
