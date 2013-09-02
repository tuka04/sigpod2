<?php
/**
 * ArrayObj
 * @version 2.0 (01/9/2013)
 * @package kernel
 * @author Leandro Kümmel Tria Mendes
 * @desc classe que contem metodos de manipulacao da estrutura Array
 * @see ArrayObject
 */
class ArrayObj extends ArrayObject{
	
	public function __construct($array=array()){
		parent::__construct($array);
	}
	/**
	 * @param string $glue
	 * @return string
	 */
	public function toString($glue=","){
		$str = "";
		foreach ($this->getArrayCopy() as $a){
			if(is_object($a) && method_exists($a, "toString"))
				$str .= $a->toString().$glue;
			elseif(is_array($a))
				$str .= implode($glue,$a).$glue; 
			else
				$str .= $a.$glue; 
		}
		return rtrim($str,$glue);
	}
	/**
	 * Remove valores que não são unicos nessa estrutura
	 */
	public function makeUnique(){
		$this->exchangeArray(array_unique($this->getArrayCopy()));
	}
	
	/**
	 * Remove os valores $v, presentes nesse array
	 * @param unknown $v
	 */
	public function removeValue($v){
		$aux = new ArrayObject();
		foreach ($this->getArrayCopy() as $a){
			if($a!=$v)
				$aux->append($a);
		}
		$this->exchangeArray($aux->getArrayCopy());
	}
	/**
	 * converte esse array em json
	 * @return json
	 */
	public function toJson(){
		return json_encode($this->getArrayCopy());
	}
	
	/**
	 * Filtra, remove, as posicoes em branco de um array
	 */
	public function filterEmpty(){
		$this->removeValue("");
	}
	/**
	 * Faz a troca de um valor por outro em todas as posicoes em que $val for igaul
	 * @param mixed $val
	 * @param int $key
	 */
	public function replace($val,$replace){
		$aux = new ArrayObj();
		foreach ($this->getArrayCopy() as $k=>$v){
			if(empty($v)&&empty($val)){
				$aux->offsetSet($k,$replace);
			}
			else if($v==$val)
				$aux->offsetSet($k,$replace);
			else
				$aux->offsetSet($k,$v);
		}
		$this->exchangeArray($aux->getArrayCopy());
	}
	/**
	 * Coloca aspas em todos os registros do array, se for aspas simples $single = true
	 * @param boolean $single
	 */
	public function putQuotation($single=false){
		($single)?$this->putIniEndMark("'"):$this->putIniEndMark('"');
	}
	/**
	 * Faz o encode em entidades html, coloca NULL onde deve e aspas.
	 * @return string
	 */
	public function toQueryDB(){
		$this->encodeHtml();
		$this->putQuotation();
		$this->replace('""',"NULL");
		return $this->toString();
	}
	/**
	 * Faz o encode em entidades html, coloca NULL onde deve e aspas e retorna no estilo key="valor",
	 * @return string
	 */
	public function toQueryDBUpdate(){
		$this->encodeHtml();
		$this->putQuotation();
		$this->replace("","NULL");
		$str = "";
		foreach ($this->getArrayCopy() as $k=>$v)
			$str .= $k.' = '.$v.',';
		return substr($str,0,-1);
	}
	/**
	 * Faz encode de todas os registros (ou o passado pelo parametro) em entidades html
	 * @param mixed $key
	 */
	public function encodeHtml($key=null){
		if($key!=null&&$this->offsetExists($key))
			$this->offsetSet(CharSet::encodeHtml($this->offsetGet()));
		else{
			$a = new ArrayObj();
			foreach($this->getArrayCopy() as $k=>$v)
				$a->offsetSet($k,CharSet::encodeHtml($v));
			$this->exchangeArray($a->getArrayCopy());	
		}
	}
	/**
	 * Coloca a marca no inicio e final de cada registro do array
	 * @param mixed $mark
	 */
	public function putIniEndMark($mark){
		$aux = new ArrayObj();
		foreach ($this->getArrayCopy() as $k=>$a){
			if(!is_array($a)&&!is_object($a)){
				$aux->offsetSet($k, $mark.$a.$mark);
			}
		}
		$this->exchangeArray($aux->getArrayCopy());
	}
	
	/**
	 * Coloca a marca no inicio cada registro do array
	 * @param mixed $mark
	 */
	public function putIniMark($mark){
		$aux = new ArrayObj();
		foreach ($this->getArrayCopy() as $k=>$a){
			if(!is_array($a)&&!is_object($a)){
				$aux->offsetSet($k, $mark.$a.$mark);
			}
		}
		$this->exchangeArray($aux->getArrayCopy());
	}
	/**
	 * Espelha os valores que sao numerico ou string dentro de sua posicao
	 * @param string $glue
	 */
	public function mirrorValues($mirror=" "){
		$aux = new ArrayObj();
		foreach ($this->getArrayCopy() as $k=>$a){
			if(!is_array($a)&&!is_object($a)){
				$aux->offsetSet($k, $a.$mirror.$a);
			}
		}
		$this->exchangeArray($aux->getArrayCopy());
	}
	/**
	 * Faz o print_r desse array
	 * @param boolean $die
	 */
	public function debug($die=true){
		echo "<PRE>";
		print_r($this);
		echo "</PRE>";
		if($die)
			die("fim debug");
	}
}

?>