    <div class="col-xs-8 my_post">
    	<div class="col-xs-12"><h4>提示：加入社团要根据自身的兴趣来选择，加入的社团数量不宜过多，1-3个内即可。</h4></div>
		<div class="col-xs-12"><h4>总共有：<?php echo $total_rows;?>条信息</h4></div>
        <div class="col-xs-12">
            <table class="table table-hover">
            	<tr class="success">
                	<th>序号</th>
                    <th>社团名称</th>
                    <th>申请时间</th>
                    <th>操作</th>
                </tr>
                <?php foreach ($result as $user_post){?>
                <tr>
                    <td><?php echo $user_post['pid'];?></td>
                    <td><?php echo $user_post['group_name'];?></td>
                    <td><?php echo $user_post['apply_time'];?></td>
                    <td>
                    	<a href="<?php echo base_url();?>user/readit?pid=<?php echo $user_post['pid'];?>" target="_blank">查看</a> 
                        <a href="<?php echo base_url();?>user/export_word?pid=<?php echo $user_post['pid'];?>" target="_blank">导出</a></td>
                </tr>    
				<?php };?>
            </table>
        </div>
        <div class="col-xs-offset-2 col-xs-8"><ul class="pagination"><?php  echo $links;?></ul></div>
    </div>
