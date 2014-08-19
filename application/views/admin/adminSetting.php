        <!--left-->
        <div class="col-xs-7">
        	
        	<div class="alert alert-success shadow" role="alert"><b><?php echo $alertTitle;?></b></div>
            
            <!--新生用户面板-->
        	<div class="panel panel-info" id="shadow1">
            	<div class="panel-heading">
              		<h3 class="panel-title">管理员列表，数目：<span class="badge"><?php echo $adminNum;?></span></h3>
            	</div>
            	<div class="panel-body">
                	<table class="table table-hover">
                    	<tr>
                        	<th>编号</th>
                            <th>姓名</th>
                            <th>学号</th>
                            <th>电话</th>
                            <th>添加时间</th>
                            <th>操作</th>
                        </tr>
                        <?php foreach ($admin as $all_admim){;?>
                        <tr>
                            <td><?php echo $all_admim['id'];?></td>
                            <td><?php echo $all_admim['name'];?></td>
                            <td><?php echo $all_admim['xh'];?></td>
                            <td><?php echo $all_admim['tel'];?></td>
                            <td><?php echo $all_admim['reg_time'];?></td>
                            <td>
                            	<a href="<?php echo base_url();?>youth_admin/changePw?id=<?php echo $all_admim['id'];?>" id="changePw">修改密码</a>  
                                <a href="<?php echo base_url();?>youth_admin/deleteit?id=<?php echo $all_admim['id'];?>" onClick="delcfm('是否确定删除？')">删除</a>  
                            </td>
                        </tr>
                        <?php };?>
                    </table>
                    <div class="col-xs-12">
                        <button id="addBtn" class="btn btn-sm btn-success btn-block mainLeft"><span class="glyphicon glyphicon-ok"></span> 添加管理员</button>  
                    </div>
                    <div class="col-xs-12" style="display:none" id="addAdminAera">
                    	<div class="col-xs-12"><span class="tips5" style="color:red"></span></div>
                    	<div class="col-xs-12 mainLeft">姓名：<input type="text" name="adminName" id="adminName" value="" required="required" /></div>
                        <div class="col-xs-12 mainLeft">学号：<input type="text" name="adminXh" id="adminXh" value="" required="required" /></div>
                        <div class="col-xs-12 mainLeft">电话：<input type="text" name="adminTel" id="adminTel" value="" required="required"/></div>
                        <div class="col-xs-12 mainLeft">密码：<input type="password" name="adminPw" id="adminPw1" value="" required="required"/></div>
                        <div class="col-xs-12 mainLeft">密码：<input type="password" name="adminPw" id="adminPw2" value="" required="required"/></div>
                        <button value="添加" class="btn btn-block" id="addAdmin">添加</button>
                    </div>
            	</div>
          	</div>
            
			<script>
            $(document).ready(function() {
                $("#addAdmin").click(function(){
                    var adminName = $("#adminName").val();
                    var adminXh = $("#adminXh").val();
                    var adminTel = $("#adminTel").val();
					var adminPw1 = $("#adminPw1").val();
					var adminPw2 = $("#adminPw2").val();
                    if(adminName == ""||adminXh == ""||adminTel == "") $(".tips5").html("<b>*所有信息必填！</b>");
                    if(adminPw1.length < 6 || adminPw2.length < 6) $(".tips5").html("<b>*新密码不能少于六位！</b>");
                    if(adminPw1 != adminPw2) $(".tips5").html("<b>*两次密码不相同！</b>");
					if(adminXh.length != 11 || adminTel.length !=11) $(".tips5").html("<b>*学号或者电话不符合规范！</b>");
				    if(adminName != "" && adminXh != "" && adminTel != ""  && adminPw1.length>=6 && adminPw1.length>=6&&adminPw1 == adminPw1){
                        $.post(  
                            '/CodeIgniter_2.2.0/youth_admin/addAdmin',  
                            {  
                                name:$("#adminName").val(), 
                                xh:$("#adminXh").val(), 
                                tel:$("#adminTel").val(), 
								pw:$("#adminPw1").val(),
                            },
                            function (data)  
                            {  	
                                if(data == 0) $(".tips5").html("<b>*添加失败！</b>");
                                if(data == 1) $(".tips5").html("<b>*添加成功！</b>");location.reload();
                            }  
                        ); 
                    }
                });
            });
            </script>
        </div>
    </div>