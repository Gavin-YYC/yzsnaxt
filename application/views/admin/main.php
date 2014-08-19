        <!--left-->
        <div class="col-xs-7">
        	
        	<div class="alert alert-success shadow" role="alert"><b><?php echo $alertTitle;?></b></div>
            
            <!--新生用户面板-->
        	<div class="panel panel-info" id="shadow1">
            	<div class="panel-heading">
              		<h3 class="panel-title">新生用户</h3>
            	</div>
            	<div class="panel-body">
                	<table class="table table-hover">
                    	<tr>
                        	<?php foreach ($all_newuser as $all_user){if(date("Y-m-d") == date("Y-m-d",strtotime($all_user['reg_time']))) $timeCount +=1;};?>
                        	<td>今日新生注册人数：<?php echo $timeCount;?></td>
                            <td>总新生注册人数：<?php echo $userNum-$PowerUserNum-$noPowerUserNum;?></td>
                        </tr>
                    	<tr>
                            <td>总提交申请数：<?php echo $postNum;?></td>
                            <td>人均提交申请数：<?php echo round($postNum/$userNum,2);?></td>
                        </tr>
                    </table>
            	</div>
          	</div>
            
            <!--社团用户面板-->
        	<div class="panel panel-danger" id="shadow2">
            	<div class="panel-heading">
              		<h3 class="panel-title">社团用户</h3>
            	</div>
            	<div class="panel-body">
                	<table class="table table-hover">
                    	<tr>
                        	<?php foreach ($all_group as $all_group){if(date("Y-m-d") == date("Y-m-d",strtotime($all_group['set_time']))) $groupCount +=1;};?>
                            <?php foreach ($PowerUser as $PowerUser){if(date("Y-m-d") == date("Y-m-d",strtotime($PowerUser['check_time']))) $todayCheck +=1;};?>
                        	<td>今日开通社团数：<?php echo $groupCount;?></td>
                            <td>总开通社团数：<a href="#"><?php echo $groupNum;?></a></td>
                        </tr>
                    	<tr>
                            <td>总收到申请数：<?php echo $postNum;?></td>
                            <td>平均一个社团获得申请数：<?php if($postNum=="0"||$groupNum=="0") echo "0";else echo round($postNum/$groupNum,2);?></td>
                        </tr>
                        <tr>
                            <td>社团负责人审核通过：<a href="<?php echo base_url();?>youth_admin/groupManager"><span class="badge"><?php echo $PowerUserNum;?></span></a></td>
                            <td>社团负责人待审核：<a href="<?php echo base_url();?>youth_admin/check"><span class="badge"><?php echo $noPowerUserNum;?></span></a></td>
                        </tr>
                        <tr>
                        	<td>今日审核：<?php echo $todayCheck;?></td>
                        	<td></td>
                        </tr>
                    </table>
            	</div>
          	</div>
        </div>
    </div>