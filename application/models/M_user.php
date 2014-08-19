<?php 

class M_user extends CI_Model {
	
 	function __construct()
    {
        parent::__construct();
    }
	
	function into(){
		$reg_style = $this->input->post('reg_style', TRUE);
		$xh = $this->input->post('xh', TRUE);
		$name = $this->input->post('name', TRUE);
		$tel = $this->input->post('tel', TRUE);
		$pw = $this->input->post('pw', TRUE);
		$pw = md5($pw);
		$data = array(
			'xh' =>$xh,
			'name'=>$name,
			'tel'=>$tel,
			'pw'=>$pw,
			'reg_style'=>$reg_style
		);
		$query = $this->db->get_where('user',array('xh'=>$xh));
		$get_xh = $query->result_array();
		$count = count($get_xh);
		if($count == "0"){
			if($reg_style == "0"){
				$result = $this->db->insert('user',$data);
				$msg = "1"; //1代表执行成功\
			}else{
				$power = "1";
				$data = array(
					'xh' =>$xh,
					'name'=>$name,
					'tel'=>$tel,
					'pw'=>$pw,
					'reg_style'=>$reg_style,
					'power' =>$power,
				);
				$result = $this->db->insert('user',$data);
				$msg = "1"; //1代表执行成功\
			}
		}else{
			$msg = "0"; //0代表有重复的
		}
		return $msg;
	}
	
	function login_check(){
		$xh = $this->input->post('xh', TRUE);
		$pw = $this->input->post('pw', TRUE);
		$pw = md5($pw);
		$data = array('xh'=>$xh,'pw'=>$pw);
		$query = $this->db->get_where('user',array('xh'=>$xh));
		$get_xh = $query->result_array();
		$count = count($get_xh);
		if($count == "0"){
			$msg = "0";	//0代表数据库中没有此账号
		}else{
			$query = $this->db->get_where('user',array('xh'=>$xh,'pw'=>$pw));
			$get_pw = $query->result_array();
			$count = count($get_pw);
			if($count == "0"){
				$msg = "2"; //2代表用户名正确，密码错误	
			}else{
				$msg = "1";	//1代表用户名正确，密码正确，登陆成功	
			}
		}
		return $msg;
	}
	
	function login_out(){
		$this->session->unset_userdata('xh');
	}

	//通过gid获取社团的所有信息
	function get_group($gid){
		$query = $this->db->get_where('group',array('gid' => $gid));
		return $query->result_array();
	}
	//获取社团简介信息
	function get_message($id){
		$query = $this->db->get_where('message',array('id'=>$id));
		return $query->result_array();
	}
	
	//获取社团的所有信息
	function get_group_bak($data){
		$query = $this->db->get_where('group',$data);
		return $query->result_array();
	}
	
	//模糊搜索，获取社团名称
	function get_group_search($data){
		$query = $this->db->query("SELECT `group_id`, `group_name` FROM `group` WHERE `group_name` like '%{$data}%'");
		return $query->result_array();
	}
	
	//通过group_id获取社团的所有信息
	function get_group_join($group_id){
		$query = $this->db->get_where('group',array('group_id' => $group_id));
		return $query->result_array();
	}
	
	//通过gidd获取社团所属的分类
	function get_group_style($gid){
		$query = $this->db->get_where('group_style',array('gid' => $gid));
		return $query->result_array();
	}
	
	//获取用户详细信息
	function get_user($xh){
		$query = $this->db->get_where('user',array('xh' => $xh));
		return $query->result_array();
	}
	
	//修改用户信息
	function user_update($xh,$data){
		$this->db->where('xh', $xh);
		$result = $this->db->update('user', $data);
		return $result;
	}
	
	//用户提交申请
	function post_apply($data){
		$this->db->insert('post',$data);
	}
	
	//获取申请表
	function get_post($data){
		$query = $this->db->get_where('post',$data);
		return $query->result_array();
	}
	
	//建立社团
	function set_group($data){
		$this->db->insert('group',$data);
	}
	//修改社团信息
	function group_update($xh,$data){
		$this->db->where('xh', $xh);
		$this->db->update('group', $data);
	}
	function group_update1($xh,$data){
		$this->db->where('xh',$xh);
		$this->db->update('user',$data);
	}
	
	//用于分页类
    function pages($num,$offset,$data) {
		$this->db->where($data);
        $query = $this->db->get('post',$num,$offset);
        return $query->result_array();
    }
	
	//更新申请表单信息
	function post_update($data1,$data2){
		$this->db->set($data2);
		$this->db->where($data1);
		$this->db->update('post');
	}

	function post_update1($data1,$data2){
		$this->db->set($data2);
		$this->db->where($data1);
		$this->db->update('user');
	}	
	
	//批量更新数据
	function update_all($data1,$data2){
		$this->db->query('UPDATE `post` SET tag_delete='.$data1.' WHERE `pid` IN ('.$data2.')');
	}
	
}
?>
