<?php


namespace oliverde8\AssociativeArraySimplifiedTest;

use oliverde8\AssociativeArraySimplified\AssociativeArray;


/**
 * Class AssociativeArrayTest
 *
 * @author    de Cramer Oliver<oldec@smile.fr>
 * @copyright 2017 Smile
 * @package oliverde8\AssociativeArraySimplifiedTest
 */
class AssociativeArrayTest extends \PHPUnit_Framework_TestCase
{

    protected $data = ['aaa' => 'abc', 'bbb' => 'bcd'];

    protected $recursiveData = [
        'aaa' => [
            'aaa_aaa' => 'abc_abc',
            'aaa_bbb' => 'abc_bcd',
            'aaa_ccc' => [
                'aaa_ccc_aaa' => 'abc_cef_abc',
                'aaa_ccc_bbb' => 'abc_cef_bcd',
            ]
        ],
        'bbb' => [
            'bbb_aaa' => 'bbb_abc',
            'bbb_bbb' => 'bbb_bcd',
            'bbb_ccc' => [
                'bbb_ccc_aaa' => 'bcd_cef_abc',
                'bbb_ccc_bbb' => 'bcd_cef_bcd',
            ]
        ],
    ];

    public function testCreateEmpty()
    {
        $array = new AssociativeArray();

        $this->assertSame([], $array->getArray());
    }

    public function testCreate()
    {
        $array = new AssociativeArray($this->data);

        $this->assertSame($this->data, $array->getArray());
    }

    public function testCreateRecursive()
    {
        $array = new AssociativeArray($this->recursiveData);

        $this->assertSame($this->recursiveData, $array->getArray());
    }

    public function testDefaultGet()
    {
        $array = new AssociativeArray();

        $this->assertNull($array->get('unknown'));
    }

    public function testDefaultWithValue()
    {
        $array = new AssociativeArray();

        $this->assertEquals('my_unknown', $array->get('unknown', 'my_unknown'));
    }

    public function testSimpleDataGet()
    {
        $array = new AssociativeArray($this->recursiveData);

        $this->assertSame($this->recursiveData['aaa'], $array->get('aaa'));
    }

    public function testRecursiveDataGet()
    {
        $array = new AssociativeArray($this->recursiveData);

        $this->assertSame('abc_bcd', $array->get('aaa/aaa_bbb'));
        $this->assertSame('abc_cef_abc', $array->get('aaa/aaa_ccc/aaa_ccc_aaa'));
        $this->assertSame('abc_cef_bcd', $array->get('aaa/aaa_ccc/aaa_ccc_bbb'));
        $this->assertSame('bcd_cef_abc', $array->get('bbb/bbb_ccc/bbb_ccc_aaa'));

        $this->assertSame('abc_bcd', $array->get(['aaa', 'aaa_bbb']));
        $this->assertSame('abc_cef_abc', $array->get(['aaa', 'aaa_ccc', 'aaa_ccc_aaa']));
        $this->assertSame('abc_cef_bcd', $array->get(['aaa', 'aaa_ccc', 'aaa_ccc_bbb']));
        $this->assertSame('bcd_cef_abc', $array->get(['bbb', 'bbb_ccc', 'bbb_ccc_aaa']));
    }

    public function testDefaultRecursiveGet()
    {
        $array = new AssociativeArray($this->recursiveData);

        $this->assertNull($array->get('unknown/unknown_1'));
        $this->assertNull($array->get('unknown/unknown_1/toto'));
    }

    public function testDefaultRecursiveValue()
    {
        $array = new AssociativeArray($this->recursiveData);

        $this->assertEquals('my_unknown_1', $array->get('unknown/unknown_1', 'my_unknown_1'));
        $this->assertEquals('my_unknown_2', $array->get('unknown/unknown_1/toto', 'my_unknown_2'));
    }

    public function testKeyExist()
    {
        $array = new AssociativeArray($this->recursiveData);

        $this->assertTrue($array->keyExist('aaa'));
        $this->assertFalse($array->keyExist('zzz'));
    }

