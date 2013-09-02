<?php
/**
* Server
* @version 0.1 (01/9/2013)
* @package kernel
* @author Leandro Kümmel Tria Mendes
* @desc Classes com descricao do sistema
*/
class Server {
	/**
	 * @var string
	 */	
	private $name;
	/**
	 * @var string
	 */	
	private $host;
	/**
	 * @var string
	 */	
	private $app;
	/**
	 * @var string
	 */	
	private $titulo;
	/**
	 * 
	 */
	function __construct() {
		$this->setApp(SERVER_APP);
		$this->setHost(SERVER_HOST);
		$this->setName(SERVER_NAME);
		$this->setTitulo(SERVER_TITULO);	
	}
	
	/**
	 * @return string
	 */
	public function getApp() {
		return $this->app;
	}
	
	/**
	 * @return string
	 */
	public function getHost() {
		return $this->host;
	}
	
	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * @return string
	 */
	public function getTitulo() {
		return $this->titulo;
	}
	
	/**
	 * @param string $app
	 */
	public function setApp($app) {
		$this->app = $app;
	}
	
	/**
	 * @param string $host
	 */
	public function setHost($host) {
		$this->host = $host;
	}
	
	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * @param string $titulo
	 */
	public function setTitulo($titulo) {
		$this->titulo = $titulo;
	}

}
?>