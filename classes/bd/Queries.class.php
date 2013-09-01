<?php
/**
 * Queries
 * @version 2.0 (01/9/2013)
 * @package kernel
 * @author Leandro Kümmel Tria Mendes
 * @desc classe que contem constantes importantes para uso de queries no bd
 */
abstract class SQLQueries {
	const SELECT = "SELECT {campos} FROM {tabela} {where} {order} {limit};";
	const SELECT_JOIN = "SELECT {campos} FROM {tabela} {join} {where} {order} {limit};";
	const SELECT_DISTINCT = "SELECT DISTINCT {campos} FROM {tabela} {where} {order} {limit};";
	const INSERT= "INSERT INTO {tabela} ({campos}) VALUES ({valores});";
	const INSERT_DUPLICATE= "INSERT INTO {tabela} ({campos}) VALUES ({valores}) ON DUPLICATE KEY UPDATE {duplicate};";
	const UPDATE= "UPDATE {tabela} SET {campos}";
	const UPDATE_WHERE= "UPDATE {tabela} SET {campos} {where};";
	const DELETE = "DELETE FROM {tabela} {where};";
	const TOKEN_INSERT_VALORES = "{valores}";
	const TOKEN_INSERT_DUPLICATE = "{duplicate}";
	const TOKEN_UPDATE_VALOR = self::TOKEN_INSERT_VALORES;//alias
	const TOKEN_CAMPOS = "{campos}";
	const TOKEN_UPDATE_CAMPOS = self::TOKEN_CAMPOS;//alias
	const TOKEN_TABELA = "{tabela}";
	const TOKEN_WHERE = "{where}";
	const TOKEN_JOIN = "{join}";
	const TOKEN_ORDER = "{order}";
	const TOKEN_LIMIT = "{limit}";
}
/**
 * WhereClause
 * @version 2.0 (01/08/2013)
 * @package kernel
 * @subpackage BD
 * @author Leandro Kümmel Tria Mendes
 * @desc classe que manipula uma clausula WHERE de uma query no banco 
 * @see Acesso e querys aos bancos de dados
 */
class SQLWhereClause {
	const EQUAL = "=";
	/**
	* @var string
	*/
	private $campo;
	/**
	* @var string
	*/
	private $valor;
	/**
	 * Clausula de Interseccao (and ou or) entre where_clauses 
	 * @var string
	 */
	private $inter;
	/**
	 * @var string
	 */
	private $comp;
	/**
	 * @param string $campo
	 * @param string|ArrayObj $valor
	 * @param string $comp
	 * @param string $inter
	 */
	public function __construct($campo="",$valor="",$comp=" = ",$inter="AND"){
		if(is_array($campo)){
			if(!is_array($valor) || count($campo)!=count($valor))
				die("WhereClause: ".__FILE__." ".__LINE__." Erro na entrada array campo != array valor");
			$this->campo=$campo;
			$this->valor=$valor;
			$this->comp=$comp;
			$this->inter=$inter;
			return;
		}
		$this->comp=$comp;
		if(is_array($valor)){
			$this->comp="IN";
			if(!is_object($valor))
				$valor = new ArrayObj($valor);
			$valor->putQuotation(false);
			$this->valor="(".$valor->toString().")";
		}
		else 
			$this->valor="'".$valor."'";
		$this->campo=$campo;

	}
	/**
	 * @param string|array $campo
	 * @param string|array|ArrayObj $valor
	 * @param string|array $comp
	 * @param string $inter
	 * @return string
	 */
	private function getManyClauses(){
		$res = "";
		if(is_array($this->comp)&& count($this->comp)!=count($this->campo))
			die("WhereClause: ".__FILE__." ".__LINE__." Erro na entrada count (array campo) != count(array comp)");
		else{
			foreach ($this->campo as $i=>$c){
				if(is_array($this->comp))
					$compare = $this->comp[$i];
				else
					$compare=$this->comp;
				if(is_array($this->valor[$i])||is_object($this->valor[$i])){
					if(!is_object($this->valor[$i]))
						$this->valor[$i] = new ArrayObj($this->valor[$i]);
					$this->valor[$i]->putQuotation(true);
					$res .= $c." IN (".$this->valor[$i]->toString().") ".$this->inter." ";
				}
				else{
					$res .= $c." ".$compare." '".$this->valor[$i]."' ".$this->inter." ";
				}
			}
		}
		return rtrim($res,$this->inter." ");
	}
	/**
	 * @return string
	 */
	private function getSingleClause(){
		return $this->campo." ".$this->comp." ".$this->valor." ";
	}
	/**
	 * @return string
	 */
	public function getClause(){
		if($this->campo=="")
			return "";
		if(is_array($this->campo))
			return $this->getManyClauses();
		return $this->getSingleClause();
	}
	/**
	 * @return string
	 */
	public function toString(){
		if(empty($this->campo)||empty($this->valor))
			return "";
		return " WHERE ".$this->getClause();
	}

}
/**
 * SQLJoin
 * @version 2.0 (01/08/2013)
 * @package kernel
 * @subpackage BD
 * @author Leandro Kümmel Tria Mendes
 * @desc classe que monta uma join sql 
 * @see Acesso e querys aos bancos de dados
 */
