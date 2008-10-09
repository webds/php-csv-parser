<?php

/**
 * csv data fetching tools
 *
 * PHP VERSION 5
 *
 * @category  File
 * @package   File_CSV_Get
 * @author    Kazuyoshi Tlacaelel <kazu.dev@gmail.com>
 * @copyright 2008 Kazuyoshi Tlacaelel
 * @license   MIT License
 * @version   SVN: $Id$
 * @link      http://code.google.com/p/php-csv-parser/
 */

/**
 * csv data fetcher
 *
 * @category  File
 * @package   File_CSV_Get
 * @author    Kazuyoshi Tlacaelel <kazu.dev@gmail.com>
 * @copyright 2008 Kazuyoshi Tlacaelel
 * @license   MIT License
 * @link      http://code.google.com/p/php-csv-parser/
 */
class File_CSV_Get
{
    public

    /**
     * csv parsing default-settings
     *
     * @var array
     * @access public
     */
    $settings = array(
        'delimiter' => ',',
        'eol' => ";",
        'length' => 999999,
        'escape' => '"'
    );

    private

    /**
     * imported data from csv
     *
     * @var array
     * @access private
     */
    $_rows = array(),

    /**
     * csv file to parse
     *
     * @var string
     * @access private
     */
    $_filename = '',

    /**
     * csv headers to parse
     *
     * @var array
     * @access private
     */
    $_headers = array();

    /**
     * csv file loader
     *
     * indicates the object which file is to be loaded
     *
     * @param string $filename the csv filename to load
     *
     * @access public
     * @return boolean true if file was loaded successfully
     */
    public function uses($filename)
    {
        $this->_filename = $filename;
        $this->_flush();
        return $this->_parse();
    }

    /**
     * settings alterator
     *
     * lets you define different settings for scanning
     *
     * @param mixed $array containing settings to use
     *
     * @access public
     * @return boolean true if changes where applyed successfully
     * @see $settings
     */
    public function settings($array)
    {
        $this->settings = array_merge($this->settings, $array);
    }

    /**
     * header fetcher
     *
     * gets csv headers into an array
     *
     * @access public
     * @return array
     */
    public function headers()
    {
        return $this->_headers;
    }

    /**
     * header counter
     *
     * @access public
     * @return integer
     */
    public function countHeaders()
    {
        return count($this->_headers);
    }

    /**
     * header and value connector
     *
     * Builds a connection for each record and its header
     *
     * Note: if the data is not symmetric an emty array will be
     * returned instead.
     *
     * @param array $columns the columns to connect, if nothing
     * is given all headers will be used to create a connection
     *
     * @access public
     * @return array fetches a collection of hashes like
     * <code>
     *   array (
     *     array('header1' => 'value1', 'header2' => 'value2')
     *   );
     * </code>
     */
    public function connect($columns = array())
    {
        if (!$this->symmetric()) {
            return array();
        }
        if (!is_array($columns)) {
            return array();
        }
        if ($columns === array()) {
            $columns = $this->_headers;
        }

        $ret_arr = array();

        foreach ($this->_rows as $record) {
            $item_array = array();
            foreach ($record as $column => $value) {
                $header = $this->_headers[$column];
                if (in_array($header, $columns)) {
                    $item_array[$header] = $value;
                }
            }

            // do not append empty results
            if ($item_array !== array()) {
                array_push($ret_arr, $item_array);
            }
        }

        return $ret_arr;
    }

    /**
     * data length/symmetry checker
     *
     * tells if the headers and all of the contents length match.
     *
     * @access public
     * @return boolean
     */
    public function symmetric()
    {
        $hc = count($this->_headers);
        foreach ($this->_rows as $data) {
            if (count($data) != $hc) {
                return false;
            }
        }
        return true;
    }

    /**
     * asymmetric data fetcher
     *
     * gets the data that does not match the headers length
     *
     * @access public
     * @return array
     */
    public function asymmetry()
    {
        $ret_arr = array();
        $hc      = count($this->_headers);
        foreach ($this->_rows as $data) {
            if (count($data) != $hc) {
                $ret_arr[] = $data;
            }
        }
        return $ret_arr;
    }

