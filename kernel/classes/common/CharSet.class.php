<?php
/**
 * Charset
 * @version 2.0 (01/9/2013)
 * @package kernel
 * @author Leandro Kümmel Tria Mendes
 * @desc classe q manipula acoes em bd
 * @see Acesso e querys aos bancos de dados
 */
class CharSet {
	
	const Type = "UTF-8";
	
	const Quotes = ENT_QUOTES;
	
	function __construct() {
	
	}
	/**
	 *
	 * @param mixed|string,int $str
	 * @return string
	 */
	public static function encodeHtml($str){
		return htmlentities($str,self::Quotes, self::Type);
	}
}

?>