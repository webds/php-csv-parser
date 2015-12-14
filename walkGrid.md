# Method:walkGrid #

_grid walker_

travels through the whole dataset executing a callback per each
cell

Note: callback functions get the value of the cell as an
argument, and whatever that callback returns will be used to
replace the current value of that cell.

  1. **Argument** _string_  $callback the callback function to be called per
each cell in the dataset.

  * **Visibility**  public
  * **Returns** void
  * **Also see** walkColumn(), walkRow(), fillColumn(), fillRow(), fillCell()