    public function testSet()
    {
        $array = new AssociativeArray($this->data);

        $array->set('aaa', 'new_aaa');
        $this->assertEquals('new_aaa', $array->get('aaa'));

        $array->set('zzz', 'new_zzz');
        $this->assertEquals('new_zzz', $array->get('zzz'));
    }

    public function testRecursiveSet()
    {
        $array = new AssociativeArray($this->recursiveData);

        $array->set('aaa/aaa_bbb', 'new_abc_bcd');
        $array->set('aaa/aaa_ccc/aaa_ccc_aaa', 'new_abc_cef_abc');
        $array->set('aaa/aaa_ccc/aaa_ccc_bbb', 'new_abc_cef_bcd');
        $array->set('bbb/bbb_ccc/bbb_ccc_aaa', 'new_bcd_cef_abc');
        $array->set('u_1/u_2', 'new_u');
        $array->set('u_5/u_6', 'new_u2');

        $this->assertSame('new_abc_bcd', $array->get('aaa/aaa_bbb'));
        $this->assertSame('new_abc_cef_abc', $array->get('aaa/aaa_ccc/aaa_ccc_aaa'));
        $this->assertSame('new_abc_cef_bcd', $array->get('aaa/aaa_ccc/aaa_ccc_bbb'));
        $this->assertSame('new_bcd_cef_abc', $array->get('bbb/bbb_ccc/bbb_ccc_aaa'));
        $this->assertSame('new_u', $array->get('u_1/u_2'));
        $this->assertSame('new_u2', $array->get('u_5/u_6'));

        $array = new AssociativeArray($this->recursiveData);

        $array->set(['aaa', 'aaa_bbb'], 'new_abc_bcd');
        $array->set(['aaa', 'aaa_ccc', 'aaa_ccc_aaa'], 'new_abc_cef_abc');
        $array->set(['aaa', 'aaa_ccc', 'aaa_ccc_bbb'], 'new_abc_cef_bcd');
        $array->set(['bbb', 'bbb_ccc', 'bbb_ccc_aaa'], 'new_bcd_cef_abc');
        $array->set(['u_1', 'u_2'], 'new_u');
        $array->set(['u_5', 'u_6'], 'new_u2');

        $this->assertSame('new_abc_bcd', $array->get('aaa/aaa_bbb'));
        $this->assertSame('new_abc_cef_abc', $array->get('aaa/aaa_ccc/aaa_ccc_aaa'));
        $this->assertSame('new_abc_cef_bcd', $array->get('aaa/aaa_ccc/aaa_ccc_bbb'));
        $this->assertSame('new_bcd_cef_abc', $array->get('bbb/bbb_ccc/bbb_ccc_aaa'));
        $this->assertSame('new_u', $array->get('u_1/u_2'));
        $this->assertSame('new_u2', $array->get('u_5/u_6'));
    }

    public function testCustomSeperator()
    {
        $array = new AssociativeArray($this->recursiveData, '.');

        $this->assertSame('abc_bcd', $array->get('aaa.aaa_bbb'));
        $this->assertSame('abc_cef_abc', $array->get('aaa.aaa_ccc.aaa_ccc_aaa'));
        $this->assertNull($array->get('aaa/aaa_bbb'));

        $array->set('aaa.aaa_bbb', 'new_abc_bcd');
        $array->set('aaa.aaa_ccc.aaa_ccc_aaa', 'new_abc_cef_abc');

        $array->set(['aaa', 'aaa_bbb'], 'new_abc_bcd');
        $array->set(['aaa', 'aaa_ccc', 'aaa_ccc_bbb'], 'new_abc_cef_bcd');
    }

    public function testReadOnly() {
        $array = new AssociativeArray($this->recursiveData, '.');
        $array->makeReadOnly();

        $this->setExpectedException('oliverde8\AssociativeArraySimplified\Exception\ReadOnlyException', 'Trying to edit content in read only AssociativeArray !');

        $array->set('aaa', []);
    }

    public function testClear()
    {
        $array = new AssociativeArray($this->recursiveData, '.');
        $array->clear();

        $this->assertEmpty($array->getArray());
    }
}
