<?php

namespace JasperFW\CoreTest\XML;

use Exception;
use JasperFW\Core\XML\Array2XML;
use PHPUnit\Framework\TestCase;

class Array2XMLTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testInvalidAttributeNameThrowsException()
    {
        $this->expectException(Exception::class);
        Array2XML::createXML(
            'root',
            [
                '@attributes' => [
                    '#attribute1' => '',
                ],
            ]
        );
    }

    /**
     * @throws Exception
     */
    public function testInvalidSimpleTagNameThrowsException()
    {
        $this->expectException(Exception::class);
        Array2XML::createXML(
            'root',
            [
                '#node' => 'bad node name',
            ]
        );
    }

    /**
     * @throws Exception
     */
    public function testAcceptsNestedElements()
    {
        $expectedXML = <<<XML
<?xml version="1.0" encoding="utf-8" standalone="no"?>
<root>
  <node1>
    <something>something else</something>
  </node1>
  <node2>
    <innernode>
      <a>b</a>
    </innernode>
  </node2>
  <node2>
    <innernode>
      <c>d</c>
    </innernode>
  </node2>
  <node2>
    <innernode>
      <e>f</e>
    </innernode>
  </node2>
</root>

XML;
        $array = [
            'node1' => [
                'something' => 'something else',
            ],
            'node2' => [
                ['innernode' => ['a' => 'b']],
                ['innernode' => ['c' => 'd']],
                ['innernode' => ['e' => 'f']],
            ],
        ];
        $actualXML = Array2XML::createXML('root', $array)->saveXML();
        $this->assertEquals($expectedXML, $actualXML);
    }
}
