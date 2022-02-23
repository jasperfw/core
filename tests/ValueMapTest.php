<?php
namespace JasperFW\CoreTest;

use InvalidArgumentException;
use JasperFW\Core\ValueMap;
use PHPUnit\Framework\TestCase;

class ValueMapTest extends TestCase
{
    public function testGetValid()
    {
        /** @var ValueMap $sut */
        $sut = $this->getMockForAbstractClass(ValueMap::class);
        $sut->addValue('testKey', 'testVal');
        $this->assertEquals('testVal', $sut->get('testKey'));
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testGetInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        /** @var ValueMap $sut */
        $sut = $this->getMockForAbstractClass(ValueMap::class);
        $sut->addValue('testKey', 'testVal');
        $this->assertEquals('testVal', $sut->get('invalid'));
    }

    public function testDelete()
    {
        /** @var ValueMap $sut */
        $sut = $this->getMockForAbstractClass(ValueMap::class);
        $sut->addValue('testKey', 'testVal');
        $sut->addValue('testKey2', 'testVal2');
        $sut->deleteValue('testKey');
        $expected = array('testKey2' => 'testVal2');
        $this->assertEquals($expected, $sut->getValues());
    }
}
