# Method:load #

_csv file loader_

indicates the object which file is to be loaded



```

require_once 'File/CSV/DataSource.php';

$csv = new File_CSV_DataSource;
$csv->load('my_cool.csv');
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


  1. **Argument** _string_  $filename the csv filename to load

  * **Visibility**  public
  * **Returns** boolean true if file was loaded successfully
  * **Also see** isSymmetric(), getAsymmetricRows(), symmetrize()
