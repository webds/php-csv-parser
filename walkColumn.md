# Method:walkColumn #

_column walker_

goes through the whole column and executes a callback for each
one of the cells in it.

Note: callback functions get the value of the cell as an
argument, and whatever that callback returns will be used to
replace the current value of that cell.

  1. **Argument** _string_  $name     the header name used to identify the column
  1. **Argument** _string_  $callback the callback function to be called per
each cell value

  * **Visibility**  public
  * **Returns** boolean
  * **Also see** getHeaders(), fillColumn(), appendColumn()
