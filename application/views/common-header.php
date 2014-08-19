<?php 
	if($xh = $this->session->userdata('xh')){
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
</head>
<body>

<div id="container">
	<!--顶部-->
    <div class="header">
        <div class="top-banner col-xs-12">
        	<div class="col-xs-offset-1 col-xs-7"><a href="<?php echo base_url();?>user/group_list">一站式纳新系统>>社团列表</a></div>
        	<div class="col-xs-offset-1 col-xs-3 personal"><a href="<?php echo base_url();?>user/info">个人中心</a>   |  <a href="<?php echo base_url();?>user/login_out">退出</a></div>
        </div>
        <div class="top-pic col-xs-12">
            <div class="search-box">
                <div class="col-xs-offset-2 col-xs-8 form-group">
                    <input type="text" name="keyword" class="col-xs-10" data-toggle="popover" data-trigger="focus" title="输入关键字：如青春在线网站" data-content="输入为空！" placeholder="输入关键字，例如：青春在线网站" id="keyworld" required />
                    <button class="btn btn-success col-xs-2" id="sub-key">搜索</button>
                </div>
                <div class="tips-search col-xs-offset-2 col-xs-8"></div>
            </div>
        </div>
    </div>