<?php

namespace JasperFW\CoreTest\Collection;

use JasperFW\Core\Collection\Collection;
use JasperFW\Core\Collection\CollectionIterator;
use JasperFW\Core\Exception\CollectionException;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    /**
     * @throws CollectionException
     */
    public function testAddAndRemoveItemItem()
    {
        $sut = new Collection();
        $sut->addItem('a', 'b');
        $sut->addItem('c', 'd');
        $sut->addItem('e', 'f');
        $sut->removeItem('d');
        $this->assertEquals(['b', 'f'], $sut->keys());
        $sut->addItem('g');
        $this->assertEquals(3, $sut->length());
    }

    /**
     * @throws CollectionException
     */
    public function testDuplicateKeyThrowsException()
    {
        $this->expectException(CollectionException::class);
        $sut = new Collection();
        $sut->addItem('a', 'b');
        $sut->addItem('c', 'b');
    }

    /**
     * @throws CollectionException
     */
    public function testAddItemBeforeAndAfter()
    {
        $sut = new Collection();
        $sut->addItem('c', 'd');
        $sut->addItemBefore('a', 'd', 'b');
        $sut->addItemAfter('e', 'd', 'f');
        $this->assertEquals(['b', 'd', 'f'], $sut->keys());
    }

    /**
     * @throws CollectionException
     */
    public function testAddItemBeforeNonexistantAddsItemToBeginning()
    {
        $sut = new Collection();
        $sut->addItem('c', 'd');
        $sut->addItemBefore('a', 'bob', 'b');
        $this->assertEquals(['b', 'd'], $sut->keys());
    }

    /**
     * @throws CollectionException
     */
    public function testAddItemAfterNonexistantAddsItemToEnd()
    {
        $sut = new Collection();
        $sut->addItem('c', 'd');
        $sut->addItemAfter('a', 'bob', 'b');
        $this->assertEquals(['d', 'b'], $sut->keys());
    }

    /**
     * @throws CollectionException
     */
    public function testGetItem()
    {
        $sut = new Collection();
        $sut->addItem('c', 'd');
        $this->assertEquals('c', $sut->getItem('d'));
    }

    /**
     * @throws CollectionException
     */
    public function testExists()
    {
        $sut = new Collection();
        $sut->addItem('c', 'd');
        $this->assertTrue($sut->exists('d'));
        $this->assertFalse($sut->exists('nope'));
    }

    public function testGetsIterator()
    {
        $sut = new Collection();
        $this->assertInstanceOf(CollectionIterator::class, $sut->getIterator());
    }
}
