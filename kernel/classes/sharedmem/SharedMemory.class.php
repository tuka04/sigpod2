<?php
/**
 * SharedMemory
 * @version 2.0 (01/9/2013)
 * @package kernel
 * @author Leandro Kümmel Tria Mendes
 * @desc contem metodos responsaveis pelo apc
 * @see apc, pecl 
 */
class SharedMemory {
	
	const SMARTY = "smarty";
	const SMARTY_DBIT = "smarty_dirtybit";
	const CONFIG = "config";
	const CONFIG_DBIT = "config_dirtybit";
	/**
	 * 
	 */
	function __construct() {
		$this->init();
		apc_store(self::SMARTY_DBIT,1);
		$this->checkDBits();
	}
	
	private function checkDBits(){
		if(apc_fetch(self::SMARTY_DBIT)){
			require_once PATH_SERVER.'kernel/plugins/smarty/libs/Smarty.class.php';
			$s = new Smarty();
			$s->setTemplateDir(PATH_SMARTY_TEMPLATE);
			$s->setCompileDir(PATH_SMARTY_TEMPLATE_COMPILE);
			$s->setConfigDir(PATH_SMARTY_CONFIG);
			apc_store(self::SMARTY,$s);
			apc_store(self::SMARTY_DBIT,0);
		}
		if(apc_fetch(self::CONFIG_DBIT)){
			//configuracao
			require_once PATH_SERVER.'kernel/classes/config/Config.class.php';
			require_once PATH_SERVER.'kernel/classes/common/File.class.php';
			require_once PATH_SERVER.'kernel/classes/common/Base64.class.php';
			apc_store(self::CONFIG,new Config());
			apc_store(self::CONFIG_DBIT,0);
		}
	}
	private function init(){
		if(!apc_exists(self::SMARTY_DBIT))
			apc_store(self::SMARTY_DBIT,1);
		if(!apc_exists(self::CONFIG_DBIT))
			apc_store(self::CONFIG_DBIT,1);
	}
	
	/**
	 * 
	 */
	function __destruct() {
	
	}
}

?>