
<style>
.group{border-right:1px solid #CCC; margin-top:30px;}
.my{margin-top:30px;}
.group_detail,.my_detail{
	background-color:#f3f3f3;
	margin-bottom:30px;
	margin-top:15px;
	/*边框 css3在线生成*/
	border:none 0px #bd2cbd;
	-moz-border-radius-topleft: 16px;
	-moz-border-radius-topright:16px;
	-moz-border-radius-bottomleft:16px;
	-moz-border-radius-bottomright:16px;
	-webkit-border-top-left-radius:16px;
	-webkit-border-top-right-radius:16px;
	-webkit-border-bottom-left-radius:16px;
	-webkit-border-bottom-right-radius:16px;
	border-top-left-radius:16px;
	border-top-right-radius:16px;
	border-bottom-left-radius:16px;
	border-bottom-right-radius:16px;
	/*盒子阴影 css3在线生成*/
}
.my_detail_1{
	line-height:30px;
	border-bottom:1px solid #ccc;
}
.group_logo{
	margin-top:10px;
	width:100px;
	height:110px;
	padding:0;
}
.group_name{
	height:120px;
	line-height:120px;
}
.group_jianjie{
	line-height:20px;
}
.sub_apple{margin:10px 0 10px 0;}
.group_text{
	background:#FFF;
	/*边框 css3在线生成*/
	border:none 0px #bd2cbd;
	-moz-border-radius-topleft: 10px;
	-moz-border-radius-topright:10px;
	-moz-border-radius-bottomleft:10px;
	-moz-border-radius-bottomright:10px;
	-webkit-border-top-left-radius:10px;
	-webkit-border-top-right-radius:10px;
	-webkit-border-bottom-left-radius:10px;
	-webkit-border-bottom-right-radius:10px;
	border-top-left-radius:10px;
	border-top-right-radius:10px;
	border-bottom-left-radius:10px;
	border-bottom-right-radius:10px;
	border:2px solid #dce4ec;
}
</style>




    <div class="col-xs-6 group">
    	<div class="col-xs-12"><a href="#" class="btn btn-block btn-lg btn-primary group_indo_btn">社团信息</a></div>
    	<div class="col-xs-12 group_detail">
        <?php foreach ($group_detail as $group_detail){?>
        	<div class="col-xs-12">
        		<div class="col-xs-8 my_detail_1 group_name">社团名称：<?php echo $group_detail['group_name'];?></div>
            	<div class="col-xs-4 my_detail_1 group_logo"><img src="<?php echo base_url().'source/uploads/'.$group_detail['group_logo'];?>" class="img-responsive" style="max-width:100px; max-height:100px;" /></div>
            </div>
            <div class="col-xs-12 my_detail_1">
            	<div class="col-xs-6">所属类型：<?php echo $group_style[0]['group_name'];?></div>
            	<div class="col-xs-6">创建时间：<?php echo $group_detail['group-fromdata'];?></div>
            </div>
            <div class="col-xs-12 my_detail_1">社团详介：</div>
            <div class="col-xs-12 group_jianjie"><div class="col-xs-12 group_text"><?php echo $group_detail['group-detail'];?></div></div>
            <div class="col-xs-12 my_detail_1">纳新范围：</div>
            <div class="col-xs-12 group_jianjie"><div class="col-xs-12 group_text"><?php echo $group_detail['group_wide'];?></div></div>
            <div class="col-xs-12 my_detail_1">报名方式：</div>
            <div class="col-xs-12 group_jianjie"><div class="col-xs-12 group_text"><?php echo $group_detail['group_way'];?></div></div>
            <div class="col-xs-12 my_detail_1">其他信息：</div>
            <div class="col-xs-12 group_jianjie"><div class="col-xs-12 group_text"><?php echo $group_detail['group_others'];?></div></div>
            <input type="hidden" id="group_id" value="<?php echo $group_detail['group_id'];?>" />
            <input type="hidden" id="group_name" value="<?php echo $group_detail['group_name'];?>" />
        <?php }?>
        </div>
    </div>
    
    <div class="col-xs-6 my">
    	<div class="col-xs-12"><a href="#" class="btn btn-block btn-lg btn-success">个人信息</a></div>
    	<div class="col-xs-12 my_detail">
        <?php foreach ($user_detail as $user_details){?>
        <div class="col-xs-12 my_detail_1">
            <div class="col-xs-6">姓名：<?php echo $user_details['name'];?></div>
            <div class="col-xs-6">电话：<?php echo $user_details['tel'];?></div>
        </div>
        <div class="col-xs-12 my_detail_1">
            <div class="col-xs-6">学院：<input type="text" id="faculty" value="<?php echo $user_details['faculty'];?>" /></div>
            <div class="col-xs-6">班级：<input type="text" id="major" value="<?php echo $user_details['major'];?>" /></div>
        </div>
        <div class="col-xs-12 my_detail_1">
            <div class="col-xs-6">家乡：<input type="text" id="home" value="<?php echo $user_details['home'];?>" /></div>
            <div class="col-xs-6">生日：<input type="text" id="birth" value="<?php echo $user_details['birth'];?>" /></div>
        </div>
        <div class="col-xs-12 my_detail_1">
            <div class="col-xs-12">性别：<input type="text" id="sex" value="<?php echo $user_details['sex'];?>" /></div>
        </div>
        <div class="col-xs-12 my_detail_1">申请职务：</div>
        <div class="col-xs-12 group_jianjie"><textarea name="join_asso" id="join_asso" class="col-xs-12"><?php echo $user_details['join_asso'];?></textarea></div>
        <div class="col-xs-12 my_detail_1">自我介绍：</div>
        <div class="col-xs-12 group_jianjie"><textarea name="about_me" id="about_me" class="col-xs-12"><?php echo $user_details['about_me'];?></textarea></div>
        <div class="col-xs-12 my_detail_1">其他信息：</div>
        <div class="col-xs-12 group_jianjie"><textarea name="others" id="others" class="col-xs-12"><?php echo $user_details['others'];?></textarea></div>
        <div class="col-xs-12"><button class="btn btn-block btn-lg btn-success sub_apply">提交申请</button></div>
		<?php }?>
        </div>
    </div>
    
</div>
<script>
$(function(){ 
    $(".sub_apply").click(function(){ 
		$.post(  
			'user_apply',  
			{  
				group_id:$("#group_id").val(),
				group_name:$("#group_name").val(),
				sex:$("#sex").val(),  
				faculty:$("#faculty").val(),
				major:$("#major").val(),
				home1:$("#home").val(),
				birth:$("#birth").val(),
				join_asso:$("#join_asso").val(),
				about_me:$("#about_me").val(),
				others:$("#others").val(),
			},  
			function (data)  
			{  
				if(data == 0){
					alert("亲，你已经申请过了！");	
				}else if(data == 1){
					alert("申请成功！");	
				}else if(data == 2){
					alert("执行失败，未知原因，请联系管理员");
				}
			}  
		);  
    }); 
}); 
</script>
</body>
</html>