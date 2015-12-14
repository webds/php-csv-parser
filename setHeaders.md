# Method:setHeaders #

_header injector_

uses a $list of values which wil be used to replace current
headers.

Note: that given $list must match the length of all rows.
known as symmetric. see isSymmetric() and getAsymmetricRows() methods

Also, that current headers will be used as first row of data
and consecuently all rows order will change with this action.

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


And now lets create a new set of headers and attempt to inject
them into the current loaded dataset



```
$new_headers = array('a', 'b', 'c');
var_export($csv->setHeaders($new_headers));
```


output



```
true
```


Now lets try the same with some headers that do not match the
current headers length. (this should fail)



```
$new_headers = array('a', 'b');
var_export($csv->setHeaders($new_headers));
```


output



```
false
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
'a' => 'name',
'b' => 'age',
'c' => 'skill',
),
1 =>
array (
'a' => 'john',
'b' => '13',
'c' => 'knows magic',
),
2 =>
array (
'a' => 'tanaka',
'b' => '8',
'c' => 'makes sushi',
),
3 =>
array (
'a' => 'jose',
'b' => '5',
'c' => 'dances salsa',
),
)
```


  1. **Argument** _array_  $list a collection of names to use as headers,

  * **Visibility**  public
  * **Returns** boolean fails if data is not symmetric
  * **Also see** isSymmetric(), getAsymmetricRows(), getHeaders(), createHeaders()
