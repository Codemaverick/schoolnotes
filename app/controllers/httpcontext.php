<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Index Page for this controller.
	 *
	 */
	 
class HttpContext{

	private $_CI;
	private $loader;
	
	public function __construct(){
		$this->CI = & get_instance();
	}
	
	public function CI(){
		return $this->_CI;
	}

}


?>