    /**
     * column fetcher
     *
     * gets all the data for a specific column identified by $name
     *
     * @param string $name the name of the column to fetch
     *
     * @access public
     * @return array like
     * <code>
     *   $array = $csv->column('header1');
     *
     *   // array
     *   array(
     *     'value1',
     *     'value2',
     *     'value3',
     *   )
     * </code>
     */
    public function column($name)
    {
        if (!in_array($name, $this->_headers)) {
            return array();
        }
        $ret_arr = array();
        $key     = array_search($name, $this->_headers, true);
        foreach ($this->_rows as $data) {
            $ret_arr[] = $data[$key];
        }
        return $ret_arr;
    }

    /**
     * column existance checker
     *
     * @param string $string an item returned by headers()
     *
     * @access public
     * @return boolean
     * @see headers()
     */
    public function columnExists($string)
    {
        return in_array($string, $this->_headers);
    }

    /**
     * column appender
     *
     * @param string $column an item returned by headers()
     * @param mixed  $values same as fillColumn()
     *
     * @access public
     * @return boolean
     * @see headers(), fillColumn()
     */
    public function appendColumn($column, $values = null)
    {
        if ($this->columnExists($column)) {
            return false;
        }
        $this->_headers[] = $column;
        $length           = $this->countHeaders();
        $rows             = array();

        foreach ($this->_rows as $row) {
            $rows[] = array_pad($row, $length, '');
        }

        $this->_rows = $rows;

        if ($values === null) {
            $values = '';
        }

        return $this->fillColumn($column, $values);
    }

    /**
     * collumn data injector
     *
     * fills alll the data in the given column with $values
     * 
     * @param mixed $column the column identified by a string
     * @param mixed $values ither one of the following
     *  - (Number) will fill the whole column with the value of number
     *  - (String) will fill the whole column with the value of string
     *  - (Array) will fill the while column with the values of array
     *    the array gets ignored if it does not match the length of rows
     *
     * @access public
     * @return void
     */
    public function fillColumn($column, $values = null)
    {
        if (!$this->columnExists($column)) {
            return false;
        }

        if ($values === null) {
            return false;
        }

        if (!$this->symmetric()) {
            return false;
        }

        $y = array_search($column, $this->_headers);

        if (is_numeric($values) || is_string($values)) {
            foreach (range(0, $this->countRows() -1) as $x) {
                $this->fillCell($x, $y, $values);
            }
            return true;
        }

        if ($values === array()) {
            return false;
        }

        $length = $this->countRows();
        if (is_array($values) && $length == count($values)) {
            for ($x = 0; $x < $length; $x++) {
                $this->fillCell($x, $y, $values[$x]);
            }
            return true;
        }
    }

    /**
     * cell fetcher
     *
     * gets the value of a specific cell by given coordinates
     *
     * @param integer $x the row to fetch
     * @param integer $y the column to fetch
     *
     * @access public
     * @return mixed the value of the cell or false if the cell does 
     * not exist
     * @see coordinatable(), row(), rows(), column()
     */
    public function cell($x, $y)
    {
        if ($this->coordinatable($x, $y)) {
            $row = $this->row($x);
            return $row[$y];
        }
        return false;
    }

    /**
     * cell value filler
     *
     * replaces the value of a specific cell
     *
     * @param integer $x     the row to fetch
     * @param integer $y     the column to fetch
     * @param mixed   $value the value to fill the cell with
     *
     * @access public
     * @return boolean
     * @see coordinatable(), row(), rows(), column()
     */
    public function fillCell($x, $y, $value)
    {
        if (!$this->coordinatable($x, $y)) {
            return false;
        }
        $row             = $this->row($x);
        $row[$y]         = $value;
        $this->_rows[$x] = $row;
        return true;
    }

    /**
     * checks if a coordinate is valid
     * 
     * @param mixed $x the row to fetch
     * @param mixed $y the column to fetch
     *
     * @access public
     * @return void
     */
    public function coordinatable($x, $y)
    {
        $has_x = array_key_exists($x, $this->_rows);
        $has_y = array_key_exists($y, $this->_headers);
        return ($has_x && $has_y);
    }

    /**
     * row fetcher
     *
     * Note: first row is zero
     *
     * @param integer $number the row number to fetch
     *
     * @access public
     * @return array the row identified by number, if $number does
     * not exist an empty array is returned instead
     * <code>
     *   $array = $csv->row(3); # array('val1', 'val2', 'val3')
     * </code>
     */
    public function row($number)
    {
        $raw = $this->_rows;
        if (array_key_exists($number, $raw)) {
            return $raw[$number];
        }
        return array();
    }

