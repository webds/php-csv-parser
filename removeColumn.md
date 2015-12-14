# Method:removeColumn #

_column remover_

Completly removes a whole column identified by $name
Note: that this function will only work if data is symmetric.

sample of a csv file "my\_cool.csv"



```
name,age,skill
john,13,knows magic
tanaka,8,makes sushi
jose,5,dances salsa
```


load the library and csv file



```
require_once 'File/CSV/DataSource.php';
$csv = new File_CSV_DataSource;
$csv->load('my_cool.csv');
```


lets dump currently loaded data


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


and now let's remove the second column



```
var_export($csv->removeColumn('age'));
```


output



```
true
```


those changes made let's dump the data again and see what we got



```
array (
0 =>
array (
'name' => 'john',
'skill' => 'knows magic',
),
1 =>
array (
'name' => 'tanaka',
'skill' => 'makes sushi',
),
2 =>
array (
'name' => 'jose',
'skill' => 'dances salsa',
),
)
```


  1. **Argument** _string_  $name same as the ones returned by getHeaders();

  * **Visibility**  public
  * **Returns** boolean
  * **Also see** hasColumn(), getHeaders(), createHeaders(), setHeaders(),
isSymmetric(), getAsymmetricRows()
