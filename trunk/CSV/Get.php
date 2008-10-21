<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

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
 * sample snippets refer to this csv file for demonstration.
 * <code>
 *   name,age,skill
 *   john,13,knows magic
 *   tanaka,8,makes sushi
 *   jose,5,dances salsa
 * </code>
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
     * <code>
     *
     *   require_once 'File/CSV/Get.php';
     *
     *   $csv = new File_CSV_Get;
     *   $csv->uses('my_cool.csv');
     *   var_export($csv->connect());
     *
     *   array (
     *     0 =>
     *     array (
     *       'name' => 'john',
     *       'age' => '13',
     *       'skill' => 'knows magic',
     *     ),
     *     1 =>
     *     array (
     *       'name' => 'tanaka',
     *       'age' => '8',
     *       'skill' => 'makes sushi',
     *     ),
     *     2 =>
     *     array (
     *       'name' => 'jose',
     *       'age' => '5',
     *       'skill' => 'dances salsa',
     *     ),
     *   )
     *
     * </code>
     *
     * @param string $filename the csv filename to load
     *
     * @access public
     * @return boolean true if file was loaded successfully
     * @see symmetric(), asymmetry(), symmetrize()
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
     * <code>
     *
     *   var_export($csv->headers());
     *
     *   array (
     *     0 => 'name',
     *     1 => 'age',
     *     2 => 'skill',
     *   )
     *
     * </code>
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
     * @return integer gets the length of headers
     */
    public function countHeaders()
    {
        return count($this->_headers);
    }

    /**
     * header and row relationship builder
     *
     * Attempts to create a relationship for every single cell that
     * was captured and its corresponding header. The sample below shows
     * how a connection/relationship is built.
     *
     * sample of a csv file "my_cool.csv"
     *
     * <code>
     *   name,age,skill
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     * </code>
     *
     * php implementation
     *
     * <code>
     *
     *  $csv = new File_CSV_Get;
     *  $csv->uses('my_cool.csv');
     *
     *  if (!$csv->symmetric()) {
     *      die('file has headers and rows with different lengths
     *      cannot connect');
     *  }
     *
     *  var_export($csv->connect());
     *
     *  array (
     *    0 =>
     *    array (
     *      'name' => 'john',
     *      'age' => '13',
     *      'skill' => 'knows magic',
     *    ),
     *    1 =>
     *    array (
     *      'name' => 'tanaka',
     *      'age' => '8',
     *      'skill' => 'makes sushi',
     *    ),
     *    2 =>
     *    array (
     *      'name' => 'jose',
     *      'age' => '5',
     *      'skill' => 'dances salsa',
     *    ),
     *  )
     *
     * </code>
     *
     *
     * You can pass a collection of headers in an array to build
     * a connection for those columns only!
     *
     * <code>
     *
     *  var_export($csv->connect(array('age')));
     *
     *  array (
     *    0 =>
     *    array (
     *      'age' => '13',
     *    ),
     *    1 =>
     *    array (
     *      'age' => '8',
     *    ),
     *    2 =>
     *    array (
     *      'age' => '5',
     *    ),
     *  )
     *
     * </code>
     *
     * @param array $columns the columns to connect, if nothing
     * is given all headers will be used to create a connection
     *
     * @access public
     * @return array If the data is not symmetric an empty array
     * will be returned instead
     * @see symmetric(), asymmetry(), symmetrize(), headers()
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
     * finds the rows that do not match the headers length
     *
     * lets assume that we add one more row to our csv file.
     * that has only two values. Something like
     *
     * <code>
     *   name,age,skill
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     *   niki,6
     * </code>
     *
     * Then in our php code
     *
     * <code>
     *   $csv->uses('my_cool.csv');
     *   var_export($csv->asymmetry());
     * </code>
     *
     * The result
     *
     * <code>
     *
     *   array (
     *     0 =>
     *     array (
     *       0 => 'niki',
     *       1 => '6',
     *     ),
     *   )
     *
     * </code>
     *
     * @access public
     * @return array filled with rows that do not match headers
     * @see headers(), symmetrize(), symmetric()
     */
    public function asymmetry()
    {
        $ret_arr = array();
        $hc      = count($this->_headers);
        foreach ($this->_rows as $row) {
            if (count($row) != $hc) {
                $ret_arr[] = $row;
            }
        }
        return $ret_arr;
    }

    /**
     * all rows length equalizer
     *
     * makes the length of all rows and headers the same. If no $value is given
     * all unexistent cells will be filled with empty spaces
     *
     * @param mixed $value the value to fill the unexistent cells
     *
     * @access public
     * @return void
     */
    public function symmetrize($value = '')
    {
        $max_length = 0;

        foreach ($this->_rows as $row) {
            $row_length = count($row);
            if ($max_length < $row_length) {
                $max_length = $row_length;
            }
        }

        foreach ($this->_rows as $key => $row) {
            $this->_rows[$key] = array_pad($row, $max_length, $value);
        }

        $this->_headers = array_pad($this->_headers, $max_length, $value);
    }

    /**
     * column fetcher
     *
     * gets all the data for a specific column identified by $name
     *
     * Note $name is the same as the items returned by headers()
     *
     * sample of a csv file "my_cool.csv"
     *
     * <code>
     *   name,age,skill
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     * </code>
     *
     * php implementation
     *
     * <code>
     *   $csv = new File_CSV_Get;
     *   $csv->uses('my_cool.csv');
     *   var_export($csv->column('name'));
     * </code>
     *
     * the above example outputs something like
     *
     * <code>
     *
     *   array (
     *     0 => 'john',
     *     1 => 'tanaka',
     *     2 => 'jose',
     *   )
     *
     * </code>
     *
     * @param string $name the name of the column to fetch
     *
     * @access public
     * @return array filled with values of a column
     * @see headers(), fillColumn(), appendColumn(), cell(), rows(),
     * row(), columnExists()
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
     * checks if a column exists, columns are identified by their
     * header name.
     *
     * sample of a csv file "my_cool.csv"
     *
     * <code>
     *   name,age,skill
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     * </code>
     *
     * php implementation
     *
     * <code>
     *   $csv = new File_CSV_Get;
     *   $csv->uses('my_cool.csv');
     *   $headers = $csv->headers();
     * </code>
     *
     * now lets check if the columns exist
     *
     * <code>
     *   var_export($csv->columnExists($headers[0]));    // true
     *   var_export($csv->columnExists('age'));          // true
     *   var_export($csv->columnExists('I dont exist')); // false
     * </code>
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
     * Appends a column and each or all values in it can be
     * dinamically filled. Only when the $values argument is given.
     * <code>
     *
     *
     *  var_export($csv->fillColumn('age', 99));
     *  true
     *
     *  var_export($csv->appendColumn('candy_ownership', array(99, 44, 65)));
     *  true
     *
     *  var_export($csv->appendColumn('import_id', 111111111));
     *  true
     *
     *  var_export($csv->connect());
     *
     *  array (
     *    0 =>
     *    array (
     *      'name' => 'john',
     *      'age' => 99,
     *      'skill' => 'knows magic',
     *      'candy_ownership' => 99,
     *      'import_id' => 111111111,
     *    ),
     *    1 =>
     *    array (
     *      'name' => 'tanaka',
     *      'age' => 99,
     *      'skill' => 'makes sushi',
     *      'candy_ownership' => 44,
     *      'import_id' => 111111111,
     *    ),
     *    2 =>
     *    array (
     *      'name' => 'jose',
     *      'age' => 99,
     *      'skill' => 'dances salsa',
     *      'candy_ownership' => 65,
     *      'import_id' => 111111111,
     *    ),
     *  )
     *
     * </code>
     *
     * @param string $column an item returned by headers()
     * @param mixed  $values same as fillColumn()
     *
     * @access public
     * @return boolean
     * @see headers(), fillColumn(), fillCell(), createHeaders(),
     * injectHeaders()
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
     * sample of a csv file "my_cool.csv"
     *
     * <code>
     *   name,age,skill
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     * </code>
     *
     * php implementation
     *
     * <code>
     *   $csv = new File_CSV_Get;
     *   $csv->uses('my_cool.csv');
     *
     *   // if the csv file loads
     *   if ($csv->uses('my_cool.csv')) {
     *
     *      // grab all data within the age column
     *      var_export($csv->column('age'));
     *
     *      // rename all values in it with the number 99
     *      var_export($csv->fillColumn('age', 99));
     *
     *      // grab all data within the age column
     *      var_export($csv->column('age'));
     *
     *      // rename each value in a column independently
     *      $data = array(1, 2, 3);
     *      $csv->fillColumn('age', $data);
     *
     *      var_export($csv->column('age'));
     *   }
     * </code>
     *
     * standard output
     *
     * <code>
     *   array (
     *     0 => '13',
     *     1 => '8',
     *     2 => '5',
     *   )
     * </code>
     *
     * <code>
     *   true
     * </code>
     *
     * <code>
     *   array (
     *     0 => 99,
     *     1 => 99,
     *     2 => 99,
     *   )
     * </code>
     *
     * <code>
     *   array (
     *     0 => 1,
     *     1 => 2,
     *     2 => 3,
     *   )
     * </code>
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
     * Note: That indexes start with zero, and headers are not
     * searched!
     *
     * For example if we are trying to grab the cell that is in the
     * second row and the third column
     *
     * <code>
     *   name,age,skill
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     * </code>
     *
     * we would do something like
     * <code>
     *   var_export($csv->cell(1, 2));
     * </code>
     *
     * and get the following results
     * <code>
     *   'makes sushi'
     * </code>
     *
     * @param integer $x the row to fetch
     * @param integer $y the column to fetch
     *
     * @access public
     * @return mixed|false the value of the cell or false if the cell does
     * not exist
     * @see headers(), coordinateable(), row(), rows(), column()
     */
    public function cell($x, $y)
    {
        if ($this->coordinateable($x, $y)) {
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
     * sample of a csv file "my_cool.csv"
     *
     * <code>
     *   name,age,skill
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     * </code>
     *
     * php implementation
     *
     * <code>
     *
     *   $csv = new File_CSV_Get;
     *
     *   // load the csv file
     *   $csv->uses('my_cool.csv');
     *
     *   // find out if the given coordinate is valid
     *   if($csv->coordinateable(1, 1)) {
     *
     *       // if so grab that cell and dump it
     *       var_export($csv->cell(1, 1));       // '8'
     *
     *       // replace the value of that cell
     *       $csv->fillCell(1, 1, 'new value');  // true
     *
     *       // output the new value of the cell
     *       var_export($csv->cell(1, 1));       // 'new value'
     *
     *   }
     * </code>
     *
     * now lets try to grab the whole row
     *
     * <code>
     *   // show the whole row
     *   var_export($csv->row(1));
     * </code>
     *
     * standard output
     *
     * <code>
     *   array (
     *     0 => 'tanaka',
     *     1 => 'new value',
     *     2 => 'makes sushi',
     *   )
     * </code>
     *
     * @param integer $x     the row to fetch
     * @param integer $y     the column to fetch
     * @param mixed   $value the value to fill the cell with
     *
     * @access public
     * @return boolean
     * @see coordinateable(), row(), rows(), column()
     */
    public function fillCell($x, $y, $value)
    {
        if (!$this->coordinateable($x, $y)) {
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
     * sample of a csv file "my_cool.csv"
     *
     * <code>
     *   name,age,skill
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     * </code>
     *
     * load the csv file
     *
     * <code>
     *   $csv = new File_CSV_Get;
     *   var_export($csv->uses('my_cool.csv'));   // true if file is
     *                                            // loaded
     * </code>
     *
     * find out if a coordinate is valid
     *
     * <code>
     *   var_export($csv->coordinateable(99, 3)); // false
     * </code>
     *
     * check again for a know valid coordinate and grab that cell
     *
     * <code>
     *   var_export($csv->coordinateable(1, 1));  // true
     *   var_export($csv->cell(1, 1));            // '8'
     * </code>
     *
     * @param mixed $x the row to fetch
     * @param mixed $y the column to fetch
     *
     * @access public
     * @return void
     */
    public function coordinateable($x, $y)
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
     * This function will exclude the headers
     *
     * sample of a csv file "my_cool.csv"
     *
     * <code>
     *   name,age,skill
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     * </code>
     *
     * php implementation
     *
     * <code>
     *   $csv = new File_CSV_Get;
     *   $csv->uses('my_cool.csv');
     *   var_export($csv->countRows()); // returns 3
     * </code>
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
     * by default the first row is interpreted as headers but if we
     * have a csv file with data only and no headers it becomes really
     * annoying to work with the current loaded data.
     *
     * this function will create a set dinamically generated headers
     * and make the current headers accessable with the row handling
     * functions
     *
     * Note: that the csv file contains only data but no headers
     * sample of a csv file "my_cool.csv"
     *
     * <code>
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     * </code>
     *
     * checks if the csv file was loaded
     *
     * <code>
     *   $csv = new File_CSV_Get;
     *   if (!$csv->uses('my_cool.csv')) {
     *      die('can not load csv file');
     *   }
     * </code>
     *
     * dump current headers
     *
     * <code>
     *   var_export($csv->headers());
     * </code>
     *
     * standard output
     *
     * <code>
     *   array (
     *     0 => 'john',
     *     1 => '13',
     *     2 => 'knows magic',
     *   )
     * </code>
     *
     * generate headers named 'column' suffixed by a number and interpret
     * the previous headers as rows.
     *
     * <code>
     *   $csv->createHeaders('column')
     * </code>
     *
     * dump current headers
     *
     * <code>
     *   var_export($csv->headers());
     * </code>
     *
     * standard output
     *
     * <code>
     *   array (
     *     0 => 'column_1',
     *     1 => 'column_2',
     *     2 => 'column_3',
     *   )
     * </code>
     *
     * build a relationship and dump it
     *
     * <code>
     *   var_export($csv->connect());
     * </code>
     *
     * standard output
     *
     * <code>
     *
     *  array (
     *    0 =>
     *    array (
     *      'column_1' => 'john',
     *      'column_2' => '13',
     *      'column_3' => 'knows magic',
     *    ),
     *    1 =>
     *    array (
     *      'column_1' => 'tanaka',
     *      'column_2' => '8',
     *      'column_3' => 'makes sushi',
     *    ),
     *    2 =>
     *    array (
     *      'column_1' => 'jose',
     *      'column_2' => '5',
     *      'column_3' => 'dances salsa',
     *    ),
     *  )
     * </code>
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
        $this->_rows = $this->removeEmpty($this->_rows);
        return true;
    }

    /**
     * empty row remover
     *
     * removes all records that have been defined but have no data.
     *
     * @param array $rows a collection of rows to scan
     *
     * @access public
     * @return array containing only the rows that have data
     */
    public function removeEmpty($rows)
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
