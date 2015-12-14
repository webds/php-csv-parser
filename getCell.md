# Method:getCell #

_cell fetcher_

gets the value of a specific cell by given coordinates

Note: That indexes start with zero, and headers are not
searched!

For example if we are trying to grab the cell that is in the
second row and the third column



```
name,age,skill
john,13,knows magic
tanaka,8,makes sushi
jose,5,dances salsa
```


we would do something like


```
var_export($csv->getCell(1, 2));
```


and get the following results


```
'makes sushi'
```


  1. **Argument** _integer_  $x the row to fetch
  1. **Argument** _integer_  $y the column to fetch

  * **Visibility**  public
  * **Returns** mixed|false the value of the cell or false if the cell does
not exist
  * **Also see** getHeaders(), hasCell(), getRow(), getRows(), getColumn()
