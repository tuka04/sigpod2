<?php
/**
 * Frontend
 * @version 2.0 (01/9/2013)
 * @package kernel
 * @author Leandro Kümmel Tria Mendes
 * @desc classe responsavel por dar display em uma pagina html
 */
class Frontend {
	/**
	 * @var Smarty
	 */
	private $smarty;
	/**
	 * 
	 */
	public function __construct() {
		$this->smarty = unserialize($_SERVER[APC_SMARTY]);
	}
	
	/**
	 * 
	 */
	function __destruct() {
	
	}
	/**
	 * @return Smarty
	 */
	public function getSmarty(){
		return $this->smarty;
	}
}

?>