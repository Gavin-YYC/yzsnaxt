<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*

后台页面
主要功能有：审核、取消审核，删除，查看，导出word，数据统计
不提供修改功能，包括新生信息，表单信息，社团信息，社团负责人信息等，都没有修改功能
代码比较冗杂，重叠的部分由很多，用php做的比较完善的第一个项目，代码上可能看不过去
程序：杨友存（Gavin）
电话：18369956016，博客：gavin.youthol.cn

*/

class Youth_admin extends CI_Controller {

	 function __construct()
	 {
		parent::__construct();
		$this->load->database();	//载入数据库类
		$this->load->helper('url');	//载入url类
		$this->load->library('session');	//载入session类
		$this->load->library('pagination');	//载入分页类
		date_default_timezone_set('Asia/Shanghai');	//载入时区
		$this->load->model('m_admin');	//载入模型
		$this->output->set_header("Content-Type: text/html; charset=utf-8"); //设置全局输出编码
	}

	//首页
	public function index(){
		$data['title'] = "后台管理";
		$data['sub_url'] = "youth_admin/login";
		$this->load->view("admin/login",$data);
	}
	
	//登陆
	public function login(){
		$xh = $_POST['xh'];
		$pw = md5($_POST['pw']);
		if($xh == NULL){
			echo '<script>alert("系统检测到你还没有输入信息！");</script>';
			echo '<script>location.href="'.base_url().'"</script>';	
		}
		$table = "admin";
		$data1 = array('xh'=>$xh,'pw'=>$pw);
		$result = $this->m_admin->select_user($table,$data1);
		$count = count($result);
		if($count == "1"){
			$this->session->set_userdata('admin_xh',$xh);
			echo json_encode($count);
		}
		if($count == "0") echo json_encode($count);
	}
	
	//注销
	public function login_out(){
		$login=$this->m_admin->login_out();
		redirect('/');
	}
	
	/*
		进入主页面，该页面是数据统计页面，输出数据库的一些数字信息
	*/
	public function main(){
		$data['xh'] = $this->session->userdata('admin_xh');
		if($data['xh'] == NULL){
			echo '<script>alert("系统检测到你还没有登录！");</script>';
			echo '<script>location.href="'.base_url().'"</script>';
		}
		$table1 = "admin";
		$table2 = "user";
		$table3 = "group";
		$table4 = "post";
		$data1 = array('xh'=>$data['xh']);
		$data2 = array('reg_style'=>"1",'power' => "0" );
		$data3 = array('reg_style'=>"1",'power' => "1" );
		$data4 = array('reg_style'=>"0");
		$data['admin'] = $this->m_admin->select_user($table1,$data1);	//获取该管理员信息
		$data['all_user'] = $this->m_admin->get_user($table2);	//获取所有注册用户
		$data['all_newuser'] = $this->m_admin->get_user_limit($table2,$data4);	//获取所有注册用户
		$data['all_group'] = $this->m_admin->get_user($table3);	//获取所有社团
		$data['all_post'] = $this->m_admin->get_user($table4);	//获取所有申请表
		$data['PowerUser'] = $this->m_admin->select_user($table2,$data2);	//已经审核的社团负责人
		$data['noPowerUser'] = $this->m_admin->select_user($table2,$data3);	//还没有审核的社团负责人
		$data['PowerUserNum'] = count($data['PowerUser']);//已经审核的数量
		$data['noPowerUserNum'] = count($data['noPowerUser']);	//没有审核的数量
		//初始化用户组统计变量
		$data['timeCount'] = 0;
		$data['groupCount'] = 0;
		$data['postCount'] = 0;
		$data['aveCount'] = 0;	//每个社团平均收到的申请数
		$data['todayCheck'] = 0; //今日审核
		$data['userNum'] = count($data['all_user']); 
		$data['postNum'] = count($data['all_post']);
		$data['groupNum'] = count($data['all_group']);
		$data['title'] = "后台管理中心"; 
		$data['alertTitle'] = "战报（统计信息）";
		$this->load->view('admin/commonHeader',$data);
		$this->load->view('admin/commonLeft');
		$this->load->view('admin/main');
		$this->load->view('admin/commonFooter');
	}
	
