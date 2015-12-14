# Method:walkRow #

_row walker_

goes through one full row of data and executes a callback
function per each cell in that row.

Note: callback functions get the value of the cell as an
argument, and whatever that callback returns will be used to
replace the current value of that cell.

  1. **Argument** _string_ |integer $row      anything that is numeric is a valid row
identificator. As long as it is within the range of the currently
loaded dataset

  1. **Argument** _string_          $callback the callback function to be executed
per each cell in a row

  * **Visibility**  public
  * **Returns** boolean
  1. false if callback does not exist
  1. false if row does not exits
