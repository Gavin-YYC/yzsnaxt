<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $title;?> 一站式纳新系统——青春在线</title>
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
		}
	
		<!--表单验证-->
		$("#btn").click(function(){
			if($("#xh").val().length != 11) {
				$(".tishi b").html("请输入11位学号！");
				 $("#xh").focus();
				 return false;
			}
			if($("#pw").val().length < 6){
				 $(".tishi b").html("密码最少为6位！");
				 $("#pw").focus();
				 return false;	
			}
			
			//ajax提交
			$.post(  
				'<?php echo base_url().$sub_url;?>',  
				{  
					xh:$("#xh").val(), 
					pw:$("#pw").val(),
				},
				function (data)  
				{ 
					if(data == 0) $(".tishi b").html("用户名或密码错误！");
					if(data == 1) {
						$(".tishi b").html("登陆成功");
						location.href = '<?php echo base_url()."youth_admin/main";?>';
					};
				}  
			); 
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
    	<h1 align="center">一站式纳新系统——<?php echo $title;?></h1>
    	<div class="col-xs-offset-4 col-xs-4 tishi"><b></b></div>
        <div class="col-xs-offset-4 col-xs-4">
            <div class="col-xs-12 bt1"><a href="#" class="btn btn-block btn-lg">登陆</a></div>
        </div>
    </div>
	<div class="rap">
        <!--登陆-->
        <div class="login">
            <div class="col-xs-offset-4 col-xs-4 form-group">
            	<span class="tips tips_xh"></span>
                <input type="text" name="xh" id="xh" placeholder="学号" class="col-xs-12" required />
            </div>
            <div class="col-xs-offset-4 col-xs-4 form-group">
            	<span class="tips tips_pw"></span>
                <input type="password" name="pw" id="pw" placeholder="密码" class="col-xs-12" required />
            </div>
            <div class="col-xs-offset-4 col-xs-4 form-group"><input type="submit" id="btn" class="btn btn-large btn-block " name="登陆" value="登陆" /></div>
        </div>    
    </div>
    <div class="col-xs-10 copyright" align="right"><a href="http://gavin.youthol.cn" style="color:#000000" target="_blank">程序：Gavin</a>  <a href="http://youthol.cn" style="color:#000000" target="_blank">青春在线</a></div>

</div>

</body>
</html>