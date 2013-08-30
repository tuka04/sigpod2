<?php
/**
 * Base64
 * @version 0.1 (01/9/2013)
 * @package kernel
 * @author Leandro Kümmel Tria Mendes
 * @desc classe que faz encode e decode de uma str em/para base64
 * @see Classes Spl
 */
class Base64 {
	/**
	 * Faz o encode de uma string para base64
	 * @param string $str
	 * @return string
	 */
	public static function encode($str){
		return base64_encode($str);
	}
	/**
	 * Faz o decode de uma string em base64
	 * @param string $str
	 * @return string
	 */
	public static function decode($str){
		return base64_decode($str);
	}
}
?>