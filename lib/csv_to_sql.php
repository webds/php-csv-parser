<?php

/**
 * csv data fetching tools
 *
 * PHP VERSION 5
 *
 * @category  File
 * @package   File_CSV_GetSql
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
 * @package   File_CSV_GetSql
 * @author    Kazuyoshi Tlacaelel <kazu.dev@gmail.com>
 * @copyright 2008 Kazuyoshi Tlacaelel
 * @license   MIT License
 * @link      http://code.google.com/p/php-csv-parser/
 */
class File_CSV_GetSql extends File_CSV_Get
{

    /**
     * template for sql query.
     *
     * override this in a child class for multiple-database support
     *
     * @var string
     * @access protected
     */
    protected $query_template = 'INSERT INTO %s (%s) VALUES (%s)';

    /**
     * sql dumper for symmetric data
     *
     * Exports csv data into sql. Only when the headers match all
     * records length (symmetric)
     *
     * @param string $tablename the tablename to use for inserts
     * @param array  $headers   the headers to use, if none given
     * all headers are included by default
     *
     * @access public
     *
     * @return array
     * @see symmetric(), asymmetry()
     */
    public function createQueries($tablename, $headers = array())
    {
        $queries = array();
        if (!$this->symmetric()) {
            return $queries;
        }
        if ($headers === array()) {
            $headers = $this->headers();
        }

        foreach ($this->rows() as $row) {
            $queries[] = sprintf($this->query_template,
                $tablename,
                join(', ', $headers),
                $this->_joinValues($row, $headers));
        }
        return $queries;
    }

    /**
     * row value assambler 
     *
     * joins the values of a  record
     * 
     * @param array $row     the record to join values
     * @param array $headers a list of headers to use, headers not 
     * included will be ommited
     *
     * @access private
     * @return string
     */
    private function _joinValues($row, $headers)
    {
        foreach ($this->headers() as $key => $header) {
            if (in_array($header, $headers)) {
                $values[] = $this->convert($row[$key]);
            }
        }
        return join(', ', $values);
    }

    /**
     * cell value formatter & encoding transfomer
     *
     * @param string $value the string to convert
     *
     * @access public
     * @return string
     */
    public function convert($value)
    {
        if ($this->convertable($value)) {
            $value = mb_ereg_replace("/'/", '\'', $value);
            $value = mb_ereg_replace('\s+$', '', $value);
            $value = mb_ereg_replace('^\s+', '', $value);
            $value = mb_convert_encoding($value, 'utf8', 'sjis');
        } else {
            $value = preg_replace("/'/", '\'', $value);
            $value = preg_replace('/\s+$/', '', $value);
            $value = preg_replace('/^\s+/', '', $value);
        }
        return "'" . $value . "'";
    }

    /**
     * conversion specifier
     *
     * tells this object what kind of conversion needs to be made
     * 
     * @param string $from the original encoding that will be transformed
     * @param string $to   the new encoding 
     *
     * @access  public
     * @return  void
     */
    public function conversion($from, $to)
    {
        $this->from = $from;
        $this->to   = $to;
    }

    /**
     * conversion capability checker
     *
     * checks if a string can be converted using the given settings
     * 
     * @param string $string the string to validate
     *
     * @access public
     * @return boolean
     * @see conversion()
     */
    public function convertable($string)
    {
        if (empty($string)) {
            return false;
        }
        if (empty($this->from)) {
            return false;
        }
        if (!mb_check_encoding($string, $this->from)) {
            return false;
        }
        return true;
    }

}

?>
