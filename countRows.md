# Method:countRows #

_row counter_

This function will exclude the headers

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
var_export($csv->countRows()); // returns 3
```


  * **Visibility**  public
  * **Returns** integer
