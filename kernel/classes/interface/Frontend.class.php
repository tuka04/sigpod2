<?php
/**
 * Frontend
 * @version 2.0 (01/9/2013)
 * @package kernel
 * @author Leandro Kümmel Tria Mendes
 * @desc classe responsavel por dar display em uma pagina html
 */
class Frontend {
	const EXTRA_JS = "EJS";
	const EXTRA_CSS = "ECSS";
	const SERVER = "server";
	/**
	 * @var Smarty
	 */
	private $smarty;
	/**
	 * Contem caminhos dos arquivos js
	 * @var ArrayObj
	 */
	private $js;
	/**
	 * Contem caminhos dos arquivos css
	 * @var ArrayObj
	 */
	private $css;
	/**
	 * @var Server
	 */
	private $server;
	/**
	 * 
	 */
	public function __construct() {
		$this->smarty = apc_fetch(SharedMemory::SMARTY);
		$this->js = new ArrayObj();
		$this->css = new ArrayObj();
		$this->server = new Server();
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
	/**
	 * Alias para Smarty::assign()
	 * @param string $var : nome da variavel
	 * @param mixed $val : valor da variavel
	 */
	public function assign($var,$val){
		$this->smarty->assign($var,$val);
	}
	/**
	 * Alias para display() do Smarty
	 * @param string $tpl : caminho/nome do template
	 */
	public function display($tpl){
		$this->assign(self::EXTRA_JS,$this->js->toString(""));
		$this->assign(self::EXTRA_CSS,$this->css->toString(""));
		$this->assign(self::SERVER,$this->server);
		$this->smarty->display($tpl);
	}
	/**
	 * Adiciona um arquivo js ao head do html
	 * @param string $js : caminho do arquivo
	 */
	public function addFileJS($js){
		$f = new FileInfo($js);
		if(!$f->isReadable())
			die(Error::toJson("Arquivo ".$js.": erro na leitura"));
		$this->js->append('<script type="text/javascript" src="'.$js.'"></script>');
	}
	/**
	 * Adiciona um arquivo css ao head do html
	 * @param string $css : caminho do arquivo
	 */
	public function addFileCSS($css){
		$f = new FileInfo($css);
		if(!$f->isReadable())
			die(Error::toJson("Arquivo ".$css.": erro na leitura"));
		$this->css->append('<link rel="stylesheet" type="text/css" src="'.$css.'" />');
	}
}

?>