# Method:appendColumn #

_column appender_

Appends a column and each or all values in it can be
dinamically filled. Only when the $values argument is given.


```


var_export($csv->fillColumn('age', 99));
true

var_export($csv->appendColumn('candy_ownership', array(99, 44, 65)));
true

var_export($csv->appendColumn('import_id', 111111111));
true

var_export($csv->connect());

array (
0 =>
array (
'name' => 'john',
'age' => 99,
'skill' => 'knows magic',
'candy_ownership' => 99,
'import_id' => 111111111,
),
1 =>
array (
'name' => 'tanaka',
'age' => 99,
'skill' => 'makes sushi',
'candy_ownership' => 44,
'import_id' => 111111111,
),
2 =>
array (
'name' => 'jose',
'age' => 99,
'skill' => 'dances salsa',
'candy_ownership' => 65,
'import_id' => 111111111,
),
)

```


  1. **Argument** _string_  $column an item returned by getHeaders()
  1. **Argument** _mixed_   $values same as fillColumn()

  * **Visibility**  public
  * **Returns** boolean
  * **Also see** getHeaders(), fillColumn(), fillCell(), createHeaders(),
setHeaders()
