# Method:removeRow #

_row remover_

removes one row from the current data set.

sample of a csv file "my\_cool.csv"



```
name,age,skill
john,13,knows magic
tanaka,8,makes sushi
jose,5,dances salsa
```


first let's load the file and output whatever was retrived.



```
require_once 'File/CSV/DataSource.php';
$csv = new File_CSV_DataSource;
$csv->load('my_cool.csv');
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


now lets remove the second row



```
var_export($csv->removeRow(1));
```


output



```
true
```


now lets dump again the data and see what changes have been
made



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
'name' => 'jose',
'age' => '5',
'skill' => 'dances salsa',
),
)
```


  1. **Argument** _mixed_  $number the key that identifies that row

  * **Visibility**  public
  * **Returns** boolean
  * **Also see** hasColumn(), getHeaders(), createHeaders(), setHeaders(),
isSymmetric(), getAsymmetricRows()
