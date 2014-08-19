<?php 
	if($xh = $this->session->userdata('admin_xh')){
	}else{
		echo '<script> alert("该学号还未登陆！");</script>';
		redirect('/','refresh');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $title?> |一站式纳新系统——青春在线</title>
    <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://123.youthol.cn/zt/cdn/flatui/flat-ui.css" rel="stylesheet">
    <link href="<?php echo base_url().'source/css/common-header.css' ?>" rel="stylesheet">
    <script src="http://123.youthol.cn/zt/cdn/jquery/jquery-1.8.3.min.js" type="text/javascript"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url().'source/js/common.js' ?>"></script>
    <style>
	body{background:#ededef;}
	.main{margin-top:30px;}
	.mainLeft{margin-bottom:10px;}
	.shadow{		
		-moz-box-shadow: 0px 3px 9px #0a030a;
		-webkit-box-shadow: 0px 3px 9px #0a030a;
		box-shadow: 0px 3px 9px #0a030a;
	}
    </style>
</head>
<body>

<div class="container-fluid">
	<!--顶部-->
    <div class="header">
        <div class="top-banner col-xs-12">
        	<div class="col-xs-offset-1 col-xs-7"><a href="<?php echo base_url();?>"><span class="glyphicon glyphicon-home"></span> 系统首页</a></div>
            <?php foreach ($admin as $admin){?>
        	<div class="col-xs-offset-1 col-xs-3 personal">欢迎管理员：<?php echo $admin['name'];?> | <a href="<?php echo base_url();?>youth_admin/login_out">退出</a></div>
            <?php };?>
        </div>
        <div class="top-pic col-xs-12">
            <div class="search-box">
                <div class="col-xs-offset-2 col-xs-8 form-group">
                    <input type="text" name="keyword" class="col-xs-10" data-toggle="popover" data-trigger="focus" title="输入姓名、学号或社团名称" data-content="输入为空！" placeholder="输入姓名、学号或社团名称" id="keyworld" required />
                    <button class="btn btn-success col-xs-2" id="sub-key2">搜索</button>
                </div>
                <div class="tips-search col-xs-offset-2 col-xs-8"></div>
            </div>
        </div>
    </div>