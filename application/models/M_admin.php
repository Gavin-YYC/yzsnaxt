<?php 

class M_admin extends CI_Model {
	
 	function __construct()
    {
        parent::__construct();
    }
	
	//获取管理员信息
	function select_user($table,$data){
		$query = $this->db->get_where($table,$data);
		$get_xh = $query->result_array();
		return $get_xh;
	}
	
	//注销
	function login_out(){
		$this->session->unset_userdata('admin_xh');
	}

	//通用写法，获取一切信息
	function get_user($table){
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
	//限定写法，获取指定信息
	function get_user_limit($table,$data){
		$this->db->where($data);
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
	//批量审核
	function groupcheck($data,$uid,$checkTime){
		$this->db->query('UPDATE `user` SET power='.$data.',check_time="'.$checkTime.'" WHERE `uid` IN ('.$uid.')');
	}
	
	//批量删除
	function groupdelete($table,$col,$uid){
		$this->db->query('DELETE FROM `'.$table.'` WHERE `'.$col.'` IN ('.$uid.')');
	}
	
	//通过分页类,限定条件
    function pages($num,$offset,$data,$table) {
		$this->db->where($data);
        $query = $this->db->get($table,$num,$offset);
        return $query->result_array();
    }
	
	//分页类,不限定条件
    function pages_limit($num,$offset,$table) {
        $query = $this->db->get($table,$num,$offset);
        return $query->result_array();
    }

	//模糊搜索，获取社团名称
	function get_search($data){
		$query = $this->db->query("SELECT `uid`,`name`, `xh`,`reg_style`,`group_name` FROM `user` WHERE `name` like '%{$data}%' or `xh` like '%{$data}%' or group_name like '%{$data}%'");
		return $query->result_array();
	}
	
	//更新信息
	function update_all($table,$col,$data){
		$this->db->where($col);
		$result = $this->db->update($table, $data);
		return $result;
	}
	
	//添加信息
	function addInfo($table,$data){
		$result = $this->db->insert($table,$data); 
		return $result;
	}
	//获取社团简介信息
	function get_message($id){
		$query = $this->db->get_where('message',array('id'=>$id));
		return $query->result_array();
	}

}
?>