	//进入社团审核页面
	public function check(){
		//进行验证是否登录
		$data['xh'] = $this->session->userdata('admin_xh');
		if($data['xh'] == NULL){
			echo '<script>alert("系统检测到你还没有登录！");</script>';
			echo '<script>location.href="'.base_url().'"</script>';
		}
		//分页基本配置信息
		$config['base_url'] = site_url('youth_admin/check');
		$config['per_page'] = 20;		//每页显示多少条信息
		$segment = $this->uri->segment(3);//分割url段
		//查询表
		$table1 = "admin";
		$table2 = "user";
		//查询数据数组
		$data1 = array('xh'=>$data['xh']);
		$data3 = array('reg_style'=>"1",'power' => "1" );
		
		//执行查询语句
		$data['admin'] = $this->m_admin->select_user($table1,$data1);	//获取该管理员信息
		$data['noPowerUser'] = $this->m_admin->select_user($table2,$data3);
		//获取查询结果
		$data['noPowerUserNum'] = count($data['noPowerUser']);	//没有审核的数量
		
		//获取分页结果
		$config['total_rows'] = $data['noPowerUserNum'];	//总共有多少条信息
		$this->pagination->initialize($config);//初始化分页
		$data['result'] = $this->m_admin->pages($config['per_page'],$segment,$data3,$table2);
		$data['links'] = $this->pagination->create_links(); //输入分页链接
		
		$data['title'] = "后台管理中心"; 
		$data['alertTitle'] = "社团审核";
		//加载页面
		$this->load->view('admin/commonHeader',$data);
		$this->load->view('admin/commonLeft');
		$this->load->view('admin/groupCheck');
		$this->load->view('admin/commonFooter');
	}
	
	/*
	批量审核，其中审核与取消审核都是调用的此函数
		$fromurl:从不同陀传来的值，根据这个值来判断要删除哪个表格的内容，其中
		0表示从【社团审核】界面传来的，对应views下的：groupCheck.php
		取消审核为【社团负责人管理】界面的功能，对应views下的groupManager.php
	*/
	public function check_all(){
		$fromurl = $_GET['fromurl'];
		if($fromurl=="0"){
			$loadurl="check";
			$data1 = "0";
		}else{
			$loadurl="groupManager";
			$data1 = "1";
		}
		if(!isset($_POST['ckb'])){
			echo '<script> alert("你提交的为空数据！");</script>';
			redirect('/youth_admin/'.$loadurl,'refresh');
		}
		$mm = $_POST['ckb'];
		$fromurl = $_GET['fromurl'];
		$uid = implode(",",$mm);
		$checkTime = date('Y-m-d H:i:s');
		$this->m_admin->groupcheck($data1,$uid,$checkTime);
		if(mysql_affected_rows()==0){
			echo '<script> alert("您已经执行过了！");</script>';
		}else{
			echo '<script> alert("操作成功！");</script>';
		}
		redirect('/youth_admin/'.$loadurl,'refresh');
	}
	
	/*
	批量删除，所有的删除调用的这一个函数
		$fromurl:从不同陀传来的值，根据这个值来判断要删除哪个表格的内容
		其中，0表示从【社团审核】界面传来的，对应views下的：groupCheck.php
			 1表示从【新生管理】界面传来的，对应views下的：newStudent.php
			 2表示从【社团管理】界面传来的，对应views下的：groupManage.php
			 3表示从【社团负责人管理】界面传来的，对应views下的：groupManager.php
			 4表示从【表单管理】界面传来的，对应views下的：postManage.php
	*/
	public function delete_all(){
		$fromurl = $_GET['fromurl'];
		if($fromurl=="1"){ 
			$loadurl="userManage"; 
		}else if($fromurl=="0"){
			$loadurl="check"; 
		}else if($fromurl=="2"){
			$loadurl="groupManage";
		}else if($fromurl=="3"){ 
			$loadurl="groupManager";
		}else if($fromurl=="4"){ 
			$loadurl="postManage";
		}
		if(!isset($_POST['ckb'])){
			echo '<script> alert("你提交的为空数据！");</script>';
			redirect('/youth_admin/'.$loadurl,'refresh');
		}
		$mm = $_POST['ckb'];
		$uid = implode(",",$mm);
		if($fromurl=="0"||$fromurl=="1"||$fromurl=="3"){
			$table = "user";
			$col = "uid";
		}else if($fromurl=="2"){
			$table = "group";
			$col = "group_id";
		}else if($fromurl=="4"){
			$table = "post";
			$col = "pid";	
		}
		$this->m_admin->groupdelete($table,$col,$uid);
		if(mysql_affected_rows()==0){
			echo '<script> alert("您已经删除过了！");</script>';
		}else{
			echo '<script> alert("删除成功！");</script>';
		}
		redirect('/youth_admin/'.$loadurl,'refresh');	
	}
	
