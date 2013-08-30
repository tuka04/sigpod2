<?php
/**
 * Data Access Object
 * @version 0.1 (01/9/2013)
 * @package kernel
 * @author Leandro Kümmel Tria Mendes
 * @desc classe q manipula acoes em bd
 * @see Acesso e querys aos bancos de dados
 */

class BD extends PDO {
	/**
	 * Tabela
	 * @var string
	 */
	private $tabela;
	/**
	 * Campos
	 * @var ArrayObj
	 */
	private $campos;
	
	public function __construct(){
		$conf = apc_fetch(APC_CONF);
		parent::__construct($conf->getBD()->host,$conf->getBD()->user,$conf->getBD()->pass);
	}
	
	public function insert($valores){
		$qr = Queries::INSERT;
		$qr = str_replace(Queries::TOKEN_TABELA, $this->tabela, $qr);
		$qr = str_replace(Queries::TOKEN_CAMPOS, implode(',',$this->campos), $qr);
		foreach ($valores as &$v){
			if($v!=NULL)
				$v = '"'.$v.'"';
			else
				$v = 'NULL';
		}
		$qr = str_replace(Queries::TOKEN_INSERT_VALORES, implode(',',$valores), $qr);
		return $this->query($qr);
	}
}
?>