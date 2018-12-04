<?php

namespace ADT\Latte\Macros;

use \Latte\Compiler;
use \Latte\MacroNode;
use \Latte\Macros\MacroSet;
use \Latte\PhpWriter;
use \Nette\InvalidArgumentException;

class VersionMacro {

	use \Nette\SmartObject;
	
	/** @var array */
	protected $parameters;

	/** @var string */
	protected $appDir;

	public function __construct($parameters, $appDir) {
		$this->parameters = $parameters;
		$this->appDir = $appDir;
	}

	public function install(Compiler $compiler) {
		$me = new MacroSet($compiler);
		$me->addMacro('v', array($this, 'macroVersion'));
		$me->addMacro('vn', array($this, 'macroVersionNumber'));
		return $me;
	}

	/**
	 * Usage:
	 * <script type="text/javascript" src="/js/myJsFile{v}"></script>
	 */
	public function macroVersion(MacroNode $node, PhpWriter $writer)
	{
		return "echo '?v=". $this->getVersion() ."'";
	}

	/**
	 * Usage:
	 * <script type="text/javascript" src="/js/myJsFile?v={vn}"></script>
	 */
	public function macroVersionNumber(MacroNode $node, PhpWriter $writer)
	{
		return "echo '". $this->getVersion() ."'";
	}

	public function getVersion() {
		static $out = NULL;

		if ($out !== NULL) {
			return $out;
		}

		$timestampFile = NULL;

		// Necháváme kvůli zpětné kompatibilitě:
		$timestampFile = isset($this->parameters['htdeployment'])
			? $this->parameters['htdeployment']
			: $this->appDir . '/../.htdeployment';

		if (isset($this->parameters['timestampFile'])) {
			$timestampFile = $this->parameters['timestampFile'];
		}

		if (! is_file($timestampFile)) {
			throw new InvalidArgumentException("File '$timestampFile' not found or is not a file!");
		}

		return filemtime($timestampFile);
	}
}
