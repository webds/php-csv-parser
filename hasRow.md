# Method:hasRow #

_row existance checker_

Scans currently loaded dataset and
checks if a given row identified by $number exists

sample of a csv file "my\_cool.csv"



```
name,age,skill
john,13,knows magic
tanaka,8,makes sushi
jose,5,dances salsa
```


load library and csv file



```
require_once 'File/CSV/DataSource.php';
$csv = new File_CSV_DataSource;
$csv->load('my_cool.csv');
```


build a relationship and dump it so we can see the rows we will
be working with



```
var_export($csv->connect());
```


output



```
array (
0 =>
array (
'name' => 'john',
'age' => '13',
'skill' => 'knows magic',
),
1 =>  // THIS ROW EXISTS!!!
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


now lets check for row existance



```
var_export($csv->hasRow(1));
var_export($csv->hasRow(-1));
var_export($csv->hasRow(9999));
```


output



```
true
false
false
```


  1. **Argument** _mixed_  $number a numeric value that identifies the row
you are trying to fetch.

  * **Visibility**  public
  * **Returns** boolean
  * **Also see** getRow(), getRows(), appendRow(), fillRow()