	//进入用户管理页面
	public function userManage(){
		//进行验证是否登录
		$data['xh'] = $this->session->userdata('admin_xh');
		if($data['xh'] == NULL){
			echo '<script>alert("系统检测到你还没有登录！");</script>';
			echo '<script>location.href="'.base_url().'"</script>';
		}
		//分页基本配置信息
		$config['base_url'] = site_url('youth_admin/userManage');
		$config['per_page'] = 20;		//每页显示多少条信息
		$segment = $this->uri->segment(3);//分割url段
		//查询表
		$table1 = "admin";
		$table2 = "user";
		//查询数据数组
		$data1 = array('xh'=>$data['xh']);
		$data2 = array('reg_style'=>"0");
		
		//执行查询语句
		$data['admin'] = $this->m_admin->select_user($table1,$data1);	//获取该管理员信息
		$data['all_user'] = $this->m_admin->get_user_limit($table2,$data2);	//获取所有注册用户
		$data['sdutentNum'] = count($data['all_user']);
		
		//获取分页结果
		$config['total_rows'] = count($data['all_user']);	//总共有多少条信息
		$this->pagination->initialize($config);//初始化分页
		$data['result'] = $this->m_admin->pages($config['per_page'],$segment,$data2,$table2);
		$data['links'] = $this->pagination->create_links(); //输入分页链接
		
		
		$data['title'] = "后台管理中心"; 
		$data['alertTitle'] = "新生管理";
		$this->load->view('admin/commonHeader',$data);
		$this->load->view('admin/commonLeft');
		$this->load->view('admin/newStudent');
		$this->load->view('admin/commonFooter');
	}
	
