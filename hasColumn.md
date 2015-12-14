# Method:hasColumn #

_column existance checker_

checks if a column exists, columns are identified by their
header name.

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
$headers = $csv->getHeaders();
```


now lets check if the columns exist



```
var_export($csv->hasColumn($headers[0]));    // true
var_export($csv->hasColumn('age'));          // true
var_export($csv->hasColumn('I dont exist')); // false
```


  1. **Argument** _string_  $string an item returned by getHeaders()

  * **Visibility**  public
  * **Returns** boolean
  * **Also see** getHeaders()
