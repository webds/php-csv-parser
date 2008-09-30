<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__) . "/../lib/csv.php";
require_once dirname(__FILE__) . "/fixtures/csv.php";

class csvTest extends PHPUnit_Framework_TestCase
{
    protected $csv;

    protected function setUp()
    {
        $this->csv = new csv;
    }

    protected function tearDown()
    {
        $this->csv = null;
    }


    public function testUses()
    {

        // must false when a file is not valid
        foreach (fix('non_valid_files') as $file => $msg) {
            $this->assertFalse($this->csv->uses(fix('fpath') . $file), $msg);
        }

        // oposite
        foreach (fix('valid_files') as $file => $msg) {
            $this->assertTrue($this->csv->uses(fix('fpath') . $file), $msg);
        }
    }

    public function testSettings()
    {
        $new_delim = '>>>>';
        $this->csv->settings(array('delimiter' => $new_delim));

        $expected = array(
            'delimiter' => $new_delim,
            'eol' => ";",
            'length' => 999999,
            'escape' => '"'
        );

        $msg = 'settings where not parsed correctly!';
        $this->assertEquals($expected, $this->csv->settings, $msg);
    }

    public function testHeaders()
    {

        $this->csv->uses('data/symmetric.csv');
        $result = $this->csv->headers();
        $this->assertEquals(fix('symmetric_headers'), $result);
    }

    public function testConnect()
    {
        $this->assertTrue($this->csv->uses('data/symmetric.csv'));
        $this->assertEquals(fix('symmetric_connection'), $this->csv->connect());
    }

    public function test_connect_must_return_emtpy_arr_when_not_asymmetric()
    {
        $this->assertTrue($this->csv->uses('data/escape_ng.csv'));
        $this->assertEquals(array(), $this->csv->connect());
    }

    public function testSymmetric_OK()
    {
        $this->assertTrue($this->csv->uses('data/symmetric.csv'));
        $this->assertTrue($this->csv->symmetric());
    }

    public function testSymmetric_NG()
    {
        $this->assertTrue($this->csv->uses('data/asymmetric.csv'));
        $this->assertFalse($this->csv->symmetric());
    }

    public function testAsymmetry()
    {
        $this->assertTrue($this->csv->uses('data/asymmetric.csv'));
        $result = $this->csv->asymmetry();
        $this->assertEquals(fix('asymmetric_rows'), $result);
    }

    public function testColumn()
    {
        $this->assertTrue($this->csv->uses('data/asymmetric.csv'));
        $result = $this->csv->column('header_c');

        $this->assertEquals(fix('expected_column'), $result);

    }

    public function testRaw_array()
    {
        $this->assertTrue($this->csv->uses('data/raw.csv'));
        $this->assertEquals(fix('expected_raw'), $this->csv->raw_array());
    }

    public function test_if_connect_ignores_valid_escaped_delims()
    {
        $this->assertTrue($this->csv->uses('data/escape_ok.csv'));
        $this->assertEquals(fix('expected_escaped'), $this->csv->connect());
    }

    public function test_create_headers_must_generate_headers_for_symmetric_data()
    {
        $this->assertTrue($this->csv->uses('data/symmetric.csv'));
        $this->assertTrue($this->csv->create_headers('COL'));
        $this->assertEquals(fix('expected_headers'), $this->csv->headers());
    }

    public function tets_create_headers_must_not_create_when_data_is_asymmetric()
    {
        $this->assertTrue($this->csv->uses('data/asymmetric.csv'));
        $this->assertFalse($this->csv->create_headers('COL'));
        $this->assertEquals(fix('original_headers'), $this->csv->headers());
    }

    public function test_inject_headers_must_inject_headers_for_symmetric_data()
    {
        $this->assertTrue($this->csv->uses('data/symmetric.csv'));
        $this->assertEquals(fix('original_headers'), $this->csv->headers());
        $this->assertTrue($this->csv->inject_headers(fix('expected_headers')));
        $this->assertEquals(fix('expected_headers'), $this->csv->headers());
    }

    public function test_inject_headers_must_not_inject_when_data_is_asymmetric()
    {
        $this->assertTrue($this->csv->uses('data/asymmetric.csv'));
        $this->assertEquals(fix('original_headers'), $this->csv->headers());
        $this->assertFalse($this->csv->inject_headers(fix('expected_headers')));
        $this->assertEquals(fix('original_headers'), $this->csv->headers());
    }

    public function test_row_count_is_correct()
    {
        $this->assertTrue($this->csv->uses('data/symmetric.csv'));
        $expected_count = count(fix('symmetric_connection'));
        $this->assertEquals($expected_count, $this->csv->count_rows());
    }

    public function test_row_fetching_returns_correct_result()
    {
        $this->assertTrue($this->csv->uses('data/symmetric.csv'));
        $expected = fix('ninth_row_from_symmetric');
        $this->assertEquals($expected, $this->csv->row(9));
    }

    public function test_row_must_be_empty_array_when_row_does_not_exist()
    {
        $this->assertTrue($this->csv->uses('data/symmetric.csv'));
        $this->assertEquals(array(), $this->csv->row(-1));
        $this->assertEquals(array(), $this->csv->row(10));
    }

    public function test_connect_must_build_relationship_for_needed_headers_only()
    {
        $this->assertTrue($this->csv->uses('data/symmetric.csv'));
        $result = $this->csv->connect(array('header_a'));
        $this->assertEquals(fix('header_a_connection'), $result);
    }

    public function test_connect_must_return_empty_array_if_given_params_are_of_invalid_datatype()
    {
        $this->assertTrue($this->csv->uses('data/symmetric.csv'));
        $this->assertEquals(array(), $this->csv->connect('header_a'));
    }

    public function test_connect_should_ignore_non_existant_headers_AND_return_empty_array()
    {
        $this->assertTrue($this->csv->uses('data/symmetric.csv'));
        $this->assertEquals(array(), $this->csv->connect(array('non_existent_header')));
    }

    public function test_connect_should_ignore_non_existant_headers_BUT_get_existent_ones()
    {
        $this->assertTrue($this->csv->uses('data/symmetric.csv'));
        $result = $this->csv->connect(array('non_existent_header', 'header_a'));
        $this->assertEquals(fix('header_a_connection'), $result);
    }

    public function test_count_headers()
    {
        $this->assertTrue($this->csv->uses('data/symmetric.csv'));
        $this->assertEquals(5, $this->csv->count_headers());
    }

}

// Call csvTest::main() if this source file is executed directly.
if (PHPUnit2_MAIN_METHOD == "csvTest::main") {
    csvTest::main();
}
?>
