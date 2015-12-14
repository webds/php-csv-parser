# Method:getColumn #

_column fetcher_

gets all the data for a specific column identified by $name

Note $name is the same as the items returned by getHeaders()

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
var_export($csv->getColumn('name'));
```


the above example outputs something like



```

array (
0 => 'john',
1 => 'tanaka',
2 => 'jose',
)

```


  1. **Argument** _string_  $name the name of the column to fetch

  * **Visibility**  public
  * **Returns** array filled with values of a column
  * **Also see** getHeaders(), fillColumn(), appendColumn(), getCell(), getRows(),
getRow(), hasColumn()
