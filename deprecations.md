## Deprecations ##


First of all apologies, most of the deprecations **DO NOT**
support backwards compatibility. This is because through
some discussion on the "pear developers" mailing list.

We have decided that this changes are nescessary in order
to meet standards and make the package as easy to use for
as many developers as possible.

a list of deprecations are listed below by release.






### VERSION 0.2.1 ###

  1. **columnExists** will be renamed to hasColumn
  1. **rowExists** will be renamed to hasRow

### VERSION 0.2.2 ###

**Method renaming**

  1. column > getColumn
  1. headers > getHeaders
  1. row > getRow
  1. rows > getRows
  1. cell > getCell
  1. uses > load (also loadable as an optional argument in the contructor method) // will keep alias
  1. rawArray > getRawArray
  1. coordinatable > hasCell
  1. injectHeaders > setHeaders
  1. symmetric > isSymmetric // will keep alias
  1. settings > setConfig
  1. asymmetry > getAsymmetricRows // will keep alias

**Dropped classes**
  1. File\_CSV\_GetSql

**File removal (from package.xml)**
  1. doc/phpdoc/**1. misc/output**

**package.xml changes**
  1. README (change role from "data" to "doc")
  1. LICENCE (change role from "data" to "doc")

**README**
  1. add link to google-code documentation


### VERSION 1.0.0 ###

Package name renamed from
  * File\_CSV\_Get
to
  * File\_CSV\_DataSource

Alias methods in previous release have been removed.
all documentation has been updated, please refer to
it for examples and guidance.