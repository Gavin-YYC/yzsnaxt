        <!--left-->
        <div class="col-xs-7">
        	
        	<div class="alert alert-success shadow" role="alert"><b><?php echo $alertTitle;?></b></div>
            
            <!--新生用户面板-->
        	<div class="panel panel-info" id="shadow1">
            	<div class="panel-heading">
              		<h3 class="panel-title">新生注册列表，数目：<span class="badge"><?php echo $sdutentNum;?></span></h3>
            	</div>
            	<div class="panel-body">
                	<table class="table table-hover">
                    	<tr>
                        	<th>选择</th>
                        	<th>编号</th>
                            <th>姓名（性别）</th>
                            <th>学号</th>
                            <th>手机</th>
                            <th>注册时间</th>
                            <th>操作</th>
                        </tr>
                        <form method="post" action="#" name="form1">
                        <?php foreach ($result as $all_user){;?>
                        <tr>
                        	<td><input type="checkbox" name='ckb[]' class="ckb" style="width:15px;" value="<?php echo $all_user['uid'];?>" /></td>
                            <td><?php echo $all_user['uid'];?></td>
                            <td><?php echo $all_user['name'];?>（<?php echo $all_user['sex'];?>）</td>
                            <td><?php echo $all_user['xh'];?></td>
                            <td><?php echo $all_user['tel'];?></td>
                            <td><?php echo $all_user['reg_time'];?></td>
                            <td>
                            	<a href="<?php echo base_url();?>youth_admin/readit?uid=<?php echo $all_user['uid'];?>&&fromurl=1" target="_blank">查看</a>
                            </td>
                        </tr>
                        <?php };?>
                    </table>
                    <div class="col-xs-12">
                    	<a class="btn btn-sm btn-success" onclick="allCkb('ckb')"><span class="glyphicon glyphicon-arrow-up"></span> 全选</a>  
                        <a class="btn btn-sm btn-success" onclick="unAllCkb()"><span class="glyphicon glyphicon-arrow-down"></span> 全不选</a>  操作：  
                        <button onClick="javascript:form1.action='<?php echo base_url();?>youth_admin/export_all?fromurl=1';delcfm('是否确定导出？')" id="check" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-ok"></span> 导出word</button>  
                        <button onClick="javascript:form1.action='<?php echo base_url();?>youth_admin/delete_all?fromurl=1';delcfm('确定要彻底删除？')" id="delete" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-trash"></span> 删除</button>
                    </div>
                    </form>
                    <div class="col-xs-offset-2 col-xs-8"><ul class="pagination"><?php  echo $links;?></ul></div>
            	</div>
          	</div>
        </div>
    </div>