        <!--left-->
        <div class="col-xs-7">
        	
        	<div class="alert alert-success shadow" role="alert"><b><?php echo $alertTitle;?></b></div>
            
            <!--新生用户面板-->
        	<div class="panel panel-info" id="shadow1">
            	<div class="panel-heading">
              		<h3 class="panel-title">管理员信息</span></h3>
            	</div>
            	<div class="panel-body">
					<?php foreach($admin as $admin){;?>
                    <div class="col-xs-12">姓名：<?php echo $admin['name']?></div>
                    <div class="col-xs-12">学号：<?php echo $admin['xh']?></div>
                    <div class="col-xs-12">电话：<?php echo $admin['tel']?></div>
                    <div class="col-xs-12">添加时间：<?php echo $admin['reg_time']?></div>
                    <span class="tips4" style="color:red"></span>
                    <div class="col-xs-12">原密码：<input type="password" name="oldpw" id="oldpw" value="" /><span class="tips1" style="color:red"></span></div>
                    <div class="col-xs-12">新密码：<input type="password" name="newpw1" id="newpw1" value="" /><span class="tips2" style="color:red"></span></div>
                    <div class="col-xs-12">新密码：<input type="password" name="newpw2" id="newpw2" value="" /><span class="tips3" style="color:red"></span></div>
                    <?php }?>
                    <div class="col-xs-12">
                        <button id="changePw" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-ok"></span> 确认修改</button>  
                    </div>
            	</div>
          	</div>
        </div>
    </div>
    
    <script>
    $(document).ready(function() {
		$("#changePw").click(function(){
			var oldPw = $("#oldpw").val();
			var newPw1 = $("#newpw1").val();
			var newPw2 = $("#newpw2").val();
			if(oldPw == "") $(".tips1").html("<b>*原始密码不能为空！</b>");
			if(newPw1.length < 6 || newPw2.length < 6) $(".tips2,.tips3").html("<b>*新密码不能少于六位！</b>");
			if(newPw1 != newPw2) $(".tips3").html("<b>*两次密码不相同！</b>");
			if(oldPw != "" && newPw1.length>=6 && newPw2.length>=6&&newPw1 == newPw2){
				$.post(  
					'/CodeIgniter_2.2.0/youth_admin/changePwSub?id=<?php echo $admin['id'];?>',  
					{  
						oldPw:$("#oldpw").val(), 
						newPw1:$("#newpw1").val(), 
						newPw2:$("#newpw2").val(), 
					},
					function (data)  
					{  	
						if(data == 0) $(".tips4").html("<b>*原始密码错误！</b>");
						if(data == 1) $(".tips4").html("<b>*修改成功！</b>");
					}  
				); 
			}
		});
    });
    </script>