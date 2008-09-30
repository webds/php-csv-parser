<?php
require_once 'PHPUnit/Framework.php';

require_once dirname(__FILE__) . "/../lib/csv.php";
require_once dirname(__FILE__) . "/../lib/csv_to_sql.php";
require_once dirname(__FILE__) . "/fixtures/csv.php";

/**
 * @todo fix class name
 */
class sqlTest extends PHPUnit_Framework_TestCase
{
    protected $csv;

    protected function setUp()
    {
        $this->csv = new csv_to_sql;
    }

    protected function tearDown()
    {
        $this->csv = null;
    }

    public function testCreate_queries()
    {
    }

    public function testConversion()
    {
    }

    public function testConvertable()
    {
    }
}

?>
