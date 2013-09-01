<?php
/**
 * Error
 * @version 0.1 (01/9/2013)
 * @package kernel
 * @author Leandro Kümmel Tria Mendes
 * @desc classe que faz o output de algum erro especifico
 */

class Error {
	public static function toJson($e){
		$a = new ArrayObj();
		$a->offsetSet("error", true);
		$a->offsetSet("msg", $e);
		return $a->toJson();
	}
}

class ErrorBD {
	const MISS_TABLE = 'miss_table';
	public static function getType(PDOException $e){
		switch ($e->getCode()){
			case '42S02':
				return self::MISS_TABLE; 
		}
	}
}
?>