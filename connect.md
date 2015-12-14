# Method:connect #

_header and row relationship builder_

Attempts to create a relationship for every single cell that
was captured and its corresponding header. The sample below shows
how a connection/relationship is built.

sample of a csv file "my\_cool.csv"



```
name,age,skill
john,13,knows magic
tanaka,8,makes sushi
jose,5,dances salsa
```


php implementation



```

$csv = new File_CSV_DataSource;
$csv->load('my_cool.csv');

if (!$csv->isSymmetric()) {
die('file has headers and rows with different lengths
cannot connect');
}

var_export($csv->connect());

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



You can pass a collection of headers in an array to build
a connection for those columns only!



```

var_export($csv->connect(array('age')));

array (
0 =>
array (
'age' => '13',
),
1 =>
array (
'age' => '8',
),
2 =>
array (
'age' => '5',
),
)

```


  1. **Argument** _array_  $columns the columns to connect, if nothing
is given all headers will be used to create a connection

  * **Visibility**  public
  * **Returns** array If the data is not symmetric an empty array
will be returned instead
  * **Also see** isSymmetric(), getAsymmetricRows(), symmetrize(), getHeaders()
