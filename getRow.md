# Method:getRow #

_row fetcher_

Note: first row is zero

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


Now let's fetch the second row



```
var_export($csv->getRow(1));
```


output



```
array (
0 => 'tanaka',
1 => '8',
2 => 'makes sushi',
)
```


  1. **Argument** _integer_  $number the row number to fetch

  * **Visibility**  public
  * **Returns** array the row identified by number, if $number does
not exist an empty array is returned instead
