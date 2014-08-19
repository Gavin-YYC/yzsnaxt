        <!--left-->
        <div class="col-xs-7">
        	
        	<div class="alert alert-success shadow" role="alert"><b><?php echo $alertTitle;?></b></div>
            
            <!--新生用户面板-->
        	<div class="panel panel-info" id="shadow1">
            	<div class="panel-heading">
              		<h3 class="panel-title">社团列表，数目：<span class="badge"><?php echo $groupNum;?></span></h3>
            	</div>
            	<div class="panel-body">
                	<table class="table table-hover">
                    	<tr>
                        	<th>选择</th>
                        	<th>编号</th>
                            <th>社团名称（类型）</th>
                            <th>负责人学号</th>
                            <th>创建时间</th>
                            <th>社团开通时间</th>
                            <th>操作</th>
                        </tr>
                        <form method="post" action="#" name="form1">
                        <?php foreach ($result as $all_group){;?>
                        <tr>
                        	<td><input type="checkbox" name='ckb[]' class="ckb" style="width:15px;" value="<?php echo $all_group['group_id'];?>" /></td>
                            <td><?php echo $all_group['group_id'];?></td>
                            <td><?php echo $all_group['group_name'];?>（<?php echo $all_group['gid'];?>）</td>
                            <td><?php echo $all_group['xh'];?></td>
                            <td><?php echo $all_group['group-fromdata'];?></td>
                            <td><?php echo $all_group['set_time'];?></td>
                            <td>
                            	<a href="<?php echo base_url();?>youth_admin/readitGroup?group_id=<?php echo $all_group['group_id'];?>" target="_blank">查看</a>
                            </td>
                        </tr>
                        <?php };?>
                    </table>
                    <div class="col-xs-12">
                    	<a class="btn btn-sm btn-success" onclick="allCkb('ckb')"><span class="glyphicon glyphicon-arrow-up"></span> 全选</a>  
                        <a class="btn btn-sm btn-success" onclick="unAllCkb()"><span class="glyphicon glyphicon-arrow-down"></span> 全不选</a>  操作：  
                        <button onClick="javascript:form1.action='<?php echo base_url();?>youth_admin/export_allGroup?fromurl=2';delcfm('是否确定导出？')" id="check" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-ok"></span> 导出word</button>  
                        <button onClick="javascript:form1.action='<?php echo base_url();?>youth_admin/delete_all?fromurl=2';delcfm('确定要彻底删除？')" id="delete" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-trash"></span> 删除</button>
                    </div>
                    </form>
                    <div class="col-xs-offset-2 col-xs-8"><ul class="pagination"><?php  echo $links;?></ul></div>
            	</div>
          	</div>
        </div>
    </div>