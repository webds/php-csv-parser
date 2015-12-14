# Method:createHeaders #

_header creator_

uses prefix and creates a header for each column suffixed by a
numeric value

by default the first row is interpreted as headers but if we
have a csv file with data only and no headers it becomes really
annoying to work with the current loaded data.

this function will create a set dinamically generated headers
and make the current headers accessable with the row handling
functions

Note: that the csv file contains only data but no headers
sample of a csv file "my\_cool.csv"



```
john,13,knows magic
tanaka,8,makes sushi
jose,5,dances salsa
```


checks if the csv file was loaded



```
$csv = new File_CSV_DataSource;
if (!$csv->load('my_cool.csv')) {
die('can not load csv file');
}
```


dump current headers



```
var_export($csv->getHeaders());
```


standard output



```
array (
0 => 'john',
1 => '13',
2 => 'knows magic',
)
```


generate headers named 'column' suffixed by a number and interpret
the previous headers as rows.



```
$csv->createHeaders('column')
```


dump current headers



```
var_export($csv->getHeaders());
```


standard output



```
array (
0 => 'column_1',
1 => 'column_2',
2 => 'column_3',
)
```


build a relationship and dump it



```
var_export($csv->connect());
```


output



```

array (
0 =>
array (
'column_1' => 'john',
'column_2' => '13',
'column_3' => 'knows magic',
),
1 =>
array (
'column_1' => 'tanaka',
'column_2' => '8',
'column_3' => 'makes sushi',
),
2 =>
array (
'column_1' => 'jose',
'column_2' => '5',
'column_3' => 'dances salsa',
),
)
```


  1. **Argument** _string_  $prefix string to use as prefix for each
independent header

  * **Visibility**  public
  * **Returns** boolean fails if data is not symmetric
  * **Also see** isSymmetric(), getAsymmetricRows()
