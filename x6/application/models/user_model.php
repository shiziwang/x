<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model{
	var $CI;
	function __construct($table=''){
  		parent::__construct();
  		$this->CI =& get_instance();
	}
	/*
	 * 登陆验证
	 *  
	 * @return boolon
	 * */
	function login($username,$userpass){
		$this->CI->Data_model->setTable('user');
		$user = $this->CI->Data_model->getSingle(array('username'=>$username));
		if(isset($user['status'])&&$user['status']==1&&$user['password']==md5pass($userpass,$user['salt'])){
			$this->CI->Data_model->editData(array('id'=>$user['id']),array('logincount'=>$user['logincount']+1,'lasttime'=>time()));
			$this->setLogin($user);//设置用户session
			return true;
		}else{
			return false;
		}
	}
	
	/*
	 * 设置session用户信息
	 *  @param array $user 用户信息
	 * */	
	function setLogin($user){
		$this->CI->Data_model->setTable('usergroup');
		$usergroup = $this->CI->Data_model->getSingle(array('id'=>$user['usergroup']));
		$newdata = array(
				'uid' => $user['id'],
				'usergroup' => $user['usergroup'],
				'varname' => $usergroup['varname'],
				'username' => $user['username'],
		);
		$this->CI->session->set_userdata($newdata);
	}
	
	function logout(){
		$userdata = array(
				'uid' => '',
				'usergroup' => '',
				'username' => '',
		);
		$this->CI->session->unset_userdata($userdata);
	}
	
	
}