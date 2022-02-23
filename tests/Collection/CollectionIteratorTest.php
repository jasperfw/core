<?php

namespace JasperFW\CoreTest\Collection;

use JasperFW\Core\Collection\Collection;
use JasperFW\Core\Exception\CollectionException;
use PHPUnit\Framework\TestCase;

class CollectionIteratorTest extends TestCase
{
    /** @var Collection */
    protected Collection $collection;

    /**
     * @throws CollectionException
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->collection = new Collection();
        $this->collection->addItem('a', 'b');
        $this->collection->addItem('c', 'd');
    }

    /**
     * @throws CollectionException
     */
    public function testKey()
    {
        $sut = $this->collection->getIterator();
        $this->assertEquals('a', $sut->current());
        $this->assertEquals('b', $sut->key());
        $this->assertTrue($sut->hasMore());
        $sut->next();
        $this->assertEquals('c', $sut->current());
        $this->assertEquals('d', $sut->key());
        $this->assertFalse($sut->hasMore());
        $sut->previous();
        $this->assertEquals('a', $sut->current());
        $this->assertTrue($sut->valid());
        $sut->next();
        $sut->rewind();
        $this->assertEquals('a', $sut->current());
        $sut->next();
        $sut->next();
        $this->assertFalse($sut->valid());
    }
}
