<?php

/**
 *  var_export(get_class_methods('File_CSV'));
 *
 *  array (
 *    0 => 'raiseError',
 *    1 => '_conf',
 *    2 => 'getPointer',
 *    3 => 'unquote',
 *    4 => 'readQuoted',
 *    5 => 'read',
 *    6 => '_dbgBuff',
 *    7 => 'write',
 *    8 => 'discoverFormat',
 *    9 => 'resetPointer',
 *  )
 */

require_once 'File/CSV.php';

$csv = new File_CSV;
$file = 'tests/data/symmetric.csv';
$conf = $csv->discoverFormat($file);

foreach (range(0, (Integer) ($conf['fields'])) as $iteration) {
    if ($iteration == 0) {
        $x = $csv->read($file, $conf);
        var_export($x);
    }
    // rows
}





?>