    /**
     * multiple row fetcher
     *
     * extracts csv rows excluding the headers
     *
     * @param array $range a list of rows to retrive
     *
     * @access public
     * @return array
     */
    public function rows($range = array())
    {
        if ($range === array()) {
            return $this->_rows;
        }
        $ret_arr = array();
        foreach ($this->_rows as $key => $row) {
            if (in_array($key +1, $range)) {
                $ret_arr[] = $row;
            }
        }
        return $ret_arr;
    }

    /**
     * row counter
     *
     * this function excludes the headers
     *
     * @access public
     * @return integer
     */
    public function countRows()
    {
        return count($this->_rows);
    }

    /**
     * raw data as array
     *
     * @access public
     * @return array
     */
    public function rawArray()
    {
        $ret_arr   = array();
        $ret_arr[] = $this->_headers;
        foreach ($this->_rows as $row) {
            $ret_arr[] = $row;
        }
        return $ret_arr;
    }

    /**
     * header creator
     *
     * uses prefix and creates a header for each column suffixed by a
     * numeric value
     *
     * @param string $prefix check your database engine for valid
     * column naming conventions.
     *
     * @access public
     * @return boolean fails if data is not symmetric
     * @see symmetric(), asymmetry()
     */
    public function createHeaders($prefix)
    {
        if (!$this->symmetric()) {
            return false;
        }

        $length = count($this->_headers) + 1;
        $this->_moveHeadersToRows();

        $ret_arr = array();
        for ($i = 1; $i < $length; $i ++) {
            $ret_arr[] = $prefix . "_$i";
        }
        $this->_headers = $ret_arr;
        return $this->symmetric();
    }

    /**
     * header injector
     *
     * uses a $list array filled with strings to fill headers to be
     * used by this object.
     *
     * Note: that given $list must match the length of all rows and
     * this must be symmetric.
     *
     * @param array $list a collection of names to use as headers,
     * check your database engine for column-name conventions.
     *
     * @access public
     * @return boolean fails if data is not symmetric
     * @see symmetric(), asymmetry()
     */
    public function injectHeaders($list)
    {
        if (!$this->symmetric()) {
            return false;
        }
        if (!is_array($list)) {
            return false;
        }
        if (count($list) != count($this->_headers)) {
            return false;
        }
        $this->_moveHeadersToRows();
        $this->_headers = $list;
        return true;
    }

    /**
     * csv parser
     *
     * reads csv data and transforms it into php-data
     *
     * @access private
     * @return boolean
     */
    private function _parse()
    {
        if (!$this->_validates()) {
            return false;
        }

        $c = 0;
        $d = $this->settings['delimiter'];
        $e = $this->settings['escape'];
        $l = $this->settings['length'];

        $res = fopen($this->_filename, 'r');
        while ($keys = fgetcsv($res, $l, $d, $e)) {

            if ($c == 0) {
                $this->_headers = $keys;
            } else {
                array_push($this->_rows, $keys);
            }

            $c ++;
        }
        fclose($res);
        $this->_rows = $this->_removeEmpty($this->_rows);
        return true;
    }

    /**
     * empty row remover
     *
     * removes all records that have been defined but have no data.
     *
     * @param array $rows a collection of rows to scan
     *
     * @access private
     * @return array containing only the rows that have data
     */
    private function _removeEmpty($rows)
    {
        $ret_arr = array();
        foreach ($rows as $row) {
            $line = trim(join('', $row));
            if (!empty($line)) {
                $ret_arr[] = $row;
            }
        }
        return $ret_arr;
    }

    /**
     * csv file validator
     *
     * checks wheather if the given csv file is valid or not
     *
     * @access private
     * @return boolean
     */
    private function _validates()
    {
        // file existance
        if (!file_exists($this->_filename)) {
            return false;
        }

        // file extension
        if (!preg_match('/\.csv$/i', $this->_filename)) {
            return false;
        }

        return true;
    }

    /**
     * header relocator
     *
     * @access private
     * @return void
     */
    private function _moveHeadersToRows()
    {
        $arr   = array();
        $arr[] = $this->_headers;
        foreach ($this->_rows as $row) {
            $arr[] = $row;
        }
        $this->_rows    = $arr;
        $this->_headers = array();
    }

    /**
     * object data flusher
     *
     * tells this object to forget all data loaded and start from
     * scratch
     *
     * @access private
     * @return void
     */
    private function _flush()
    {
        $this->_rows    = array();
        $this->_headers = array();
    }

}

?>
