# Method:fillCell #

_cell value filler_

replaces the value of a specific cell

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

// load the csv file
$csv->load('my_cool.csv');

// find out if the given coordinate is valid
if($csv->hasCell(1, 1)) {

// if so grab that cell and dump it
var_export($csv->getCell(1, 1));       // '8'

// replace the value of that cell
$csv->fillCell(1, 1, 'new value');  // true

// output the new value of the cell
var_export($csv->getCell(1, 1));       // 'new value'

}
```


now lets try to grab the whole row



```
// show the whole row
var_export($csv->getRow(1));
```


standard output



```
array (
0 => 'tanaka',
1 => 'new value',
2 => 'makes sushi',
)
```


  1. **Argument** _integer_  $x     the row to fetch
  1. **Argument** _integer_  $y     the column to fetch
  1. **Argument** _mixed_    $value the value to fill the cell with

  * **Visibility**  public
  * **Returns** boolean
  * **Also see** hasCell(), getRow(), getRows(), getColumn()
