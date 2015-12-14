# Method:appendRow #

_row appender_

Aggregates one more row to the currently loaded dataset

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


now lets do some modifications, let's try adding three rows.



```
var_export($csv->appendRow(1));
var_export($csv->appendRow('2'));
var_export($csv->appendRow(array(3, 3, 3)));
```


output



```
true
true
true
```


and now let's try to see what has changed



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
3 =>
array (
'name' => 1,
'age' => 1,
'skill' => 1,
),
4 =>
array (
'name' => '2',
'age' => '2',
'skill' => '2',
),
5 =>
array (
'name' => 3,
'age' => 3,
'skill' => 3,
),
)
```


  1. **Argument** _array_  $values the values to be appended to the row

  * **Visibility**  public
  * **Returns** boolean
