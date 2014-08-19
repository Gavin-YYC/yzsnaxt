<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>一站式纳新系统——青春在线</title>
    <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://123.youthol.cn/zt/cdn/flatui/flat-ui.css" rel="stylesheet">
    <link href="<?php echo base_url().'source/css/base.css' ?>" rel="stylesheet">
    <script src="http://123.youthol.cn/zt/cdn/jquery/jquery-1.8.3.min.js" type="text/javascript"></script>
	<script type="text/javascript">
    $(document).ready(function(){
		var brow=$.browser; 
    	var bInfo=""; 
    	if(brow.msie) {bInfo="Microsoft Internet Explorer "+brow.version;} 
		if(bInfo == "Microsoft Internet Explorer 8.0" || bInfo == "Microsoft Internet Explorer 9.0"){
			$(".tips_xh").html("学号：");
			$(".tips_pw").html("密码：");
			$(".tips_name").html("姓名：");
			$(".tips_tel").html("手机：");
			$(".tips_pw2").html("确认密码：");
		}
		
    	$(".bt2").click(function(){
			$(".login").hide();
			$(".register").show();
			$(".infor").hide();
    	});
    	$(".bt1").click(function(){
			$(".login").show();
			$(".register").hide();
			$(".infor").hide();
    	});

	
		<!--表单验证-->
		$("button").click(function(e){
			if($("#xh").val().length != 11) {
				$(".tishi b").html("请输入11位学号！");
				 $("#xh").focus();
				 return false;
			}
			if($("#tel").val().length != 11){
				 $(".tishi b").html("请输入正确的手机号码！");
				 $("#tel").focus();
				 return false;	
			}
			if($("#pw1").val().length < 6 || $("#pw2").val().length < 6){
				 $(".tishi b").html("密码最少为6位！");
				 $("#pw1").focus();
				 return false;	
			}
			if($("#pw1").val() != $("#pw2").val()){
				 $(".tishi b").html("您输入的两次密码不相同！");
				 $("#pw1").focus();
				 return false;	
			}
		});
		$("#btn_login").click(function(){
			if($("#xh1").val().length != 11) {
				$(".tishi b").html("请输入11位学号！");
				 $("#xh1").focus();
				 return false;
			}
			if($("#pw").val().length < 6){
				 $(".tishi b").html("密码最少为6位！");
				 $("#pw").focus();
				 return false;	
			}
		});
	});
    </script>
    <style>
    body,td,th {font-family: Lato, sans-serif;}
	.tips{color:#000000;}
    </style>
</head>
<body>

<div id="container">
	<!--导航-->
    <div class="row banner">
    	<h1 align="center">一站式纳新系统</h1>
    	<div class="col-xs-offset-4 col-xs-4 tishi"><b></b></div>
        <div class="col-xs-offset-4 col-xs-4">
            <div class="col-xs-6 bt1"><a href="#" class="btn btn-block btn-lg">登陆</a></div>
            <div class="col-xs-6 bt2"><a href="#" class="btn btn-block btn-lg">注册</a></div>
        </div>
    </div>
	<div class="rap">
        <!--登陆-->
        <div class="login">
            <form method="post" action="user/login">
            <div class="col-xs-offset-4 col-xs-4 form-group">
            	<span class="tips tips_xh"></span>
                <input type="text" name="xh" id="xh1" placeholder="学号" class="col-xs-12" required />
            </div>
            <div class="col-xs-offset-4 col-xs-4 form-group">
            	<span class="tips tips_pw"></span>
                <input type="password" name="pw" id="pw" placeholder="密码" class="col-xs-12" required />
            </div>
            <div class="col-xs-offset-4 col-xs-4 form-group"><input id="btn_login" type="submit" class="btn btn-large btn-block " name="登陆" value="登陆" /></div>
            </form>
        </div>    
        <!--注册-->
        <div class="register">
  		<form method="post" action="user/register">
            <div class="col-xs-offset-4 col-xs-4 form-group">
            	<select class="form-control" name="reg_style" id="reg_style">
                	<option value="0">类型：新生</option>
                    <option value="1">类型：社团负责人</option>
                </select>
            </div>
            <div class="col-xs-offset-4 col-xs-4 form-group"><span class="tips tips_xh"></span><input type="text" id="xh" name="xh" placeholder="学号" class="col-xs-12" required /></div>
            <div class="col-xs-offset-4 col-xs-4 form-group"><span class="tips tips_name"></span><input type="text" id="name" name="name" placeholder="姓名" class="col-xs-12" required /></div>
            <div class="col-xs-offset-4 col-xs-4 form-group"><span class="tips tips_tel"></span><input type="tel" id="tel" name="tel" placeholder="手机" class="col-xs-12" required /></div>
            <div class="col-xs-offset-4 col-xs-4 form-group"><span class="tips tips_pw"></span><input type="password" id="pw1" name="pw" placeholder="密码" class="col-xs-12" required /></div>
            <div class="col-xs-offset-4 col-xs-4 form-group"><span class="tips tips_pw2"></span><input type="password" id="pw2" name="pw" placeholder="确认密码" class="col-xs-12" required /></div>
            <div class="col-xs-offset-4 col-xs-4 form-group"><button class="btn btn-large btn-block" name="sub" value="注册">注册</button></div>
      	</form>
        </div>
    </div>
    <div class="col-xs-10 copyright" align="right"><a href="http://gavin.youthol.cn" style="color:#000000" target="_blank">程序：Gavin</a>  <a href="http://youthol.cn" style="color:#000000" target="_blank">青春在线</a></div>

</div>

</body>
</html>