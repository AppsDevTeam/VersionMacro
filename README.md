## ADT\Latte\Macros\VersionMacro

Returns `.htdeployment` [filemtime](http://php.net/manual/en/function.filemtime.php).

## Installation

The best way to install is using [Composer](http://getcomposer.org/):

```sh
$ composer require adt/version-macro
```

```
parameters:
	versionMacro:
		timestampFile: '%wwwDir%/index.php'

latte:
	macros:
		- @\ADT\Latte\Macros\VersionMacro::install

services:
	- ADT\Latte\Macros\VersionMacro(%versionMacro%, %appDir%)
```

Deprecated parameters names (we still support it):
```
parameters:
	versionMacro:
		htdeployment: '%appDir%/../.htdeployment'
```

## Usage

- **`{v}`** - results in `?v=123`
- **`{vn}`** - results in `123`

```html
<script type="text/javascript" src="/js/myJsFile{v}"></script>
<script type="text/javascript" src="/js/myJsFile?v={vn}"></script>
```