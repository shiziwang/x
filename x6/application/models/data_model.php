<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Data_model extends CI_Model
{
	var $table;
	function __construct(){
  		parent::__construct();
	}
	
	function setTable($table){
		$this->table = $table;
	}
	
	function setWhere($getwhere){
		if(is_array($getwhere)){
			foreach($getwhere as $key=>$where){
				if($key=='findinset'){
					$this->db->where("1","1 AND FIND_IN_SET($where)",FALSE);
					continue;
				}
				if(is_array($where)){
					$this->db->where_in($key, $where);
				}else{
					$this->db->where($key,$where);
				}
			}
		}else{
			$this->db->where($getwhere);
		}
	}

	function addData($data,$table=''){
		$table = $table==''?$this->table:$table;
		if($data){
			$this->db->insert($table,$data);
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	function editData($datawhere,$data,$table=''){
		$table = $table==''?$this->table:$table;
		if(!empty($datawhere))
		{
			$this->db->where($datawhere);
		}
		$this->db->update($table,$data);
	}
	
	function delData($ids,$table=''){
		$table = $table==''?$this->table:$table;
		if(is_array($ids)){
			$this->db->where_in('id',$ids);
		}else{
			$this->db->where('id',$ids);
		}
		$this->db->delete($table);
	}

	function getData($getwhere="",$order='',$pagenum="0",$exnum="0",$table=''){
		$table = $table==''?$this->table:$table;
		if($getwhere){
			$this->setWhere($getwhere);
		}
		if($order){
			$this->db->order_by($order);
		}
		if($pagenum>0){
			$this->db->limit($pagenum,$exnum);
		}
		$data = $this->db->get($table)->result_array();
		return $data;
	}
	
	/**
     *  单表数据查询
     * 
     * @access public
     * @param1 array $getwhere 查询条件：array('status'=>1,'url'=>"aa") 
     * @param2 string $table表名
     * @return array
     */	
	function getSingle($getwhere="",$table=''){
		$table = $table==''?$this->table:$table;
		if($getwhere){
			$this->setWhere($getwhere);
		}
		$row = $this->db->get($table)->row_array();
		return $row;
	}

	function getDataNum($getwhere='',$table=''){
		$table = $table==''?$this->table:$table;
		if($getwhere){
			$this->setWhere($getwhere);
		}
		return $this->db->count_all_results($table);
	}
	/*
	 * 更新点击率
	 * 
	 * @param $id 文章id
	 * @param $table 表名
	 * @return NULL
	 * */
	function setHits($id,$table=''){
		$table = $table==''?$this->table:$table;
		$this->db->where('id',$id);
		$this->db->set('hits', 'hits+1',FALSE);
		$this->db->set('realhits', 'realhits+1',FALSE);
		$this->db->update($table);
	}
	
	function listOrder($ids,$res,$order='',$table=''){
		$table = $table==''?$this->table:$table;
		$num = count($ids);
		$data = array();
		for($i=0;$i<$num;$i++){
			$data[] = array('id'=>$ids[$i],'listorder'=>$res[$i]);
		}
		$this->db->update_batch($table,$data,'id');
		
		if($num>0){
			$this->db->where_in('id',$ids);
			if($order){
				$this->db->order_by($order);
			}
			$data = $this->db->get($table)->result_array();
			return $data;
		}
		
		return array();
	}
}