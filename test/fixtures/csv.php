<?php

$fixtures = array( 

    'fpath' => 'data/',

    'symmetric_headers' => array (
      0 => 'header_a',
      1 => 'header_b',
      2 => 'header_c',
      3 => 'header_d',
      4 => 'header_e',
    ),

    'ninth_row_from_symmetric' => array (
      0 => '9aa',
      1 => '9bb',
      2 => '9cc',
      3 => '9dd',
      4 => '9ee',
    ),

    'non_valid_files' => array(
       "no_exists.csv" => 'non existent file',
       "invalid_ext.csv.txt" => 'invalid extension file',
        ),

    'valid_files' => array(
       "empty.csv" => 'emtpy csv file',
       "uppercased.CSV" => 'upper cased extension',
       "multcased.CsV" => 'multiple cased extension',
       "symmetric.csv" => 'symmetric data',
       "asymmetric.csv" => 'asymmetric data',
       "escape_ok.csv" => 'valid escape syntax file',
        ),

    'expected_headers' => array('COL_1', 'COL_2', 'COL_3', 
        'COL_4', 'COL_5'),

    'original_headers' => array(
      'header_a',
      'header_b',
      'header_c',
      'header_d',
      'header_e',
    ),

    'symmetric_connection' => array (
      0 => 
      array (
        'header_a' => '1aa',
        'header_b' => '1bb',
        'header_c' => '1cc',
        'header_d' => '1dd',
        'header_e' => '1ee',
      ),
      1 => 
      array (
        'header_a' => '2aa',
        'header_b' => '2bb',
        'header_c' => '2cc',
        'header_d' => '2dd',
        'header_e' => '2ee',
      ),
      2 => 
      array (
        'header_a' => '3aa',
        'header_b' => '3bb',
        'header_c' => '3cc',
        'header_d' => '3dd',
        'header_e' => '3ee',
      ),
      3 => 
      array (
        'header_a' => '4aa',
        'header_b' => '4bb',
        'header_c' => '4cc',
        'header_d' => '4dd',
        'header_e' => '4ee',
      ),
      4 => 
      array (
        'header_a' => '5aa',
        'header_b' => '5bb',
        'header_c' => '5cc',
        'header_d' => '5dd',
        'header_e' => '5ee',
      ),
      5 => 
      array (
        'header_a' => '6aa',
        'header_b' => '6bb',
        'header_c' => '6cc',
        'header_d' => '6dd',
        'header_e' => '6ee',
      ),
      6 => 
      array (
        'header_a' => '7aa',
        'header_b' => '7bb',
        'header_c' => '7cc',
        'header_d' => '7dd',
        'header_e' => '7ee',
      ),
      7 => 
      array (
        'header_a' => '8aa',
        'header_b' => '8bb',
        'header_c' => '8cc',
        'header_d' => '8dd',
        'header_e' => '8ee',
      ),
      8 => 
      array (
        'header_a' => '9aa',
        'header_b' => '9bb',
        'header_c' => '9cc',
        'header_d' => '9dd',
        'header_e' => '9ee',
      ),
    ),

    // see asymmetric file
    'asymmetric_rows' => array (
      0 => 
      array (
        0 => '5aa',
        1 => '5bb',
        2 => '5cc',
        3 => '5dd',
        4 => '5ee',
        5 => 'extra1',
      ),
      1 => 
      array (
        0 => '8aa',
        1 => '8bb',
        2 => '8cc',
        3 => '8dd',
        4 => '8ee',
        5 => 'extra2',
      ),
    ),

    'expected_column' => array (
      0 => '1cc',
      1 => '2cc',
      2 => '3cc',
      3 => '4cc',
      4 => '5cc',
      5 => '6cc',
      6 => '7cc',
      7 => '8cc',
      8 => '9cc',
    ),

    'expected_raw' => array (
      0 => 
      array (
        0 => 'h_one',
        1 => 'h_two',
        2 => 'h_three',
      ),
      1 => 
      array (
        1 => 
        array (
          0 => 'v_1one',
          1 => 'v_1two',
          2 => 'v_1three',
        ),
        2 => 
        array (
          0 => 'v_2one',
          1 => 'v_2two',
          2 => 'v_2three',
        ),
        3 => 
        array (
          0 => 'v_3one',
          1 => 'v_3two',
          2 => 'v_3three',
        ),
        4 => 
        array (
          0 => '',
        ),
      ),
    ),

    'expected_escaped' => array (
      0 => 
      array (
        'one' => 'thie,',
        'two' => 'adn',
        'three' => 'thei',
      ),
      1 => 
      array (
        'one' => 'thie',
        'two' => 'adn',
        'three' => 'thei',
      ),
    ),

    'header_a_connection' => array (
        0 => 
        array (
        'header_a' => '1aa',
        ),
        1 => 
        array (
        'header_a' => '2aa',
        ),
        2 => 
        array (
        'header_a' => '3aa',
        ),
        3 => 
        array (
        'header_a' => '4aa',
        ),
        4 => 
        array (
        'header_a' => '5aa',
        ),
        5 => 
        array (
        'header_a' => '6aa',
        ),
        6 => 
        array (
        'header_a' => '7aa',
        ),
        7 => 
        array (
        'header_a' => '8aa',
        ),
        8 => 
        array (
        'header_a' => '9aa',
        ),
    ),
);

function fix($key) {
    global $fixtures;
    if (!array_key_exists($key, $fixtures)) {
        throw new Exception("Fixture not found: '$key' ");
    }
    return $fixtures[$key];
}

?>
