<?php
/**
 * FileInfo
 * @version 2.0 (01/9/2013)
 * @package kernel
 * @author Leandro Kümmel Tria Mendes
 * @desc see SplFileInfo
 */
class FileInfo extends SplFileInfo {
	
	/**
	 *@param file_name 
	 */
	public function __construct($file_name) {
		parent::__construct ( $file_name );	
	}
	
	/**
	 * 
	 */
	function __destruct() {
	
	}
}

?>