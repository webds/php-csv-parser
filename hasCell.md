# Method:hasCell #

_checks if a coordinate is valid_

sample of a csv file "my\_cool.csv"



```
name,age,skill
john,13,knows magic
tanaka,8,makes sushi
jose,5,dances salsa
```


load the csv file



```
$csv = new File_CSV_DataSource;
var_export($csv->load('my_cool.csv'));   // true if file is
// loaded
```


find out if a coordinate is valid



```
var_export($csv->hasCell(99, 3)); // false
```


check again for a know valid coordinate and grab that cell



```
var_export($csv->hasCell(1, 1));  // true
var_export($csv->getCell(1, 1));            // '8'
```


  1. **Argument** _mixed_  $x the row to fetch
  1. **Argument** _mixed_  $y the column to fetch

  * **Visibility**  public
  * **Returns** void
