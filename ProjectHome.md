## Simple data access object for csv files in php5. ##
> by Kazuyoshi Tlacaelel.

# Some features #


## Cells ##

  1. **[fillCell](fillCell.md)** _cell value filler_
  1. **[getCell](getCell.md)** _cell fetcher_
  1. **[hasCell](hasCell.md)** _checks if a coordinate is valid_


## Headers ##

  1. **[countHeaders](countHeaders.md)** _header counter_
  1. **[createHeaders](createHeaders.md)** _header creator_
  1. **[getHeaders](getHeaders.md)** _header fetcher_
  1. **[setHeaders](setHeaders.md)** _header injector_


## Columns ##

  1. **[appendColumn](appendColumn.md)** _column appender_
  1. **[fillColumn](fillColumn.md)** _collumn data injector_
  1. **[getColumn](getColumn.md)** _column fetcher_
  1. **[hasColumn](hasColumn.md)** _column existance checker_
  1. **[removeColumn](removeColumn.md)** _column remover_
  1. **[walkColumn](walkColumn.md)** _column walker_


## Must see ##

  1. **[construct]** _data load initialize_
  1. **[connect](connect.md)** _header and row relationship builder_
  1. **[getRawArray](getRawArray.md)** _raw data as array_
  1. **[isSymmetric](isSymmetric.md)** _data length/symmetry checker_
  1. **[load](load.md)** _csv file loader_
  1. **[settings](settings.md)** _settings alterator_
  1. **[symmetrize](symmetrize.md)** _all rows length equalizer_
  1. **[walkGrid](walkGrid.md)** _grid walker_


## Rows ##

  1. **[appendRow](appendRow.md)** _row appender_
  1. **[countRows](countRows.md)** _row counter_
  1. **[fillRow](fillRow.md)** _fillRow_
  1. **[getAsymmetricRows](getAsymmetricRows.md)** _asymmetric data fetcher_
  1. **[getRow](getRow.md)** _row fetcher_
  1. **[getRows](getRows.md)** _multiple row fetcher_
  1. **[hasRow](hasRow.md)** _row existance checker_
  1. **[removeRow](removeRow.md)** _row remover_
  1. **[walkRow](walkRow.md)** _row walker_



## Comming soon ##

  1. **columns** (gets a range of columns)
  1. **export** (gets altered data as a csv string)
  1. **_url parsing_**
  1. **grepColumn** scans a column using a callback function
  1. **grepRow** scans a column using a callback function
  1. **grepGrid** scans the whole dataset using a callback function

# Using the package #

**csv file
```
name,age,skill
john,13,knows magic
tanaka,8,makes sushi
jose,5,dances salsa
```**

**php file
```

<?php

require_once 'File/CSV/DataSource.php';

$csv = new File_CSV_DataSource;
$csv->load('my_cool.csv');
var_export($csv->connect());

?>

```**

**output**

```

array (
  0 =>
  array (
    'name' => 'john',
    'age' => '13',
    'skill' => 'knows magic',
  ),
  1 =>
  array (
    'name' => 'tanaka',
    'age' => '8',
    'skill' => 'makes sushi',
  ),
  2 =>
  array (
    'name' => 'jose',
    'age' => '5',
    'skill' => 'dances salsa',
  ),
)


```

## Do not read this! ##
**Please DontReadThis for
  1. examples
  1. documentation
  1. information
  1. deprecations
  1. more...**

