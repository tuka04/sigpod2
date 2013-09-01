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
		foreach ($vars as $v){
			$a = explode("=",$v);
			$this->bd->$a[0]=ltrim(rtrim($a[1]));
		}
	} 
	/**
	 * @return ConfigBD
	 */
	public function getBD(){
		return $this->bd;
	}
}

final class ConfigBD {
	const driver = 'mysql';
	const engine = 'InnoDB';
	const charset = 'utf8';
	const TOKEN_KEY_PRIMARY = 1;
	const TOKEN_KEY_INDEX = 2;
	const TOKEN_KEY_UNIQUE = 3;
	public $host;
	public $user;
	public $pass;
	public $database;
}