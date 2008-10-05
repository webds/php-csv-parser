<?php
require_once 'PHPUnit/Framework.php';

require_once dirname(__FILE__) . "/../Get/Get.php";
require_once dirname(__FILE__) . "/../Get/GetSql.php";
require_once dirname(__FILE__) . "/fixtures/csv.php";

/**
 * @todo fix class name
 */
class sqlTest extends PHPUnit_Framework_TestCase
{
    protected $csv;

    protected function setUp()
    {
        $this->csv = new File_CSV_GetSql;
    }

    protected function tearDown()
    {
        $this->csv = null;
    }

    public function testCreate_queries()
    {
        $this->assertTrue($this->csv->uses('data/symmetric.csv'));
        $expected = fix('symmetric_queries');
        $this->assertEquals($expected, $this->csv->createQueries('test_table'));
    }

    public function test_values_in_queries_must_not_have_trailing_spaces()
    {
        $fname = 'data/symmetric_with_trailing_spaces.csv';
        $this->assertTrue($this->csv->uses($fname));
        $expected = fix('symmetric_queries');
        $this->assertEquals($expected, $this->csv->createQueries('test_table'));
    }

    public function test_create_queries_with_alternate_columns()
    {
        $fname = 'data/symmetric.csv';
        $this->assertTrue($this->csv->uses($fname));
        $columns = array('header_a', 'header_c');
        $res = $this->csv->createQueries('test_table', $columns);
        $this->assertEquals(fix('alternated_header_queries'), $res);
    }

    public function testConvertable()
    {
    }


    public function test_convert()
    {
    }

}

?>
