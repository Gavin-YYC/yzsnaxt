    <div class="col-xs-8 my_post">
		<div class="col-xs-12"><h4>总共有：<?php echo $total_rows;?>条信息</h4></div>
        <form method="post" action="#" name="form1">
        <div class="col-xs-12">
            <table class="table table-hover table-condensed">
            	<tr class="success">
                	<th>选择</th>
                	<th>序号</th>
                    <th>申请人（性别）</th>
                    <th>专业班级</th>
                    <th>申请时间</th>
                    <th>操作</th>
                </tr>
                <?php foreach ($result as $user_post){?>
                <tr>
                	<td>
  						<input type="checkbox" name='ckb[]' class="ckb" style="width:15px;" value="<?php echo $user_post['pid'];?>" />
                    </td>
                    <td><?php echo $user_post['pid'];?></td>
                    <td><?php echo $user_post['name'];?>（<?php echo $user_post['sex'];?>）</td>
                    <td><?php echo $user_post['major'];?></td>
                    <td><?php echo $user_post['apply_time'];?></td>
                    <td><a href="<?php echo base_url();?>user/delete?pid=<?php echo $user_post['pid'];?>">删除</a> 
                    	<a href="<?php echo base_url();?>user/readit?pid=<?php echo $user_post['pid'];?>" target="_blank">查看</a> 
                        <a href="<?php echo base_url();?>user/export_word?pid=<?php echo $user_post['pid'];?>" target="_blank">导出</a></td>
                </tr>    
				<?php };?>
            </table>
        </div>
        <div class="col-xs-12">
        	<a class="btn btn-sm btn-success" onclick="allCkb('ckb')"><span class="glyphicon glyphicon-arrow-up"></span>全选</a>
            <a class="btn btn-sm btn-success" onclick="unAllCkb()"><span class="glyphicon glyphicon-ban-circle"></span>全不选</a>  选中项： 
            <button class="btn btn-sm btn-success" id="do_delete" onClick="javascript:form1.action='<?php echo base_url();?>user/delete_all';"><span class="glyphicon glyphicon-trash"></span>放入回收站</button> 
            <button class="btn btn-sm btn-success" id="do_export" onClick="javascript:form1.action='<?php echo base_url();?>user/export_all';"><span class="glyphicon glyphicon-share-alt"></span>导出Word</button>
        </div>
        </form>
        <div class="col-xs-offset-2 col-xs-8"><ul class="pagination"><?php  echo $links;?></ul></div>
    </div>
 	<script type="text/javascript"> 
	  	function allCkb(items){
		 	$('[class='+items+']:checkbox').attr("checked", true);
	  	}
	  	function unAllCkb(){
		 	$('[type=checkbox]:checkbox').attr('checked', false);
	  	}
  	</script>