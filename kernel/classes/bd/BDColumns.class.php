<?php
/**
 * BDColumns
 * @version 2.0 (01/9/2013)
 * @package kernel
 * @author Leandro Kümmel Tria Mendes
 * @desc Contem alguns atributos e metodos basicos de colunas de uma banco de dados
 * @see Acesso e querys aos bancos de dados
 */
final class BDColumns {
	/**
	 * nomes dos campos 
	 * @var ArrayObj
	 */
	private $names;
	/**
	 * Tipos dos campos
	 * @var ArrayObj
	 */
	private $type;
	/**
	 * Se os campos sao nulos
	 * @var ArrayObj
	 */
	private $null;
	/**
	 * tipo de key
	 * @var ArrayObj
	 */
	private $key;
	/**
	 * valor default para os campos
	 * @var ArrayObj
	 */
	private $default;
	/**
	 * campo a qual este ira referenciar
	 * @var ArrayObj
	 */
	private $foreign;
	
	function __construct() {
		$this->names=new ArrayObj();
		$this->type=new ArrayObj();
		$this->null=new ArrayObj();
		$this->key=new ArrayObj();
		$this->default=new ArrayObj();
		$this->foreign=new ArrayObj();
	}

	/**
	 * Insere um novo campo a lista de campos para uma tabela
	 * @param string $name
	 * @param string $type
	 * @param boolean $null
	 * @param string $key
	 * @param string $defaul
	 * @param string $foreign
	 */
	public function addCampo($name,$type,$null=true,$key="",$default="",$foreign=""){
		$this->names->append($name);
		$this->type->append($type);
		$this->null->append($null);
		$this->key->append($key);
		$this->default->append($default);
		$this->foreign->append($foreign);		
	}
	/**
	 * Retorna uma string para consulta no bd com os campos
	 * @param string $t
	 * @return string
	 * @example retornar tabela.campo1 as 'tabela_campo1'... OU campo1...
	 */
	public function toQuerieSelect($t=""){
		$str = "";
		foreach ($this->names->getArrayCopy() as $n){
			if(!empty($t)&&$t!="")
				$str .= $t.".".$n.", as '".$t."_".$n."'";
			else
				$str .= $n.", ";
		}
		return substr($n,0,-2);
	}
	/**
	 * Retorna uma string para criar a tabela
	 * @return string
	 */
	public function toQuerieCreate(){
		$str = "";
		$latter = "";
		foreach ($this->names->getArrayCopy() as $k=>$n){
			$str .= " ".$n." ".$this->type->offsetGet($k)."";
			$key = $this->key->offsetGet($k);
			if(!empty($key)&&$key!=""){
				if($key==ConfigBD::TOKEN_KEY_PRIMARY)
					$str .= " PRIMARY KEY AUTO_INCREMENT ";
				else if($key==ConfigBD::TOKEN_KEY_UNIQUE)
					$str .= " UNIQUE ";
				else if($key==ConfigBD::TOKEN_KEY_INDEX)
					$latter .= " INDEX idx_".$n." (".$n."), ";
				
			}
			if($this->null->offsetGet($k))
				$str .= " NULL ";
			else
				$str .= " NOT NULL ";
			$df = $this->default->offsetGet($k);	
			if(!empty($df)&&$df!="")
				$str .= " DEFAULT '".$df."' ";
			$foreign = $this->foreign->offsetGet($k);
			if(!empty($foreign)&&$foreign!="")
				$latter .= " FOREIGN KEY (".$n.") REFERENCES ".$foreign." ON DELETE NO ACTION UPDATE NO ACTION, ";
			$str .= ", ";
		}
		if($latter!="")
			$str .=substr($latter,0,-2);
		else 
			$str=substr($str,0,-2);
		return $str;
	}
	/**
	 * @return ArrayObj
	 */
	public function getNames(){
		return $this->names;	
	}
}

?>