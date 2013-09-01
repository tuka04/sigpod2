<?php
/**
 * Data Access Object
 * @version 2.0 (01/9/2013)
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
	/**
	 * Campo que representa como id
	 * @var string
	 */
	private $id;
	/**
	 * Colunas da tabela do banco de dados
	 * @var BDColumns
	 */
	private $columns;
	
	public function __construct($tabela,BDColumns $columns){
		$conf = unserialize($_SERVER[APC_CONF]);
//		$conf = apc_fetch(APC_CONF);
		try{
			parent::__construct(ConfigBD::driver.":host=".$conf->getBD()->host.";dbname=".$conf->getBD()->database,$conf->getBD()->user,$conf->getBD()->pass);
			$this->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);	
		}catch (PDOException $e){
			echo Error::toJson("ErroNumero ".$e->getCode()." : ".$e->getMessage());
		}
		$this->tabela=$tabela;
		$this->campos=$columns->getNames();
		$this->columns=$columns;
	}
	/**
	 * Metodo que cria a tabela
	 */
	public function create(){
		$qr = "CREATE TABLE IF NOT EXISTS ".$this->tabela." (";
		$qr .= $this->columns->toQuerieCreate().")";
		$qr .= "ENGINE=".ConfigBD::engine." DEFAULT CHARACTER SET = ".ConfigBD::charset.";";
		$this->execQuery($qr);
	}
	/**
	 * Funcao que executa uma query garantindo o ACID
	 * @param string $qr
	 * @return PDOStatement
	 */
	public function execQuery($qr,$obj_name=null,$insert=false){
		$ret = new PDOStatement();
		try{
			$this->beginTransaction();
			$ret = $this->prepare($qr);
			$ret->execute();
			if($insert)
				$id = $this->lastInsertId();
			$this->commit();
		}catch (PDOException $e){
			$this->rollBack();
			if($obj_name!=null && ErrorBD::getType($e)==ErrorBD::MISS_TABLE){
				$this->create();
				$this->execQuery($qr,null,$insert);
			}
			else 
				echo Error::toJson("ErroNumero ".$e->getCode()." : ".$e->getMessage());
		}
		if($insert)
			return $id;
		return $ret;	
	}
	
	/**
	 * Insere um registro em uma tabela, array de parametro deve conter a mesma sequencia que os campos
	 * Retorna o ultimo id inserido
	 * @param ArrayObj $valores
	 * @return int 
	 */
	public function insert(ArrayObj $valores){
		$qr = SQLQueries::INSERT;
		$qr = str_replace(SQLQueries::TOKEN_TABELA, $this->tabela, $qr);
		$qr = str_replace(SQLQueries::TOKEN_CAMPOS, $this->campos->toString(), $qr);
		$qr = str_replace(SQLQueries::TOKEN_INSERT_VALORES, $valores->toQueryDB(), $qr);
		return $this->execQuery($qr,true);
	}
	
	/**
	 * Caso não exista do registro então ele será inserido se não sofre update
	 * Utiliza o statement ON DUPLICATE KEY...do MySQL 5.0 >
	 * @param $valores : valores a serem inseridos
	 */
	public function insertDuplicatedKey(ArrayObj $valores){
		$qr = SQLQueries::INSERT_DUPLICATE;
		$qr = str_replace(SQLQueries::TOKEN_TABELA, $this->tabela, $qr);
		$qr = str_replace(SQLQueries::TOKEN_CAMPOS, $this->campos->toString(), $qr);
		$dpl='';
		$valores->encodeHtml();
		$valores->putQuotation();
		$valores->replace("","NULL");
		foreach ($this->campos as $k=>$c)
			$dpl .= " ".$c." = ".$valores->offsetGet($k)." ,";
		$dpl=substr($dpl, 0,-2);
		$qr = str_replace(SQLQueries::TOKEN_INSERT_VALORES, $valores->toString, $qr);
		$qr = str_replace(SQLQueries::TOKEN_INSERT_DUPLICATE, $dpl, $qr);
		return $this->execQuery($qr,true);
	}
	/**
	 * Atualiza todas as linhas da tabelas para as colunas passadas como key da $hash
	 * @param ArrayObj $hash
	 * @return ArrayObj
	 */
	public function updateColumns(ArrayObj $hash){
		$qr = SQLQueries::UPDATE;
		$qr = str_replace(SQLQueries::TOKEN_TABELA, $this->tabela, $qr);
		$qr = str_replace(SQLQueries::TOKEN_UPDATE_CAMPOS,$hash->toQueryDBUpdate(), $qr);
		return new ArrayObj($this->execQuery($qr,false)->fetchAll(PDO::FETCH_ASSOC));
	}
	/**
	 * Atualiza uma unica linha, dado por $id, da tabelas para as colunas passadas como key da $hash
	 * @param ArrayObj $hash
	 * @return ArrayObj
	 */
	public function updateRow($id,ArrayObj $hash){
		$qr = SQLQueries::UPDATE_WHERE;
		$qr = str_replace(SQLQueries::TOKEN_TABELA, $this->tabela, $qr);
		$qr = str_replace(SQLQueries::TOKEN_UPDATE_CAMPOS,$hash->toQueryDBUpdate(), $qr);
		$w = new SQLWhereClause($this->id,$id,SQLWhereClause::EQUAL);
		$qr = str_replace(SQLQueries::TOKEN_WHERE,$w->toString(), $qr);
		return new ArrayObj($this->execQuery($qr,false)->fetchAll(PDO::FETCH_ASSOC));
	}
	/**
	 * Faz uma Query Estilo Select com Join Where OrderBy e Limit
	 * @param SQLJoin $j
	 * @param SQLWhereClause $w
	 * @param SQLOrderedBy $ord
	 * @return ArrayObj
	 */
	public function select(SQLJoin $j=null, SQLWhereClause $w=null, SQLOrderedBy $ord = null, SQLLimit $l = null){
		if($ord==null)
			$ord=new SQLOrderedBy();
		if($w==null)
			$w=new SQLWhereClause();
		if($l==null)
			$l=new SQLLimit();
		if($j==null)
			$j=new SQLJoin();
		$qr = SQLQueries::SELECT_JOIN;
		$qr = str_replace(SQLQueries::TOKEN_CAMPOS, $this->campos->toString(), $qr);
		$qr = str_replace(SQLQueries::TOKEN_TABELA, $this->tabela, $qr);
		$qr = str_replace(SQLQueries::TOKEN_WHERE, $w->toString(), $qr);		
		$qr = str_replace(SQLQueries::TOKEN_JOIN, $j->toString(), $qr);
		$qr = str_replace(SQLQueries::TOKEN_ORDER, $ord->toString(), $qr);
		$qr = str_replace(SQLQueries::TOKEN_LIMIT, $l->toString(), $qr);
		return new ArrayObj($this->execQuery($qr,false)->fetchAll(PDO::FETCH_ASSOC));
	}
	/**
	 * Remove uma ou mais linhas de uma tabela
	 * @param SQLWhereClause $w
	 */
	public function remove(SQLWhereClause $w=null){
		if($w==null)
			$w=new SQLWhereClause();
		$qr = SQLQueries::DELETE;
		$qr = str_replace(SQLQueries::TOKEN_TABELA, $this->tabela, $qr);
		$qr = str_replace(SQLQueries::TOKEN_WHERE, $w->toString(), $qr);
		$this->execQuery($qr,false);
	}
}
?>