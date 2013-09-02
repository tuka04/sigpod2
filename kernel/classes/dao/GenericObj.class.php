<?php

abstract class GenericObj extends BD {
	/**
	 * @var string
	 */
	private $tabela;
	/**
	 * @var BDColumns
	 */
	private $columns;
	
	public function  __construct(){
		$this->columns = new BDColumns();
		parent::__construct($this->tabela,$this->columns);
	}
	/**
	 * @return string
	 */
	public function getTabela(){
		return $this->tabela;
	}
	/**
	 * @return BDColumns
	 */
	public function getColumns(){
		return $this->columns;
	}
	/**
	 * @param string
	 */
	public function setTable($t){
		$this->tabela = $t;
	}
	/**
	 * @param BDColumns
	 */
	public function setColumn(BDColumns $c){
		$this->column = $c;
	}
}

?>