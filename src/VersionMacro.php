<?php

namespace ADT\Latte\Macros;

use \Latte\Compiler;
use \Latte\MacroNode;
use \Latte\Macros\MacroSet;
use \Latte\PhpWriter;


class VersionMacro extends MacroSet
{
	public static function install(Compiler $compiler)
	{
		$me = new static($compiler);
		$me->addMacro('v', array($me, 'macroVersion'));
		$me->addMacro('vn', array($me, 'macroVersionNumber'));
		return $me;
	}

	/**
	 * Usage:
	 * <script type="text/javascript" src="/js/myJsFile{v}"></script>
	 */
	public function macroVersion(MacroNode $node, PhpWriter $writer)
	{
		return "echo '?v=". static::getVersion() ."'";
	}

	/**
	 * Usage:
	 * <script type="text/javascript" src="/js/myJsFile?v={vn}"></script>
	 */
	public function macroVersionNumber(MacroNode $node, PhpWriter $writer)
	{
		return "echo '". static::getVersion() ."'";
	}

	public static function getVersion() {
		static $out = NULL;

		if ($out !== NULL) {
			return $out;
		}

		$out = 0;

		$appDir = \Nette\Environment::getContext()->parameters['appDir'];

		$hpDeploymentFile = $appDir . '/../../.htdeployment';
		$ftpDeploymentFile = $appDir . '/../.git-ftp.log';

		if (is_file($hpDeploymentFile)) {
			$out = filemtime($hpDeploymentFile);
		}

		if (is_file($ftpDeploymentFile)) {
			$out = filemtime($ftpDeploymentFile);
		}

		return $out;
	}

}