	//查看个人信息页面
	public function readit(){	
		$uid = $_GET['uid'];
		if($uid==""){
			echo '<script> alert("非法操作！");</script>';
			redirect('/','refresh');
		}
		$fromurl = $_GET['fromurl'];
		if($fromurl=="4"){
			$table="post";	
			$data1 = array('pid'=>$uid);
		}else{
			$table = "user";
			$data1 = array('uid'=>$uid);
		}
		$data['user_detail'] = $this->m_admin->get_user_limit($table,$data1);
		$data['exportMessage'] = $this->m_admin->get_message(2);
		$result = $data['user_detail'][0];
		if($fromurl=="4"){
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
		';}else{
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
		<p align="left">用户编号：'.$result['uid'].'</p>
		<h3 align="center">个人信息表</h3>
			';
		}
		echo '
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
	
	//查看社团信息页面
	public function readitGroup(){	
		$group_id = $_GET['group_id'];
		if($group_id==""){
			echo '<script> alert("非法操作！");</script>';
			redirect('/','refresh');
		}
		$table = "group";
		$data1 = array('group_id'=>$group_id);
		$data['group_detail'] = $this->m_admin->get_user_limit($table,$data1);
		$data['exportMessage'] = $this->m_admin->get_message(2);
		$result = $data['group_detail'][0];
		echo '
		<style>
			h3{margin-bottom:3px;}
			table{border-collapse:collapse; word-break:break-all; word-wrap:break-all;} 
			table td{border:1px solid #000000;}
			tr{height:33px;}
			hr{margin:5px 0 5px 0;}
			.blank{font-size:12px; font-family:"宋体", "黑体", "微软雅黑";}
		</style>
		<meta charset="utf-8">
		<title>申请表</title>
		<p align="left">社团编号：'.$result['group_id'].'</p>
		<h3 align="center">社团类信息表</h3>
		<hr size="2"></hr>
		<table width="560" border="1" bordercolor="#000000" align="center">
			<tr>
				<td width="86" align="center">社团名称：</td>
				<td width="160" class="blank">'.$result['group_name'].'</td>
				<td width="86" align="center">隶属于：</td>
				<td width="128" class="blank">'.$result['group-belong'].'</td>
				<td rowspan="3"><img src="'.base_url().'source/uploads/'.$result['group_logo'].'" width="100" height="131"></td>
			</tr>
			<tr>
				<td width="86" align="center">类型：</td>
				<td width="160" class="blank">'.$result['gid'].'</td>
				<td width="86" align="center">负责人学号：</td>
				<td class="blank">'.$result['xh'].'</td>

			</tr>
			<tr>
				<td width="86" align="center">社团成立日期：</td>
				<td width="160" class="blank">'.$result['group-fromdata'].'</td>
				<td width="86" align="center">社团开通日期：</td>
				<td class="blank">'.$result['set_time'].'</td>

			</tr>
			<tr>
				<td rowspan="2">社团简介：</td>
				<td rowspan="2" colspan="4" class="blank">'.$result['group-brief'].'</td>
			</tr>
			<tr></tr>
			<tr>
				<td rowspan="7">详细介绍：</td>
				<td rowspan="7" colspan="4" class="blank">'.$result['group-detail'].'</td>
			</tr>
			<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
			<tr>
				<td rowspan="4">纳新范围：</td>
				<td rowspan="4" colspan="4" class="blank">'.$result['group_wide'].'</td>
			</tr>
			<tr></tr><tr></tr><tr></tr>
			<tr>
				<td rowspan="2">报名方式：</td>
				<td rowspan="2" colspan="4" class="blank">'.$result['group_way'].'</td>
			</tr>
			<tr></tr>
			<tr>
				<td rowspan="2">其他信息：</td>
				<td rowspan="2" colspan="4" class="blank">'.$result['group_others'].'</td>
			</tr>
			<tr></tr>
			<tr>
				<td rowspan="1">备注：</td>
				<td rowspan="1" colspan="4" class="blank">'.$data['exportMessage'][0]['content'].'</td>
			</tr>
			
		</table>
		';
	}
	
	//批量导出，自动压缩成压缩文件——用户信息页面
	public function export_all(){
		$fromurl = $_GET['fromurl'];
		if($formurl=="4") $loadrul = "postManage"; else $loadrul="userManage";
		$this->load->library('word');
		if(!isset($_POST['ckb'])){
			echo '<script> alert("你提交的为空数据！");</script>';
			redirect('/youth_admin/'.$loadrul,'refresh');
		}
		$mm = $_POST['ckb'];
		$count = count($mm);
		
		//进行zip压缩
		if($fromurl=="4")$file = "source/download/PostDownload.zip"; else $file= "source/download/UserDownload.zip";//文件名
		$zip = new ZipArchive();//创建zip
		
		//循环生成word文档
		for($i=0;$i<$count;$i++){
			if($fromurl=="4"){ 
				$table="post";
				$data1 = array('pid'=>$mm[$i]);
			}else{
				$table = "user";
				$data1 = array('uid'=>$mm[$i]);
			}
			$data['user_detail'] = $this->m_admin->get_user_limit($table,$data1);
			$data['exportMessage'] = $this->m_admin->get_message(2);
			$result = $data['user_detail'][0];
			$word=new word;
			$word->start();
			//定义页面显示的内容
		if($fromurl=="4"){
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
		';}else{
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
		<p align="left">用户编号：'.$result['uid'].'</p>
		<h3 align="center">个人信息表</h3>
			';
		}
		echo '
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
			if($fromurl=="4")
				$path[$i] = 'source/download/'.$result['xh'].'-'.$result['pid'].'-'.$result['apply_group'].'.doc';
			else $path[$i] = 'source/download/new'.$result['xh'].'-'.$result['uid'].'.doc';	//定义文件名：new学号-编号uid
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
	
	//批量导出——社团信息页面
	public function export_allGroup(){
		$this->load->library('word');
		if(!isset($_POST['ckb'])){
			echo '<script> alert("你提交的为空数据！");</script>';
			redirect('/youth_admin/groupManage','refresh');
		}
		$mm = $_POST['ckb'];
		$count = count($mm);

		//进行zip压缩
		$file= "source/download/download.zip";//文件名
		$zip = new ZipArchive();//创建zip
		
		//循环生成word文档
		for($i=0;$i<$count;$i++){
			$table = "group";
			$data1 = array('group_id'=>$mm[$i]);
			$data['group_detail'] = $this->m_admin->get_user_limit($table,$data1);
			$data['exportMessage'] = $this->m_admin->get_message(2);
			$result = $data['group_detail'][0];
			$word=new word;
			$word->start();
			//定义页面显示的内容
			echo '
		<style>
			h3{margin-bottom:3px;}
			table{border-collapse:collapse; word-break:break-all; word-wrap:break-all;} 
			table td{border:1px solid #000000;}
			tr{height:33px;}
			hr{margin:5px 0 5px 0;}
			.blank{font-size:12px; font-family:"宋体", "黑体", "微软雅黑";}
		</style>
		<meta charset="utf-8">
		<title>申请表</title>
		<p align="left">社团编号：'.$result['group_id'].'</p>
		<h3 align="center">社团类信息表</h3>
		<hr size="2"></hr>
		<table width="560" border="1" bordercolor="#000000" align="center">
			<tr>
				<td width="86" align="center">社团名称：</td>
				<td width="160" class="blank">'.$result['group_name'].'</td>
				<td width="86" align="center">隶属于：</td>
				<td width="128" class="blank">'.$result['group-belong'].'</td>
				<td rowspan="3"><img src="'.base_url().'source/uploads/'.$result['group_logo'].'" width="100" height="131"></td>
			</tr>
			<tr>
				<td width="86" align="center">类型：</td>
				<td width="160" class="blank">'.$result['gid'].'</td>
				<td width="86" align="center">负责人学号：</td>
				<td class="blank">'.$result['xh'].'</td>

			</tr>
			<tr>
				<td width="86" align="center">社团成立日期：</td>
				<td width="160" class="blank">'.$result['group-fromdata'].'</td>
				<td width="86" align="center">社团开通日期：</td>
				<td class="blank">'.$result['set_time'].'</td>

			</tr>
			<tr>
				<td rowspan="2">社团简介：</td>
				<td rowspan="2" colspan="4" class="blank">'.$result['group-brief'].'</td>
			</tr>
			<tr></tr>
			<tr>
				<td rowspan="7">详细介绍：</td>
				<td rowspan="7" colspan="4" class="blank">'.$result['group-detail'].'</td>
			</tr>
			<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
			<tr>
				<td rowspan="4">纳新范围：</td>
				<td rowspan="4" colspan="4" class="blank">'.$result['group_wide'].'</td>
			</tr>
			<tr></tr><tr></tr><tr></tr>
			<tr>
				<td rowspan="2">报名方式：</td>
				<td rowspan="2" colspan="4" class="blank">'.$result['group_way'].'</td>
			</tr>
			<tr></tr>
			<tr>
				<td rowspan="2">其他信息：</td>
				<td rowspan="2" colspan="4" class="blank">'.$result['group_others'].'</td>
			</tr>
			<tr></tr>
			<tr>
				<td rowspan="1">备注：</td>
				<td rowspan="1" colspan="4" class="blank">'.$data['exportMessage'][0]['content'].'</td>
			</tr>
			
		</table>
		';
			//将路径保存到数组中
			$path[$i] = 'source/download/group'.$result['xh'].'-'.$result['group_id'].'.doc';	//定义文件名：group学号-编号group_id
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
	
	//进入社团管理页面
	public function groupManage(){
		//进行验证是否登录
		$data['xh'] = $this->session->userdata('admin_xh');
		if($data['xh'] == NULL){
			echo '<script>alert("系统检测到你还没有登录！");</script>';
			echo '<script>location.href="'.base_url().'"</script>';
		}
		//分页基本配置信息
		$config['base_url'] = site_url('youth_admin/groupManage');
		$config['per_page'] = 20;		//每页显示多少条信息
		$segment = $this->uri->segment(3);//分割url段
		//查询表
		$table1 = "admin";
		$table2 = "group";
		//查询数据数组
		$data1 = array('xh'=>$data['xh']);
		
		//执行查询语句
		$data['admin'] = $this->m_admin->select_user($table1,$data1);	//获取该管理员信息
		$data['all_group'] = $this->m_admin->get_user($table2);	//获取所有开通的社团
		$data['groupNum'] = count($data['all_group']);
		
		//获取分页结果
		$config['total_rows'] = count($data['all_group']);	//总共有多少条信息
		$this->pagination->initialize($config);//初始化分页
		$data['result'] = $this->m_admin->pages_limit($config['per_page'],$segment,$table2);
		$data['links'] = $this->pagination->create_links(); //输入分页链接
		
		
		$data['title'] = "后台管理中心"; 
		$data['alertTitle'] = "社团管理";
		$this->load->view('admin/commonHeader',$data);
		$this->load->view('admin/commonLeft');
		$this->load->view('admin/groupManage');
		$this->load->view('admin/commonFooter');
	}
	
	//社团负责人页面
	public function groupManager(){
		//进行验证是否登录
		$data['xh'] = $this->session->userdata('admin_xh');
		if($data['xh'] == NULL){
			echo '<script>alert("系统检测到你还没有登录！");</script>';
			echo '<script>location.href="'.base_url().'"</script>';
		}
		//分页基本配置信息
		$config['base_url'] = site_url('youth_admin/groupManager');
		$config['per_page'] = 20;		//每页显示多少条信息
		$segment = $this->uri->segment(3);//分割url段
		//查询表
		$table1 = "admin";
		$table2 = "user";
		//查询数据数组
		$data1 = array('xh'=>$data['xh']);
		$data3 = array('reg_style'=>"1",'power' => "0" );
		
		//执行查询语句
		$data['admin'] = $this->m_admin->select_user($table1,$data1);	//获取该管理员信息
		$data['PowerUser'] = $this->m_admin->select_user($table2,$data3);
		//获取查询结果
		$data['PowerUserNum'] = count($data['PowerUser']);	//没有审核的数量
		
		//获取分页结果
		$config['total_rows'] = $data['PowerUserNum'];	//总共有多少条信息
		$this->pagination->initialize($config);//初始化分页
		$data['result'] = $this->m_admin->pages($config['per_page'],$segment,$data3,$table2);
		$data['links'] = $this->pagination->create_links(); //输入分页链接
		
		$data['title'] = "后台管理中心"; 
		$data['alertTitle'] = "社团审核";
		//加载页面
		$this->load->view('admin/commonHeader',$data);
		$this->load->view('admin/commonLeft');
		$this->load->view('admin/groupManager');
		$this->load->view('admin/commonFooter');
	}
	
	//进入表单管理页面
	public function postManage(){
		//进行验证是否登录
		$data['xh'] = $this->session->userdata('admin_xh');
		if($data['xh'] == NULL){
			echo '<script>alert("系统检测到你还没有登录！");</script>';
			echo '<script>location.href="'.base_url().'"</script>';
		}
		//分页基本配置信息
		$config['base_url'] = site_url('youth_admin/postManage');
		$config['per_page'] = 20;		//每页显示多少条信息
		$segment = $this->uri->segment(3);//分割url段
		//查询表
		$table1 = "admin";
		$table2 = "post";
		
		//查询数据数组
		$data1 = array('xh'=>$data['xh']);
		
		//执行查询语句
		$data['admin'] = $this->m_admin->select_user($table1,$data1);	//获取该管理员信息
		$data['all_post'] = $this->m_admin->get_user($table2);	//获取所有表单
		$data['postNum'] = count($data['all_post']);
		
		//获取分页结果
		$config['total_rows'] = count($data['all_post']);	//总共有多少条信息
		$this->pagination->initialize($config);//初始化分页
		$data['result'] = $this->m_admin->pages_limit($config['per_page'],$segment,$table2);
		$data['links'] = $this->pagination->create_links(); //输入分页链接
		
		
		$data['title'] = "后台管理中心"; 
		$data['alertTitle'] = "表单管理";
		$this->load->view('admin/commonHeader',$data);
		$this->load->view('admin/commonLeft');
		$this->load->view('admin/postManage');
		$this->load->view('admin/commonFooter');
	}
	
	public function search(){
		$keyword = trim($_POST['keyword']);
		$data['xh'] = $this->session->userdata('admin_xh');
		if($data['xh'] == NULL){
			echo '<script>alert("系统检测到你还没有登录！");</script>';
			echo '<script>location.href="'.base_url().'"</script>';
		}
		$result = $this->m_admin->get_search($keyword);
		
		$str = json_encode($result);
		
		echo preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $str);
	}
	
	//进入管理员设置页面
	public function adminSetting(){
		//进行验证是否登录
		$data['xh'] = $this->session->userdata('admin_xh');
		if($data['xh'] == NULL){
			echo '<script>alert("系统检测到你还没有登录！");</script>';
			echo '<script>location.href="'.base_url().'"</script>';
		}
		$table = "admin";
		$data['admin'] = $this->m_admin->get_user($table);
		$data['adminNum'] = count($data['admin']);
		$data['title'] = "后台管理中心"; 
		$data['alertTitle'] = "管理员设置";
		//加载页面
		$this->load->view('admin/commonHeader',$data);
		$this->load->view('admin/commonLeft');
		$this->load->view('admin/adminSetting');
		$this->load->view('admin/commonFooter');	
	}
	
	//进入修改密码界面
	public function changePw(){
		//进行验证是否登录
		$data['xh'] = $this->session->userdata('admin_xh');
		if($data['xh'] == NULL){
			echo '<script>alert("系统检测到你还没有登录！");</script>';
			echo '<script>location.href="'.base_url().'"</script>';
		}
		$id = $_GET['id'];
		$table = "admin";
		$data = array('id'=>$id);
		$data['admin'] = $this->m_admin->get_user_limit($table,$data);
		$data['title'] = "后台管理中心"; 
		$data['alertTitle'] = "修改密码";
		//加载页面
		$this->load->view('admin/commonHeader',$data);
		$this->load->view('admin/commonLeft');
		$this->load->view('admin/changePw');
		$this->load->view('admin/commonFooter');	
	}
	
	//修改密码处理页面
	public function changePwSub(){
		$oldPw = md5($_POST['oldPw']);
		$newPw1 = md5($_POST['newPw1']);
		$id = $_GET['id'];
		$table = "admin";
		$col = array('id'=>$id);
		$data['admin'] = $this->m_admin->get_user_limit($table,$col);
		if($oldPw != $data['admin'][0]['pw']){
			$msg = 0; //0表示，原始密码错误
		}else{
			$data = array('pw'=>$newPw1);
			$this->m_admin->update_all($table,$col,$data);
			$msg = 1;
		}
		echo json_encode($msg);
	}
	//删除管理员
	public function deleteit(){
		$id = $_GET['id'];
		$table = "admin";
		$col = "id";
		$this->m_admin->groupdelete($table,$col,$id);
		if(mysql_affected_rows()==0){
			echo '<script> alert("您已经删除过了！");</script>';
		}else{
			echo '<script> alert("删除成功！");</script>';
		}
		redirect('/youth_admin/adminSetting','refresh');	
	}
	
	//添加管理员
	public function addAdmin(){
		$name = $_POST['name'];
		$xh = $_POST['xh'];
		$tel = $_POST['tel'];
		$pw = md5($_POST['pw']);
		$table = "admin";
		$data = array('name'=>$name,'xh'=>$xh,'tel'=>$tel,'pw'=>$pw);
		$this->m_admin->addInfo($table,$data);
		if(mysql_affected_rows()==0){
			$msg = 0;
		}else{
			$msg = 1;
		}
		echo json_encode($msg);
	}
	
	//进入消息设置中心
	public function messageSetting(){
		//进行验证是否登录
		$data['xh'] = $this->session->userdata('admin_xh');
		if($data['xh'] == NULL){
			echo '<script>alert("系统检测到你还没有登录！");</script>';
			echo '<script>location.href="'.base_url().'"</script>';
		}
		$table = "admin";
		$table1 = "message";
		$data1 = array('id'=>"1");
		$data2 = array('id'=>"2");
		$data['admin'] = $this->m_admin->get_user($table);
		$data['message'] = $this->m_admin->get_user_limit($table1,$data1);
		$data['message1'] = $this->m_admin->get_user_limit($table1,$data2);
		$data['title'] = "后台管理中心"; 
		$data['alertTitle'] = "信息设置中心";
		//加载页面
		$this->load->view('admin/commonHeader',$data);
		$this->load->view('admin/commonLeft');
		$this->load->view('admin/messageSetting');
		$this->load->view('admin/commonFooter');	
	}
	
	//修改消息处理
	public function updateMessage(){
		$content = ($_POST['content']);
		$id = $_GET['id'];
		$table = "message";
		$col = array('id'=>$id);
		$data = array('content'=>$content);
		$data['admin'] = $this->m_admin->update_all($table,$col,$data);
		if(mysql_affected_rows()==0) $msg = 0; else $msg=1;
		echo json_encode($msg);	
	}
}
