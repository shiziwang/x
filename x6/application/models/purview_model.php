<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purview_model extends CI_Model
{
	function __construct(){
  		parent::__construct();
	}
	
	function checkPurview($class,$method='index'){
		$status=$this->isPurview($class,$method);
		switch($status){
			case '200':
				return true;
				break;
			case '201':
				$actionurl[] = array('name'=>lang('user_login'),'url'=>site_aurl('login/lose/'));
				show_message(lang('login_lose'),$actionurl);
				break;
			case '202':
				show_message(lang('nopurview'));
				break;
			default:
				show_message(lang('nopurview'));
				break;
		}
	}
	
	function checkPurviewAjax($class,$method='index'){
		$status=$this->isPurview($class,$method);
		switch($status){
			case '200':
				return true;
				break;
			case '201':
				show_jsonmsg(array('status'=>201,'remsg'=>lang('login_lose')));
				break;
			case '202':
				show_jsonmsg(array('status'=>202,'remsg'=>lang('nopurview')));
				break;
			default:
				show_jsonmsg(array('status'=>202,'remsg'=>lang('nopurview')));
				break;
		}
	}
	/**
     * 检查方法权限
     * 
     * @access public
     * @param  string $class 表名 eg: article
     * @param sting $method 方法 eg: add del
     * @return Boolon
     */	
	function checkPurviewFunc($class,$method='index'){
		if($this->isPurview($class,$method)==200){
			return true;
		}else{
			return false;
		}
	}
	/**
     * 检查权限
     * 
     * @access public
     * @param  string $class 表名 eg: article
     * @param sting $method 方法 eg: add del
     * @return Number
     */	
	function isPurview($class,$method){
		$CI =& get_instance();
		$CI->load->library('session');
		$usergroupid=$CI->session->userdata('usergroup');
		if($usergroupid==1){
			return 200;
		}
		if(!$usergroupid){
			return 201;
		}
		$purview = $this->getPurview($usergroupid);
		if(!isset($purview[1][$class])){
			return 202;
		}
		if($method=='index'){
			return 200;
		}
		if(in_array($method,$purview[1][$class]['method'])){
			return 200;
		}
		return 202;
	}
	/**
     * 获取某个用户的权限
     * 
     * @access public
     * @param  int $usergroupid 用户组id
     * @return serialize
     */		
	function getPurview($usergroupid){
		$CI =& get_instance();
		$CI->load->model('Data_model');
		$row = $CI->Data_model->getSingle(array('id'=>$usergroupid),'usergroup');
		$purview = unserialize($row['purview']);//serialize序列化后
		if($row['isupdate']==1){
			if($purview[0]){
				$arr = $CI->Data_model->getData(array('status'=>1,'id'=>$purview[0]),'listorder',0,0,'purview');
				$newpurviewid = array();
				$newpurviewarr = array();
				foreach($arr as $key=>$item){
					$newpurviewid[] = $item['id'];
					$newpurviewarr[$item['class']]['id'] = $item['id'];
					$newpurviewarr[$item['class']]['class'] = $item['class'];
					$newpurviewarr[$item['class']]['method'] = $purview[1][$item['class']]['method'];
					$grouppurview[$item['parent']][] = $item;
					if($item['parent']==0){
						$parentpurview[$item['id']] = $item;
					}
				}
				$purview = array(0=>$newpurviewid,1=>$newpurviewarr,2=>$grouppurview,3=>$parentpurview);
				$data = array('purview'=>serialize($purview),'isupdate'=>0);
				$CI->Data_model->editData(array('id'=>$usergroupid),$data,'usergroup');
				return $purview;
			}else{
				return $purview;
			}
		}else{
			return $purview;
		}
	}
	
	function resetPurview(){
		$CI =& get_instance();
		$CI->load->model('Data_model');
		$upgroupdata = array('isupdate'=>1);
		$CI->Data_model->editData('',$upgroupdata,'usergroup');
	}

	/**
     * 最下面的添加 排序 删除
     * 
     * @access public
     * @param  string $tablefunc 表明 eg:article
     * @param array $funcarr 
     * @return Null
     */	
	function getFunc($tablefunc,$funcarr=array()){
		$resstr = '';
		foreach($funcarr as $func){
			if($this->checkPurviewFunc($tablefunc,$func)){
				$resstr .= '<input type="button" class="btn" onclick="submitTo(\''.site_aurl($tablefunc.'/'.$func).'\',\''.$func.'\')" value="'.lang('btn_'.$func).'">';
			}
		}
		return $resstr;
	}
	
	function getSingleFunc($url,$func,$extra=false){
		$extra = $extra?',\''.$extra.'\'':'';
		$resstr='<a href="javascript:submitTo(\''.$url.'\',\''.$func.'\''.$extra.')" title=\''.lang('btn_'.$func).'\' class=\''.$func.'\'></a>';
		return $resstr;
	}
	
	function getOtherFunc($funcstr,$func){
		$resstr = '<input type="button" class="btn" onclick="'.$funcstr.'" value="'.lang('btn_'.$func).'">';
		return $resstr;
	}
}