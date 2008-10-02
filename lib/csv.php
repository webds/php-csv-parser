<?php

/**
 * csv parser
 *
 * PHP version 5
 *
 * <code>
 *
 *   // usage sample
 *   $csv = new csv;
 *
 *   // tell the object to parse a specific file
 *   if ($csv->uses('my_file.csv')) {
 *
 *     // execute the following if given file is usable
 *
 *     // get the headers found in file
 *     $array = $csv->headers();
 *
 *     // get a specific column from csv file
 *     $csv->column($array[2]);
 *
 *     // get each record with its related header
 *     // ONLY if all records length match the number
 *     // of headers
 *      if ($csv->symmetric()) {
 *          $array = $csv->connect();
 *      } else {
 *          // fetch records that dont match headers length
 *          $array = $csv->asymmetry();
 *      }
 *
 *      // ignore everything and simply get the data as an array
 *      $array = $csv->raw_array();
 *   }
 *
 * <code>
 *
 * @version     $Id$
 * @copyright   1997-2005 The PHP Group
 * @author      Kazuyoshi Tlacaelel <kazu.dev@gmail.com>
 * @license     MIT
 */
class csv
{
    public

    /**
     * csv parsing default-settings
     *
     * @var     array
     * @access  public
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
     * @var     array
     * @access  private
     */
    $_data = array(),

    /**
     * csv file to parse
     *
     * @var     string
     * @access  private
     */
    $_filename = '',

    /**
     * csv headers to parse
     *
     * @var     array
     * @access  private
     */
    $_headers = array();

    /**
     * csv file loader
     *
     * indicates the object which file is to be loaded
     *
     * @param   string  $filename
     * @access  public
     * @return  boolean true if file was loaded successfully
     */
    public function uses($filename)
    {
        $this->_filename = $filename;
        return $this->_parse();
    }

    /**
     * settings alterator
     *
     * lets you define different settings for scanning
     *
     * @param   mixed   $array
     * @access  public
     * @return  boolean true if changes where applyed successfully
     */
    public function settings($array)
    {
        $this->settings = array_merge($this->settings, $array);
    }

    /**
     * header fetcher
     *
     * gets all headers into an array
     *
     * @access  public
     * @return  array
     */
    public function headers()
    {
        return $this->_headers;
    }

    /**
     * header counter
     *
     * @access  public
     * @return  integer
     */
    public function count_headers()
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
     * @param   array   $columns    the columns to connect, if nothing
     *                              is given all headers will be used
     *                              to create a connection
     * @access  public
     * @return  array   fetches a collection of hashes like
     * <code>
     *   array (
     *     array('header1' => 'value1', 'header2' => 'value2')
     *   );
     * </code>
     */
    public function connect($columns = array())
    {
        if (!$this->symmetric()) return array();
        if (!is_array($columns)) return array();
        if ($columns === array()) $columns = $this->_headers;

        $ret_arr = array();

        foreach ($this->_data as $record) {
            $item_array = array();
            foreach ($record as $column => $value) {
                $header = $this->_headers[$column];
                if (in_array($header, $columns)) {
                    $item_array[$header] = $value;
                }
            }

            # do not append empty results
            if ($item_array !== array()) array_push($ret_arr, $item_array);
        }

        return $ret_arr;
    }

    /**
     * data length/symmetry checker
     *
     * tells if the headers and all of the contents length match.
     *
     * @access  public
     * @return  boolean
     */
    public function symmetric()
    {
        $hc = count($this->_headers);
        foreach ($this->_data as $data) {
            if (count($data) != $hc) return false;
        }
        return true;
    }

