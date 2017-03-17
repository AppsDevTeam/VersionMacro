## ADT\Latte\Macros\VersionMacro

Returns `.htdeployment` [filemtime](http://php.net/manual/en/function.filemtime.php).

## Installation

The best way to install is using [Composer](http://getcomposer.org/):

composer.json:
```
"repositories": [
	{
		"type": "git",
		"url": "https://github.com/AppsDevTeam/VersionMacro.git"
    }
]
```

```sh
$ composer require adt/version-macro
```

```
latte:
	macros:
		- @\ADT\Latte\Macros\VersionMacro::install

services:
	- ADT\Latte\Macros\VersionMacro(%versionMacro%, %appDir%)
```

Default configuration:
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