<?php
class MY_Loader extends CI_Loader {
	function __construct()
	{
		parent::__construct();
	}
	/*
	 * 加载模板必须使用此函数 把\换为/
	 * */
	function setPath(){
		$path = str_replace("\\", "/", FCPATH);
		$this->_ci_view_paths = array($path.'data/template/' => TRUE);
	}
}
