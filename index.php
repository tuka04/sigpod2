<?php
include_once 'kernel/config/server.php';
include_once PATH_SERVER.'kernel/includes.php';
class Teste extends BD{
	private $tabela = "teste";
	/**
	 * @var BDColumns
	 */
	private $campos;
	public function  __construct(){
		$c = new BDColumns();
		$c->addCampo("id","int",false,ConfigBD::TOKEN_KEY_PRIMARY);
		$c->addCampo("x","varchar(50)",true,"","def val");
		$c->addCampo("y","int",false);
		$this->campos = $c;
		parent::__construct($this->tabela,$c);
	}
}	
$t = new Teste();
$f = new Frontend();
$f->display("teste.html");

?>