    /**
     * asymmetric data fetcher
     *
     * gets the data that does not match the headers length
     *
     * @access  public
     * @return  array
     */
    public function asymmetry()
    {
        $ret_arr = array();
        $hc = count($this->_headers);
        foreach ($this->_data as $data) {
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
     * @param   mixed   string
     * @access  public
     * @return  array   like
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
        if (!in_array($name, $this->_headers)) return array();
        $key = array_search($name, $this->_headers, true);
        $ret_arr = array();
        foreach ($this->_data as $data) {
            $ret_arr[] = $data[$key];
        }
        return $ret_arr;
    }

    /**
     * row fetcher
     *
     * Note: first row is zero
     *
     * @param   integer $number
     * @access  public
     * @return  array   the row identified by number, if $number does
     *                  not exist an empty array is returned instead
     * <code>
     *   $array = $csv->row(3); # array('val1', 'val2', 'val3')
     * </code>
     */
    public function row($number)
    {
        $raw = $this->raw_array();
        if (array_key_exists($number, $raw)) return $raw[$number];
        return array();
    }

    /**
     * multiple row fetcher
     *
     * extracts csv rows excluding the headers
     *
     * @access  public
     * @return  array
     */
    public function rows()
    {
        return $this->_data;
    }

    /**
     * row counter
     *
     * this function excludes the headers
     *
     * @access  public
     * @return  integer
     */
    public function count_rows()
    {
        return count($this->_data);
    }

    /**
     * raw data as array
     *
     * @access  public
     * @return  array
     */
    public function raw_array()
    {
        $ret_arr = array();
        $ret_arr[] = $this->_headers;
        foreach ($this->_data as $row) $ret_arr[] = $row;
        return $ret_arr;
    }

    /**
     * header creator
     *
     * uses prefix and creates a header for each column suffixed by a
     * numeric value
     *
     * @param   string  $prefix
     * @access  public
     * @return  boolean fails if data is not symmetric
     * @see     symmetric(), asymmetry()
     */
    public function create_headers($prefix)
    {
        if (!$this->symmetric()) return false;
        $length = count($this->_headers) + 1;
        $this->move_headers_to_data();

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
     * @param   array   $list
     * @access  public
     * @return  boolean fails if data is not symmetric
     * @see     symmetric(), asymmetry()
     */
    public function inject_headers($list)
    {
        if (!$this->symmetric()) return false;
        if (!is_array($list)) return false;
        if (count($list) != count($this->_headers)) return false;
        $this->move_headers_to_data();
        $this->_headers = $list;
        return true;
    }

    /**
     * csv parser
     *
     * reads csv data and transforms it into php-data
     *
     * @access  private
     * @return  boolean
     */
    private function _parse()
    {
        if (! $this->_validates()) return false;

        $a = array();
        $c = 0;
        $d = $this->settings['delimiter'];
        $e = $this->settings['escape'];
        $l = $this->settings['length'];

        $res = fopen($this->_filename, 'r');
        while ($keys = fgetcsv($res, $l, $d, $e)) {

            if ($c == 0) $this->_headers = $keys;

            array_push($a, $keys);
            $c ++;
        }
        fclose($res);
        unset($a[0]);
        $this->_data = $a;
        $this->_data = $this->_removeEmptyRecords($a);
        return true;
    }

    private function _removeEmptyRecords($records)
    {
        $ret_arr = array();
        foreach($records as $rec) {
            $line = trim(join('', $rec));
            if (!empty($line)) {
                $ret_arr[] = $rec;
            }
        }
        return $ret_arr;
    }

    /**
     * csv file validator
     *
     * checks wheather if the given csv file is valid or not
     *
     * @access  private
     * @return  boolean
     */
    private function _validates()
    {
        # file existance
        if (!file_exists($this->_filename)) return false;

        # file extension
        if (!preg_match('/\.csv$/i', $this->_filename)) return false;

        return true;
    }

    private function move_headers_to_data()
    {
        $arr = array();
        $arr[] = $this->_headers;
        foreach ($this->_data as $row) {
            $arr[] = $row;
        }
        $this->_data = $arr;
        $this->_headers = array();
    }
}

?>
