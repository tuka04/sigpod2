<?php
/**
 * Data Access Object
 * @version 0.1 (01/9/2013)
 * @package kernel
 * @author Leandro Kümmel Tria Mendes
 * @desc classe que manipula um arquivo
 * @see Classes Spl
 */
class File extends SplFileObject {
	public function __construct($file_name, $open_mode){
		parent::__construct($file_name, $open_mode);
	}
	/**
	 * Retorna todo o conteudo de um arquivo em uma string
	 * @return string
	 */
	public function getAllContent(){
		$str = "";
		while(!$this->eof()){
			$str.=$this->fgets();
		}
		return $str;
	}
}
?>