<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	 function __construct()
	 {
		parent::__construct();
		$this->load->database();	//载入数据库类
		$this->load->helper('url');	//载入url类
		$this->load->library('session');	//载入session类
		$this->load->library('pagination');	//载入分页类
		date_default_timezone_set('Asia/Shanghai');	//载入时区
		$this->load->model('M_user');	//载入模型
		$this->output->set_header("Content-Type: text/html; charset=utf-8");
	}

	//首页
	public function index()
	{
		$this->load->view('welcome_message');
	}

	//登陆及验证
	public function login(){
		echo '<meta charset="utf-8">';
		$xh = $this->input->post('xh', TRUE);
		$result = $this->M_user->login_check();
		if($result == "0"){
			echo '<script> alert("该学号还没有注册！");</script>';
			redirect('/','refresh');
		}else if($result == "2"){
			echo '<script> alert("密码错误！");</script>';
			redirect('/','refresh');
		}else if($result =="1"){
			$this->session->set_userdata('xh',$xh);
			$result = $this->M_user->get_user($xh);
			if($result[0]['power'] == "1"){
				$this->load->view('please-wait');
			}else{
				redirect('user/group_list');
			}
		}
	}	
	
	public function login_out(){
		$xh = $_GET['xh'];
		$login=$this->M_user->login_out();
		redirect('/');
	}
	

	//进入社团列表
	public function group_list()
	{
		$data['xh'] = $this->session->userdata('xh');
		$data['title'] = "社团列表";
		$data['group1'] = $this->M_user->get_group(1);
		$data['group2'] = $this->M_user->get_group(2);
		$data['group3'] = $this->M_user->get_group(3);
		$data['group4'] = $this->M_user->get_group(4);
		$data['groupStyleBrief'] = $this->M_user->get_message(1);
		$this->load->view('common-header',$data);
		$this->load->view('group-list');
	}
	
	//进入个人、社团中心
	public function info()
	{	
		echo '<meta charset="utf-8">';
		$data['xh'] = $this->session->userdata('xh');
		if($data['xh'] == NULL){
			echo '<script>alert("系统检测到你还没有登录！");</script>';
			echo '<script>location.href="'.base_url().'"</script>';
		}
		$data['user_detail'] = $this->M_user->get_user($data['xh']);
		$data['reg_style'] = $data['user_detail'][0]['reg_style'];
		$data1 = array('xh' => $data['xh']);
		if($data['reg_style'] == "0"){
			$data['user_post'] = $this->M_user->get_post($data1);
			$data['title'] = "个人中心";
			$this->load->view('common-header',$data);
			$this->load->view('common-left');
			$this->load->view('my');
			$this->load->view('my-footer');
			
		}else{
			$data['group_post'] = $this->M_user->get_group_bak($data1);
			if($data['group_post'] == NULL){ 
				$data['msg'] = "0";
			}else{
				$data['msg'] = "1";
				$data['group_name'] = $data['group_post'][0]['group_name'];
				$data1 = array('group_name' => $data['group_name']);
				$data['user_post'] = $this->M_user->get_post($data1);
			}
			$data['title'] = "社团信息";
			$this->load->view('common-header',$data);
			$this->load->view('common-left');
			$this->load->view('my-group');
			$this->load->view('group-letter-footer');
		}
	}
	//我的信箱
	public function myletters(){
		
		//分页信息
		$config['base_url'] = site_url('user/myletters');
		$config['per_page'] = 20;		//每页显示多少条信息
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = "首页";
		$config['last_link'] = "末页";
		$config['next_link'] = '下一页';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '上一页';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$segment = $this->uri->segment(3);//分割url段
		
		
		$data['xh'] = $this->session->userdata('xh');
		$data['user_detail'] = $this->M_user->get_user($data['xh']);
		$data['reg_style'] = $data['user_detail'][0]['reg_style'];
		$data1 = array('xh' => $data['xh']);
		$data['title'] = "我的信箱";
		if($data['reg_style'] == "0"){
			$data['user_post'] = $this->M_user->get_post($data1);
			$count = count($data['user_post']);
			
			$config['total_rows'] = $count;	//总共有多少条信息
			$data['total_rows'] = $count;
			$this->pagination->initialize($config);//初始化分页
			$data['result'] = $this->M_user->pages($config['per_page'],$segment,$data1);
			$data['links'] = $this->pagination->create_links(); //输入分页链接
			
			$this->load->view('common-header',$data);
			$this->load->view('common-left');
			$this->load->view('my-letter');
			$this->load->view('my-footer');
		}else{
			$data['group_post'] = $this->M_user->get_group_bak($data1);
			$data['group_name'] = $data['group_post'][0]['group_name'];
			$data1 = array('group_name' => $data['group_name'],'tag_delete'=>0);
			$data['user_post'] = $this->M_user->get_post($data1);
			$count = count($data['user_post']);//统计总共有多少条相关信息

			$config['total_rows'] = $count;	//总共有多少条信息
			$data['total_rows'] = $count;
			$this->pagination->initialize($config);//初始化分页
			$data['result'] = $this->M_user->pages($config['per_page'],$segment,$data1);
			$data['links'] = $this->pagination->create_links(); //输入分页链接
			
			$this->load->view('common-header',$data);
			$this->load->view('common-left');
			$this->load->view('group-letter');
			$this->load->view('group-letter-footer');
		}
	}
	
	//用户更新数据
	public function update()
	{
		$xh = $this->session->userdata('xh');
		if($xh == NULL){
			echo '<script>alert("系统检测到你还没有登录！");</script>';
			echo '<script>location.href="'.base_url().'"</script>';
		}
		$sex = $_POST['sex'];
		$faculty = $_POST['faculty'];
		$major = $_POST['major'];
		$home1 = $_POST['home1'];
		$birth = $_POST['birth'];
		$join_asso = $_POST['join_asso'];
		$about_me = $_POST['about_me'];
		$others = $_POST['others'];
		$update_time=date('Y-m-d H:i:s');
		$data = array(
					  'sex' => $sex ,
					  'faculty' => $faculty ,
					  'major' => $major ,
					  'home' => $home1 ,
					  'birth' => $birth ,
					  'join_asso' => $join_asso ,
					  'about_me' => $about_me ,
					  'others' => $others ,
					  'update_time' => $update_time ,
		);
		$query = $this->M_user->user_update($xh,$data);
		if($query){
			$result = 1;	//插入成功
		}else{
			$result = 0;	//没有更新成功
		}
		echo json_encode($result);
	}
	
	//用户提交申请
	public function user_apply()
	{
		$xh = $this->session->userdata('xh');
		if($xh == NULL){
			echo '<script>alert("系统检测到你还没有登录！");</script>';
			echo '<script>location.href="'.base_url().'"</script>';
		}
		$data['user_detail'] = $this->M_user->get_user($xh);
		$name = $data['user_detail'][0]['name'];
		$tel = $data['user_detail'][0]['tel'];
		$user_logo = $data['user_detail'][0]['user_logo'];
		$apply_group = $_POST['group_id'];
		$group_name = $_POST['group_name'];
		$sex = $_POST['sex'];
		$faculty = $_POST['faculty'];
		$major = $_POST['major'];
		$home1 = $_POST['home1'];
		$birth = $_POST['birth'];
		$join_asso = $_POST['join_asso'];
		$about_me = $_POST['about_me'];
		$others = $_POST['others'];
		$data = array(
			'xh' => $xh,
			'name' => $name,
			'tel' => $tel,
			'sex' => $sex ,
			'faculty' => $faculty ,
			'major' => $major ,
			'home' => $home1 ,
			'birth' => $birth ,
			'join_asso' => $join_asso ,
			'about_me' => $about_me ,
			'others' => $others ,
			'apply_group' => $apply_group,
			'group_name' => $group_name,
			'user_logo'=>$user_logo,
		);
		$data1 = array(
			'xh' => $xh,
			'apply_group' => $apply_group
		);
		$result = $this->M_user->get_post($data1);//判断有没有重复申请
		if($result == NULL){
			$this->M_user->post_apply($data);//插入申请表
			if(mysql_affected_rows()==0){
				$msg = 2;	//没有插入成功
			}else{
				$msg = 1;	//申请成功
			}
		}else{
			$msg = 0;//你已经申请过该社团
		}
		echo json_encode($msg);
	}
	
	
	
	//进入报名中心
	public function join()
	{
		echo '<meta charset="utf-8">';
		$data['group_id'] = $_GET['group_id'];
		if($data['group_id'] == NULL)
		{
			echo '<script> alert("非法进入！");</script>';
			redirect('/','refresh');
		}
		$data['xh'] = $this->session->userdata('xh');
		$data['title'] = "报名中心";
		$data['group_detail'] = $this->M_user->get_group_join($data['group_id']);
		$data['group_style'] = $this->M_user->get_group_style($data['group_detail'][0]['gid']);
		$data['user_detail'] = $this->M_user->get_user($data['xh']);
		$this->load->view('common-header',$data);
		$this->load->view('join');
	}
	
	//注册
	public function register(){
		echo '<meta charset="utf-8">';
		if(!isset($_POST['xh'])){
			echo '<script>alert("系统检测到你还没有输入任何内容！");</script>';
			echo '<script>location.href="'.base_url().'"</script>';	
		}
		$result = $this->M_user->into();
		if ($result) {
			echo '<script> alert("注册成功，返回登陆！");</script>';
			redirect('/','refresh');
		}else{
			echo '<script> alert("该学号已经注册过了！返回重新注册！");</script>';
			redirect('/','refresh');
		}
	}
	
	//建立社团
	public function set_group(){
		$data['xh'] = $this->session->userdata('xh');
		if($data['xh'] == NULL){
			echo '<script>alert("系统检测到你还没有登录！");</script>';
			echo '<script>location.href="'.base_url().'"</script>';
		}
		$data = array('xh' => $data['xh']);
		$this->M_user->set_group($data);
		if(mysql_affected_rows()==0){
			$msg = 0;	//没有插入成功
		}else{
			$msg = 1;	//申请成功
		}
		echo json_encode($msg);
	}
	
	//社团信息更新
	public function group_update(){
		$xh = $this->session->userdata('xh');
		if($xh == NULL){
			echo '<script>alert("系统检测到你还没有登录！");</script>';
			echo '<script>location.href="'.base_url().'"</script>';
		}
		$group_name = $_POST['group_name'];
		$group_fromdata = $_POST['group_fromdata'];
		$group_belong = $_POST['group_belong'];
		$gid = $_POST['gid'];
		$group_brief = $_POST['group_brief'];
		$group_detail = $_POST['group_detail'];
		$group_wide = $_POST['group_wide'];
		$group_way = $_POST['group_way'];
		$group_others = $_POST['group_others'];
		$data = array(
			'xh' => $xh,
			'group_name' => $group_name,
			'group-fromdata' => $group_fromdata,
			'group-belong' => $group_belong ,
			'gid' => $gid ,
			'group-brief' => $group_brief ,
			'group-detail' => $group_detail ,
			'group_wide' => $group_wide ,
			'group_way' => $group_way ,
			'group_others' => $group_others ,
		);
		$data1 = array('group_name'=>$group_name);
		$this->M_user->group_update($xh,$data);
		$this->M_user->group_update1($xh,$data1);
		if(mysql_affected_rows()==0){
			$result = 0;	//没有插入成功
		}else{
			$result = 1;	//更新成功
		}
		echo json_encode($result);
	}
	
	//文件上传
	public function upload(){
		echo '<meta charset="utf-8">';
		$xh = $this->session->userdata('xh');
		$userfile_size = $_FILES['image']['size'];
		$userfile_type = $_FILES['image']['type'];
		if($userfile_size>300000){
			echo '<script> alert("图片太大，请修改后提交！");</script>';
			echo '<script>location.href="'.base_url().'user/info"</script>';
		}
		if($userfile_type == "image/png" || $userfile_type == "image/jpeg" || $userfile_type == "image/gif" || $userfile_type == "image/pjpeg"){
			
		}else{
			echo '<script> alert("图片格式不正确！");</script>';
			echo '<script>location.href="'.base_url().'user/info"</script>';	
		}
		$config['upload_path'] = './source/uploads/';
  		$config['allowed_types'] = 'gif|jpg|png|jpeg';
  		$config['max_size'] = '300';
  		//$config['max_width']  = '300';
  		//$config['max_height']  = '300';
		$datenow =date('YmdHis');
		$pickey = $xh.$datenow;
		$config['file_name'] = "img".$pickey;
		$this->load->library('upload', $config);
		$this->upload->do_upload('image');
		$data = $this->upload->data();
		$data1 = array(
			'user_logo' => $data['file_name'],
		);
		$data2 = array(
			'group_logo' => $data['file_name'],
		);
		
		//更新用户表
		$this->M_user->user_update($xh,$data1);
		
		//更新表单表
		$data3 = array('xh'=>$xh);
		$this->M_user->post_update($data3,$data1);
		$this->M_user->post_update1($data3,$data1);
		//判断是不是社团用户更新社团表
		$data['user_detail'] = $this->M_user->get_user($xh);
		$data['reg_style'] = $data['user_detail'][0]['reg_style'];
		if($data['reg_style'] == "1"){
			$this->M_user->group_update($xh,$data2);
		};
		echo '<script> alert("图片更新成功！");</script>';
		redirect('/user/info','refresh');
	}
	
	
	//删除
	public function delete(){
		$pid = $_GET['pid'];
		echo '<meta charset="utf-8">';
		if($pid==""){
			echo '<script> alert("非法操作！");</script>';
			redirect('/','refresh');
		}
		$data1 = array('pid'=>$pid);
		$data2 = array('tag_delete'=>1);
		$this->M_user->post_update($data1,$data2);
		if(mysql_affected_rows()==0){
			echo '<script> alert("您已经删除过了！");</script>';
		}else{
			echo '<script> alert("删除成功！");</script>';
		}
		redirect('/user/myletters','refresh');
	}
	
	//批量删除
	public function delete_all(){
		echo '<meta charset="utf-8">';
		if(!isset($_POST['ckb'])){
			echo '<script> alert("你提交的为空数据！");</script>';
			redirect('/user/myletters','refresh');
		}
		$mm = $_POST['ckb'];
		$pid = implode(",",$mm);
		$data1 = "1";
		$this->M_user->update_all($data1,$pid);
		if(mysql_affected_rows()==0){
			echo '<script> alert("您已经删除过了！");</script>';
		}else{
			echo '<script> alert("删除成功！");</script>';
		}
		redirect('/user/myletters','refresh');
	}
	
	//恢复
	public function back(){
		$pid = $_GET['pid'];
		echo '<meta charset="utf-8">';
		if($pid==""){
			echo '<script> alert("非法操作！");</script>';
			redirect('/','refresh');
		}
		$data1 = array('pid'=>$pid);
		$data2 = array('tag_delete'=>0);
		$this->M_user->post_update($data1,$data2);
		if(mysql_affected_rows()==0){
			echo '<script> alert("该条已经恢复了！");</script>';
		}else{
			echo '<script> alert("恢复成功！");</script>';
		}
		redirect('/user/recycle','refresh');
	}
	
	//批量恢复
	public function back_all(){
		echo '<meta charset="utf-8">';
		if(!isset($_POST['ckb'])){
			echo '<script> alert("你提交的为空数据！");</script>';
			redirect('/user/recycle','refresh');
		}
		$mm = $_POST['ckb'];
		$pid = implode(",",$mm);
		$data1 = "0";
		$this->M_user->update_all($data1,$pid);
		if(mysql_affected_rows()==0){
			echo '<script> alert("您已经恢复过了！");</script>';
		}else{
			echo '<script> alert("恢复成功！");</script>';
		}
		redirect('/user/recycle','refresh');
	}
	
	//回收站
	public function recycle(){
				
		//分页信息
		$config['base_url'] = site_url('user/recycle');
		$config['per_page'] = 20;		//每页显示多少条信息
		$segment = $this->uri->segment(3);//分割url段
		
		$data['xh'] = $this->session->userdata('xh');
		$data['user_detail'] = $this->M_user->get_user($data['xh']);
		$data['reg_style'] = $data['user_detail'][0]['reg_style'];
		$data1 = array('xh' => $data['xh']);
		$data['title'] = "回收站";
		if($data['reg_style'] == "0"){
			$this->load->view('common-header',$data);
			$this->load->view('common-left');
			$this->load->view('my-recycle');
			$this->load->view('my-footer');
		}else{
			$data['group_post'] = $this->M_user->get_group_bak($data1);
			$data['group_name'] = $data['group_post'][0]['group_name'];
			$data1 = array('group_name' => $data['group_name'],'tag_delete'=>1);
			$data['user_post'] = $this->M_user->get_post($data1);
			$count = count($data['user_post']);//统计总共有多少条相关信息

			$config['total_rows'] = $count;	//总共有多少条信息
			$data['total_rows'] = $count;
			$this->pagination->initialize($config);//初始化分页
			$data['result'] = $this->M_user->pages($config['per_page'],$segment,$data1);
			$data['links'] = $this->pagination->create_links(); //输入分页链接
			
			$this->load->view('common-header',$data);
			$this->load->view('common-left');
			$this->load->view('group-recycle');
			$this->load->view('group-letter-footer');
		}
	}

	
	//导出为word文件
	public function export_word(){
		$this->load->library('word');
		$pid = $_GET['pid'];
		if($pid==""){
			echo '<script> alert("非法操作！");</script>';
			redirect('/','refresh');
		}
		$data1 = array('pid'=>$pid);
		$data['user_post'] = $this->M_user->get_post($data1);
		$data['exportMessage'] = $this->M_user->get_message(2);
		$result = $data['user_post'][0];
		$word=new word;
		$word->start();
		echo '
		<style>
			h3{margin-bottom:3px;}
			table{border-collapse:collapse; word-break:break-all; word-wrap:break-all;} 
			table td{border:1px solid #000000;}
			tr{height:33px;}
			hr{margin:5px 0 5px 0;}
			.blank{font-size:16px; font-family:"宋体", "黑体", "微软雅黑";}
		</style>
		<meta charset="utf-8">
		<title>申请表</title>
		<p align="left">表单编号：'.$result['pid'].'  ，社团编号：'.$result['apply_group'].'</p>
		<h3 align="center">社团类申请表</h3>
		<hr size="2"></hr>
		<table width="560" border="1" bordercolor="#000000" align="center">
			<tr>
				<td width="86" align="center">姓名：</td>
				<td width="160" class="blank">'.$result['name'].'</td>
				<td width="86" align="center">性别：</td>
				<td width="128" class="blank">'.$result['sex'].'</td>
				<td rowspan="4"><img src="'.base_url().'source/uploads/'.$result['user_logo'].'" width="100" height="131"></td>
			</tr>
			<tr>
				<td width="86" align="center">学院：</td>
				<td width="160" class="blank">'.$result['faculty'].'</td>
				<td width="86" align="center">班级：</td>
				<td class="blank">'.$result['major'].'</td>

			</tr>
			<tr>
				<td width="86" align="center">电话：</td>
				<td width="160" class="blank">'.$result['tel'].'</td>
				<td width="86" align="center">生日：</td>
				<td class="blank">'.$result['birth'].'</td>

			</tr>
			<tr>
				<td width="86" align="center">家乡：</td>
				<td colspan="3" width="360" class="blank">'.$result['home'].'</td>
			</tr>
			<tr>
				<td>申请社团：</td>
				<td colspan="2" class="blank">'.$result['group_name'].'</td>
				<td>学号：</td>
				<td class="blank">'.$result['xh'].'</td>
			</tr>
			<tr>
				<td rowspan="2">申请职务：</td>
				<td rowspan="2" colspan="4" class="blank">'.$result['join_asso'].'</td>
			</tr>
			<tr></tr>
			<tr>
				<td rowspan="7">自我介绍：</td>
				<td rowspan="7" colspan="4" class="blank">'.$result['about_me'].'</td>
			</tr>
			<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
			<tr>
				<td rowspan="4">其他信息：</td>
				<td rowspan="4" colspan="4" class="blank">'.$result['others'].'</td>
			</tr>
			<tr></tr><tr></tr><tr></tr>
			<tr>
				<td rowspan="3">备注：</td>
				<td rowspan="3" colspan="4" class="blank">'.$data['exportMessage'][0]['content'].'</td>
			</tr>
		</table>
		';
		$path = 'source/download/'.$result['xh'].'-'.$result['pid'].'-'.$result['apply_group'].'.doc';
		$word->save($path);//名字由学号+表单编号+社团编号组成
		echo '<meta charset="utf-8">下载完成，可关闭本页！';
		redirect($path,'refresh');
	}
	
	//批量导出，当文件数大于1的时候，就自动压缩成压缩文件
	public function export_all(){
		$this->load->library('word');
		if(!isset($_POST['ckb'])){
			echo '<script> alert("你提交的为空数据！");</script>';
			redirect('/user/myletters','refresh');
		}
		$mm = $_POST['ckb'];
		$count = count($mm);
		
		//进行zip压缩
		$file= "source/download/download.zip";//文件名
		$zip = new ZipArchive();//创建zip
		
		//循环生成word文档
		for($i=0;$i<$count;$i++){
			$data1 = array('pid'=>$mm[$i]);
			$data['user_post'] = $this->M_user->get_post($data1);
			$data['exportMessage'] = $this->M_user->get_message(2);
			$result = $data['user_post'][0];
			$word=new word;
			$word->start();
			echo '
			<style>
				h3{margin-bottom:3px;}
				table{border-collapse:collapse; word-break:break-all; word-wrap:break-all;} 
				table td{border:1px solid #000000;}
				tr{height:33px;}
				hr{margin:5px 0 5px 0;}
				.blank{font-size:16px; font-family:"宋体", "黑体", "微软雅黑";}
			</style>
			<meta charset="utf-8">
			<title>申请表</title>
			<p align="right">表单编号：'.$result['pid'].'  ，社团编号：'.$result['apply_group'].'</p>
			<h3 align="center">社团类申请表</h3>
			<hr size="2"></hr>
			<table width="560" border="1" bordercolor="#000000">
				<tr>
					<td width="86" align="center">姓名：</td>
					<td width="160" class="blank">'.$result['name'].'</td>
					<td width="86" align="center">性别：</td>
					<td width="128" class="blank">'.$result['sex'].'</td>
					<td rowspan="4"><img src="'.base_url().'source/uploads/'.$result['user_logo'].'" width="100" height="131"></td>
				</tr>
				<tr>
					<td width="86" align="center">学院：</td>
					<td width="160" class="blank">'.$result['faculty'].'</td>
					<td width="86" align="center">班级：</td>
					<td class="blank">'.$result['major'].'</td>
	
				</tr>
				<tr>
					<td width="86" align="center">电话：</td>
					<td width="160" class="blank">'.$result['tel'].'</td>
					<td width="86" align="center">生日：</td>
					<td class="blank">'.$result['birth'].'</td>
	
				</tr>
				<tr>
					<td width="86" align="center">家乡：</td>
					<td colspan="3" width="360" class="blank">'.$result['home'].'</td>
				</tr>
				<tr>
					<td>申请社团：</td>
					<td colspan="2" class="blank">'.$result['group_name'].'</td>
					<td>学号：</td>
					<td class="blank">'.$result['xh'].'</td>
				</tr>
				<tr>
					<td rowspan="2">申请职务：</td>
					<td rowspan="2" colspan="4" class="blank">'.$result['join_asso'].'</td>
				</tr>
				<tr></tr>
				<tr>
					<td rowspan="7">自我介绍：</td>
					<td rowspan="7" colspan="4" class="blank">'.$result['about_me'].'</td>
				</tr>
				<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
				<tr>
					<td rowspan="4">其他信息：</td>
					<td rowspan="4" colspan="4" class="blank">'.$result['others'].'</td>
				</tr>
				<tr></tr><tr></tr><tr></tr>
				<tr>
					<td rowspan="3">备注：</td>
					<td rowspan="3" colspan="4" class="blank">'.$data['exportMessage'][0]['content'].'</td>
				</tr>
			</table>
			
			';
			//将路径保存到数组中
			$path[$i] = 'source/download/'.$result['xh'].'-'.$result['pid'].'-'.$result['apply_group'].'.doc';
			$word->save($path[$i]);//名字由学号+表单编号+社团编号组成
			
			//将文件写入zip文件
			if($zip->open($file, ZipArchive::CREATE))
			{
				$attachfile = $path[$i];
		  		$zip->addFile($attachfile , basename($attachfile));//往zip中添加文件
			}
		}

		$zip->close();//关闭zip
		header('Content-Description: File Transfer');    
		header("content-type:application/x-zip-compressed");  
		header('Content-Disposition: attachment; filename='.basename($file));     
		header('Content-Transfer-Encoding: binary');     
		header('Expires: 0');     
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');     
		header('Pragma: public');     
		header('Content-Length: ' . filesize($file));     
		@readfile($file);
		@unlink($file);
	}
	
	//查看
	public function readit(){
		$pid = $_GET['pid'];
		if($pid==""){
			echo '<script> alert("非法操作！");</script>';
			redirect('/','refresh');
		}
		$data1 = array('pid'=>$pid);
		$data['user_post'] = $this->M_user->get_post($data1);
		$data['exportMessage'] = $this->M_user->get_message(2);
		$result = $data['user_post'][0];
		echo '
		<style>
			h3{margin-bottom:3px;}
			table{border-collapse:collapse; word-break:break-all; word-wrap:break-all;} 
			table td{border:1px solid #000000;}
			tr{height:33px;}
			hr{margin:5px 0 5px 0;}
			.blank{font-size:16px; font-family:"宋体", "黑体", "微软雅黑";}
		</style>
		<meta charset="utf-8">
		<title>申请表</title>
		<p align="left">表单编号：'.$result['pid'].'  ，社团编号：'.$result['apply_group'].'</p>
		<h3 align="center">社团类申请表</h3>
		<hr size="2"></hr>
		<table width="560" border="1" bordercolor="#000000" align="center">
			<tr>
				<td width="86" align="center">姓名：</td>
				<td width="160" class="blank">'.$result['name'].'</td>
				<td width="86" align="center">性别：</td>
				<td width="128" class="blank">'.$result['sex'].'</td>
				<td rowspan="4"><img src="'.base_url().'source/uploads/'.$result['user_logo'].'" width="100" height="131"></td>
			</tr>
			<tr>
				<td width="86" align="center">学院：</td>
				<td width="160" class="blank">'.$result['faculty'].'</td>
				<td width="86" align="center">班级：</td>
				<td class="blank">'.$result['major'].'</td>

			</tr>
			<tr>
				<td width="86" align="center">电话：</td>
				<td width="160" class="blank">'.$result['tel'].'</td>
				<td width="86" align="center">生日：</td>
				<td class="blank">'.$result['birth'].'</td>

			</tr>
			<tr>
				<td width="86" align="center">家乡：</td>
				<td colspan="3" width="360" class="blank">'.$result['home'].'</td>
			</tr>
			<tr>
				<td>申请社团：</td>
				<td colspan="2" class="blank">'.$result['group_name'].'</td>
				<td>学号：</td>
				<td class="blank">'.$result['xh'].'</td>
			</tr>
			<tr>
				<td rowspan="2">申请职务：</td>
				<td rowspan="2" colspan="4" class="blank">'.$result['join_asso'].'</td>
			</tr>
			<tr></tr>
			<tr>
				<td rowspan="7">自我介绍：</td>
				<td rowspan="7" colspan="4" class="blank">'.$result['about_me'].'</td>
			</tr>
			<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
			<tr>
				<td rowspan="4">其他信息：</td>
				<td rowspan="4" colspan="4" class="blank">'.$result['others'].'</td>
			</tr>
			<tr></tr><tr></tr><tr></tr>
			<tr>
				<td rowspan="3">备注：</td>
				<td rowspan="3" colspan="4" class="blank">'.$data['exportMessage'][0]['content'].'</td>
			</tr>
		</table>
		';
	}
	
	//搜索功能
	public function search(){
		$keyword = trim($_POST['keyword']);
		$data['xh'] = $this->session->userdata('xh');
		if($data['xh'] == NULL){
			echo '<script>alert("系统检测到你还没有登录！");</script>';
			echo '<script>location.href="'.base_url().'"</script>';
		}
		$result = $this->M_user->get_group_search($keyword);
		$str = json_encode($result);
		echo preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $str);
	}
	
	//404页面
	public function sorry(){
		$this->load->view('sorry');	
	}
}
