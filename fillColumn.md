# Method:fillColumn #

_collumn data injector_

fills alll the data in the given column with $values

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

// if the csv file loads
if ($csv->load('my_cool.csv')) {

// grab all data within the age column
var_export($csv->getColumn('age'));

// rename all values in it with the number 99
var_export($csv->fillColumn('age', 99));

// grab all data within the age column
var_export($csv->getColumn('age'));

// rename each value in a column independently
$data = array(1, 2, 3);
$csv->fillColumn('age', $data);

var_export($csv->getColumn('age'));
}
```


standard output



```
array (
0 => '13',
1 => '8',
2 => '5',
)
```




```
true
```




```
array (
0 => 99,
1 => 99,
2 => 99,
)
```




```
array (
0 => 1,
1 => 2,
2 => 3,
)
```


  1. **Argument** _mixed_  $column the column identified by a string
  1. **Argument** _mixed_  $values ither one of the following
  1. (Number) will fill the whole column with the value of number
  1. (String) will fill the whole column with the value of string
  1. (Array) will fill the while column with the values of array
the array gets ignored if it does not match the length of rows

  * **Visibility**  public
  * **Returns** void
