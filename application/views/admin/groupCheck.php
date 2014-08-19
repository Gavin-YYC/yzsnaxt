        <!--left-->
        <div class="col-xs-7">
        	
        	<div class="alert alert-success shadow" role="alert"><b><?php echo $alertTitle;?></b></div>
            
            <!--新生用户面板-->
        	<div class="panel panel-info" id="shadow1">
            	<div class="panel-heading">
              		<h3 class="panel-title">未审核的社团负责人列表，数目：<span class="badge"><?php echo $noPowerUserNum;?></span></h3>
            	</div>
            	<div class="panel-body">
                	<table class="table table-hover">
                    	<tr>
                        	<th>选择</th>
                        	<th>编号</th>
                            <th>姓名</th>
                            <th>学号</th>
                            <th>手机</th>
                            <th>注册时间</th>
                        </tr>
                        <form method="post" action="#" name="form1">
                        <?php foreach ($result as $noPowerUser){;?>
                        <tr>
                        	<td><input type="checkbox" name='ckb[]' class="ckb" style="width:15px;" value="<?php echo $noPowerUser['uid'];?>" /></td>
                            <td><?php echo $noPowerUser['uid'];?></td>
                            <td><?php echo $noPowerUser['name'];?></td>
                            <td><?php echo $noPowerUser['xh'];?></td>
                            <td><?php echo $noPowerUser['tel'];?></td>
                            <td><?php echo $noPowerUser['reg_time'];?></td>
                        </tr>
                        <?php };?>
                    </table>
                    <div class="col-xs-12">
                    	<a class="btn btn-sm btn-success" onclick="allCkb('ckb')"><span class="glyphicon glyphicon-arrow-up"></span> 全选</a>  
                        <a class="btn btn-sm btn-success" onclick="unAllCkb()"><span class="glyphicon glyphicon-arrow-down"></span> 全不选</a>  操作：  
                        <button onClick="javascript:form1.action='<?php echo base_url();?>youth_admin/check_all?fromurl=0';delcfm('是否确定通过审核？')" id="check" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-ok"></span> 审核通过</button>  
                        <button onClick="javascript:form1.action='<?php echo base_url();?>youth_admin/delete_all?fromurl=0';delcfm('确定要彻底删除？')" id="delete" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-trash"></span> 删除</button>
                    </div>
                    </form>
                    <div class="col-xs-offset-2 col-xs-8"><ul class="pagination"><?php  echo $links;?></ul></div>
            	</div>
          	</div>
        </div>
    </div>