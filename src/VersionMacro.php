<?php

namespace ADT\Latte\Macros;

use \Latte\Compiler;
use \Latte\MacroNode;
use \Latte\Macros\MacroSet;
use \Latte\PhpWriter;
use \Nette\InvalidArgumentException;

final class VersionMacro
{
	static private ?int $timestamp = null;
	static private ?string $timestampFile = null;

	public function setTimestampFile(string $timestampFile): self
	{
		if (! is_file($timestampFile)) {
			throw new InvalidArgumentException("File '$timestampFile' not found or is not a file!");
		}

		self::$timestampFile = $timestampFile;

		return $this;
	}

	public static function install(Compiler $compiler): MacroSet
	{
		$me = new MacroSet($compiler);
		$me->addMacro('v', array(__CLASS__, 'macroVersion'));
		$me->addMacro('vn', array(__CLASS__, 'macroVersionNumber'));
		return $me;
	}

	/**
	 * @internal
	 * Usage:
	 * <script type="text/javascript" src="/js/myJsFile{v}"></script>
	 */
	public static function macroVersion(MacroNode $node, PhpWriter $writer): string
	{
		return "echo '?v=". self::getVersion() ."'";
	}

	/**
	 * @internal
	 * Usage:
	 * <script type="text/javascript" src="/js/myJsFile?v={vn}"></script>
	 */
	public static function macroVersionNumber(MacroNode $node, PhpWriter $writer): string
	{
		return "echo '" . self::getVersion() . "'";
	}

	private static function getVersion(): int
	{
		if (self::$timestamp) {
			return self::$timestamp;
		}

		self::$timestamp = time();

		if (self::$timestampFile) {
			self::$timestamp = filemtime(self::$timestampFile);
		}

		return self::$timestamp;
	}
}
