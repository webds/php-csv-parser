# Method:fillRow #

_fillRow_

Replaces the contents of cells in one given row with $values.

sample of a csv file "my\_cool.csv"



```
name,age,skill
john,13,knows magic
tanaka,8,makes sushi
jose,5,dances salsa
```


if we load the csv file and fill the second row with new data?



```
// load the library
require_once 'File/CSV/DataSource.php';
$csv = new File_CSV_DataSource;

// load csv file
$csv->load('my_cool.csv');

// fill exitent row
var_export($csv->fillRow(1, 'x'));
```


output



```
true
```


now let's dump whatever we have changed



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
1 =>
array (
'name' => 'x',
'age' => 'x',
'skill' => 'x',
),
2 =>
array (
'name' => 'jose',
'age' => '5',
'skill' => 'dances salsa',
),
)
```


now lets try to fill the row with specific data for each cell



```
var_export($csv->fillRow(1, array(1, 2, 3)));
```


output



```
true
```


and dump the results



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
1 =>
array (
'name' => 1,
'age' => 2,
'skill' => 3,
),
2 =>
array (
'name' => 'jose',
'age' => '5',
'skill' => 'dances salsa',
),
)
```


  1. **Argument** _integer_  $row    the row to fill identified by its key
  1. **Argument** _mixed_    $values the value to use, if a string or number
is given the whole row will be replaced with this value.
if an array is given instead the values will be used to fill
the row. Only when the currently loaded dataset is symmetric

  * **Visibility**  public
  * **Returns** boolean
  * **Also see** isSymmetric(), getAsymmetricRows(), symmetrize(), fillColumn(),
fillCell(), appendRow()
