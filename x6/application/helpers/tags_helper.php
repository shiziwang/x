<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//前台模板所有数据都是通过此文件调用

function x6cms_path($path){
	if(substr($path,0,4)=='http'){
		return $path;
	}else{
		return base_url($path);
	}
}

function x6cms_url($url){
	if(substr($url,0,4)=='http'){
		return $url;
	}else{
		return site_url($url);
	}
}

//前台模板所有数据都是通过此文件调用

	
/**
* 获取语言表 lan
* 
* @access public
* @return Array
*/	
function x6cms_lang(){
	$CI =& get_instance();
	$data=$CI->Cache_model->loadLang();
	return $data;
}

/**
* 
* 
* @access public
* @param  $category
* @param  $code
* @return Array
*/	
function x6cms_location($category,$code=''){
	$CI =& get_instance();
	$data=$CI->Cache_model->loadLocation($category,$code);
	return $data;
}

/**
* 获取搜索框
* 
* @access public
* @param  string $model 缺省为article
* @param  bloon $ismult 
* @return Array
*/	
function x6cms_search($model='article',$ismult=true){
	$CI =& get_instance();
	$data=$CI->Cache_model->loadSearch($model,$ismult);
	return $data;
}

/**
* 获取网站地图和RSS订阅 
* 
* @access public
* @param  int $type 参数为：4 时返回 网站地图和RSS订阅 
* @return Array
*/	
function x6cms_navigation($type){
	$CI =& get_instance();
	$data=$CI->Cache_model->loadNavigation($type);
	return $data;
}

/**
* 导航栏目 所有category
* 
* @access public
* @param  int $num 可以缺省
* @return array 
*/	
function x6cms_category($num=0){
	$CI =& get_instance();
	$data=$CI->Cache_model->loadCategory($num);
	return $data;
}

/**
* 前台幻灯片
* 
* @access public
* @param  int $aid $aid=2
* @return array
*/	
function x6cms_slide($type){
	$CI =& get_instance();
	$data=$CI->Cache_model->loadSlide($type);
	return $data;
}
/**
* 
* 获取model列表
* @access public
* @param  string $model model为article hr download 等
* @param int $category 栏目 比如article表中的$category 为数字
* @param string $order 排序缺省为default
* @param int $num 取几篇
* @param int $recommend
* @return Array
*/
function x6cms_modellist($model,$category,$order,$num,$recommend){
	$CI =& get_instance();
	$data=$CI->Cache_model->loadModel($model,$category,$order,$num,$recommend);
	return $data;
}
/**
* 推荐位设置
* 
* @access public
* @param  
* @return Array
*/	
function x6cms_recommend($recommendid,$order,$num){
	$CI =& get_instance();
	$data=$CI->Cache_model->loadRecommend($recommendid,$order,$num);
	return $data;
}
/**
* 获取fragment表 
* 碎片管理 后台可以添加变量名
* 
* @access public
* @param  int $aid 文章id
* @return Null
*/	
function x6cms_fragment($varname){
	$CI =& get_instance();
	$data=$CI->Cache_model->loadFragment($varname);
	return $data;
}
/**
* tags
* 
* @access public
* @param  
* @return Array
*/	
function x6cms_tags($num=0){
	$CI =& get_instance();
	$data=$CI->Cache_model->loadTags($num);
	return $data;
}
/**
* tagsData
* 
* @access public
* @param  string $model 
* @return Null
*/	
function x6cms_tagsData($model,$tags,$num){
	$CI =& get_instance();
	$data=$CI->Cache_model->loadTagsData($model,$tags,$num);
	return $data;
}
/**
* 友情链接
* 
* @access public
* @param  int $aid 文章id
* @return Null
*/	
function x6cms_link($type=0){
	$CI =& get_instance();
	$data=$CI->Cache_model->loadLink($type);
	return $data;
}
/**
* 在线聊天联系（QQ 旺旺 邮箱）
* 
* @access public
* @param  int $aid 文章id
* @return Null
*/	
function x6cms_online(){
	$CI =& get_instance();
	$data=$CI->Cache_model->loadOnline();
	return $data;
}
/**
* 
* 
* @access public
* @param  $category
* @return array
*/	
function x6cms_thiscategory($category){
	$CI =& get_instance();
	$data=$CI->Cache_model->loadThisCategory($category);
	return $data;
}
/**
* 
* 所有栏目
* @access public
* @return Array
*/	
function x6cms_allcategory(){
	$CI =& get_instance();
	$data=$CI->Cache_model->loadAllCategory();
	return $data;
}
/**
* 
* 
* @access public
* @param  int $detail 文章id
* @return Null
*/	
function x6cms_related($detail,$num=5){
	$CI =& get_instance();
	$data=$CI->Cache_model->loadRelated($detail,$num);
	return $data;
}