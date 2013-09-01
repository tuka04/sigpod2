<?php
include_once 'includes.php';
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
//PAREI AQUI: Falta fazer addJSFile, addCSSFile, Load de Files default, utilizar config do smarty para tal?
$f = new Frontend();
$f->getSmarty()->assign("titulo","Teste titulo");
$f->getSmarty()->assign("var","Hello");
$f->getSmarty()->display("teste.html");
?>