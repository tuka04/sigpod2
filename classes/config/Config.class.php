<?php
/**
 * Configuracoes de sistema
* @version 0.1 (01/9/2013)
* @package kernel
* @author Leandro Kümmel Tria Mendes
* @desc classe que contem informacoes de configuracoes de sistema
*/

class Config {
	/**
	 * Configuracoes do bd
	 * @var ConfigBD
	 */
	private $bd;
	
	public function __construct(){
		$this->setBD();
	}
	
	private function setBD(){
		$f = new File("config/conf.inc.php", "r");
		$vars = Base64::decode($f->getAllContent());
		$vars = explode(";", $vars);
		$this->bd = new ConfigBD();
		foreach ($vars as $k=>$v)
			$this->bd->$k=$v;
	} 
	/**
	 * @return ConfigBD
	 */
	public function getBD(){
		return $this->bd;
	}
}

final class ConfigBD {
	public $host;
	public $user;
	public $pass;
}