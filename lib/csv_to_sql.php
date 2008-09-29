<?php

/**
 * csv to sql exporter
 *
 * Note: uses csv object
 *
 * @uses        csv
 * @package
 * @version     $Id$
 * @copyright   1997-2005 The PHP Group
 * @author      Kazuyoshi Tlacaelel <kazu.dev@gmail.com>
 * @license     MIT
 */
class csv_to_sql extends csv
{

    /**
     * template for sql query.
     *
     * override this in a child class for multiple-database support
     *
     * @var     string
     * @access  protected
     */
    protected $query_template = 'INSERT INTO %s (%s) VALUES (%s);';

    /**
     * sql dumper for symmetric data
     *
     * Exports csv data into sql. Only when the headers match all
     * records length (symmetric)
     *
     * @param   strings $tablename the tablename to use for inserts
     * @access  public
     * @return  array
     * @see     symmetric(), asymmetry()
     */
    public function create_queries($tablename)
    {
        $queries = array();
        if (!$this->symmetric()) return $queries;
        $headers = join(', ', $this->headers());

        foreach ($this->rows() as $record) {
            $values = $this->join_record_values($record);
            $queries[] = sprintf($this->query_template, $tablename, $headers,
                $values);
        }
        return $queries;
    }

    public function join_record_values($record)
    {
        $values = array();
        foreach ($record as $value) {
            if ($this->convertable($value)) {
                $value = mb_ereg_replace("/'/", '\'', $value);
                $value = mb_convert_encoding($value, $this->from, $this->to);
            } else {
                $value = preg_replace("/'/", '\'', $value);
            }
            $values[] = "'" . $value . "'";
        }
        unset($record);
        return join(', ', $values);
    }

    public function conversion($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function convertable($string)
    {
        $encodings = mb_list_encodings();
        if (!in_array($from, $encodings)) return false;
        if (!in_array($to, $encodings)) return false;
        if (!mb_check_encoding($string, $from)) return false;
        return true;
    }

}

?>
