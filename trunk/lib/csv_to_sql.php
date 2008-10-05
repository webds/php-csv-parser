<?php

/**
 * csv to sql exporter
 *
 * Note: uses csv object
 *
 * @uses        csv
 * @package
 * @version     $Id$
 * @copyright   2008 Kazuyoshi Tlacaelel
 * @author      Kazuyoshi Tlacaelel <kazu.dev@gmail.com>
 * @license     MIT
 */
class csv_to_sql extends File_CSV_Get
{

    /**
     * template for sql query.
     *
     * override this in a child class for multiple-database support
     *
     * @var     string
     * @access  protected
     */
    protected $query_template = 'INSERT INTO %s (%s) VALUES (%s)';

    /**
     * sql dumper for symmetric data
     *
     * Exports csv data into sql. Only when the headers match all
     * records length (symmetric)
     *
     * @param   string $tablename   the tablename to use for inserts
     * @param   array  $headers     the headers to use, if none given
     *                              all headers are included by default
     * @access  public
     * @return  array
     * @see     symmetric(), asymmetry()
     */
    public function create_queries($tablename, $headers = array())
    {
        $queries = array();
        if (!$this->symmetric()) return $queries;
        if ($headers === array()) $headers = $this->headers();

        foreach ($this->rows() as $record) {
            $queries[] = sprintf(
                $this->query_template,
                $tablename,
                join(', ', $headers),
                $this->_join_record_values($record, $headers)
            );
        }
        return $queries;
    }

    private function _join_record_values($record, $headers)
    {
        foreach ($this->headers() as $key => $header) {
            if (in_array($header, $headers)) {
                $values[] = $this->convert($record[$key]);
            }
        }
        unset($record);
        return join(', ', $values);
    }

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

    public function conversion($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function convertable($string)
    {
        if (empty($string)) return false;
        if (empty($this->from)) return false;
        if (!mb_check_encoding($string, $this->from)) return false;
        return true;
    }

}

?>
