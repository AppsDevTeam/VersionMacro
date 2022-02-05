# Version macro

Returns file modification time, which can be used for versioning css/js files or other assets.

## Installation

The best way to install is using [Composer](http://getcomposer.org/):

```sh
$ composer require adt/version-macro
```

common.neon:
```	
services:
	- ADT\Latte\Macros\VersionMacro(%versionMacro%, %appDir%)

latte:
	macros:
		- @\ADT\Latte\Macros\VersionMacro::install

```

remote.neon:
```
services:
	versionMacro:
		setup:
			- setTimestampFile(%timestampFile%)
```

Without setting timestamp file, version macro returns empty string.

## Usage

- **`{v}`** - results in `?v=123`
- **`{vn}`** - results in `123`

```html
<script type="text/javascript" src="/js/myJsFile{v}"></script>
<script type="text/javascript" src="/js/myJsFile?v={vn}"></script>
```
