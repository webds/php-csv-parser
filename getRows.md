# Method:getRows #

_multiple row fetcher_

Extracts a rows in the following fashion
  1. all rows if no $range argument is given
  1. a range of rows identified by their key
  1. if rows in range are not found nothing is retrived instead
  1. if no rows were found an empty array is returned

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


now get the second and thirdh row



```
var_export($csv->getRows(array(1, 2)));
```


output



```
array (
0 =>
array (
0 => 'tanaka',
1 => '8',
2 => 'makes sushi',
),
1 =>
array (
0 => 'jose',
1 => '5',
2 => 'dances salsa',
),
)
```


now lets try something odd and the goodie third row



```
var_export($csv->getRows(array(9, 2)));
```


output



```
array (
0 =>
array (
0 => 'jose',
1 => '5',
2 => 'dances salsa',
),
)
```


  1. **Argument** _array_  $range a list of rows to retrive

  * **Visibility**  public
  * **Returns** array