class SQLJoin {
	/**
	 * Flag indicativa se ha mais de um join a ser realizado
	 * @var boolean
	 */
	private $many;
	/**
	 * Geralmente eh tabela.tabelaJoinCampoID
	 * @var mixed<string,ArrayObj>
	 */
	private $campo;
	/**
	 * @var mixed<string,ArrayObj>
	 */
	private $objeto;
	/**
	 * @var mixed<string,ArrayObj>
	 */
	private $join;
	/**
	 * @param mixed<string,ArrayObj> $join
	 * @param mixed<string,ArrayObj> $campo
	 * @param mixed<string,ArrayObj> $objeto
	 */
	public function __construct($join=null,$campo=null,$objeto=null){
		if($join==null && $campo==null && $objeto==null){
			$this->campo=$campo;
			$this->objeto=$objeto;
			$this->join=$join;	
			$this->many=null;
			return;
		}
		if(!is_object($objeto))
			die(Error::toJson(__FILE__.":".__LINE__." Parametros objeto eh o objeto da tabela "));
		if(get_class($objeto)==get_class(new ArrayObj())){
			if(!is_object($campo))
				die(Error::toJson(__FILE__.":".__LINE__." Se um parametro for do tipo ArrayObj todos devem ser "));
			else if(get_class($objeto)!=get_class($campo))
				die(Error::toJson(__FILE__.":".__LINE__." Se um parametro for do tipo ArrayObj todos devem ser "));
			else if($objeto->count()!=$campo->count())
				die(Error::toJson(__FILE__.":".__LINE__." Se um parametro for do tipo ArrayObj todos devem ter o mesmo tamanho "));
			$this->many=true;
		}
		else{
			$this->many=false;
		}
		$this->campo=$campo;
		$this->objeto=$objeto;
		$this->join=$join;
	}
	/**
	 * Retorna parte da query referente a joins (LEFT, INNER, OUTER....)
	 * @return string
	 */
	public function toString(){
		$str = "";
		if($this->campo==null||$this->join==null||$this->objeto==NULL)
			return $str;
		if($this->many){
			foreach ($this->campo->getArrayCopy() as $k=>$c){
				if(!is_object($this->join))
					$str .= $this->join." ";
				else 
					$str .= $this->join->offsetGet($k)." ";
				$str .= $objeto->offsetGet($k)->getTabela()." ON ".$c." = ".$objeto->offsetGet($k)->getTabela().$objeto->offsetGet($k)->getCampoId()." ";
			}
		}
		else{
			$str .= $objeto->getTabela()." ON ".$c." = ".$objeto->getTabela().$objeto->getCampoId()." ";
		}
		return $str;
	}
}

class SQLOrderedBy {
	/**
	 * @var string
	 */
	private $campo;
	/**
	 * @var string
	 */
	private $order;
	/**
	 * @param string $campo
	 * @param string $order
	 */
	public function __construct($campo="",$order="ASC"){
		$this->campo=$campo;
		$this->order=$order;
	}
	/**
	 * @return string
	 */
	public function toString(){
		if(empty($this->order)||empty($this->campo))
			return "";
		return " ORDER BY ".$this->campo." ".$this->order;
	}
}

class SQLLimit{
	/**
	 * @var int
	 */
	private $ini;
	/**
	 * @var int
	 */
	private $end;
	/**
	 * @param int $ini
	 * @param int $end
	 */
	public function __construct($ini=0,$end=0){
		$this->ini=$ini;
		$this->end=$end;
	}
	/**
	 * @return string
	 */
	public function toString(){
		if($this->ini==$this->end)
			return "";
		return " LIMIT ".$this->ini." , ".$this->end;
	}
}