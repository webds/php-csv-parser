# Method:getAsymmetricRows #

_asymmetric data fetcher_

finds the rows that do not match the headers length

lets assume that we add one more row to our csv file.
that has only two values. Something like



```
name,age,skill
john,13,knows magic
tanaka,8,makes sushi
jose,5,dances salsa
niki,6
```


Then in our php code



```
$csv->load('my_cool.csv');
var_export($csv->getAsymmetricRows());
```


The result



```

array (
0 =>
array (
0 => 'niki',
1 => '6',
),
)

```


  * **Visibility**  public
  * **Returns** array filled with rows that do not match headers
  * **Also see** getHeaders(), symmetrize(), isSymmetric(),
getAsymmetricRows()
