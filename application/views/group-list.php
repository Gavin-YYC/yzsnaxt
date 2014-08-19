
    <!--左侧导航-->
    <div class="row banner col-xs-4">
        <div class="col-xs-offset-3 col-xs-9">
            <div class="row bt"><div class="col-xs-12 bt1"><a href="#" class="btn btn-block btn-lg"><span class="glyphicon glyphicon-pencil"></span> 理论学习型</a></div></div>
            <div class="row bt"><div class="col-xs-12 bt2"><a href="#" class="btn btn-block btn-lg btn-success"><span class="glyphicon glyphicon-hdd"></span> 学术科技型</a></div></div>
            <div class="row bt"><div class="col-xs-12 bt3"><a href="#" class="btn btn-block btn-lg btn-primary"><span class="glyphicon glyphicon-heart-empty"></span> 社会公益型</a></div></div>
            <div class="row bt"><div class="col-xs-12 bt4"><a href="#" class="btn btn-block btn-lg btn-info"><span class="glyphicon glyphicon-screenshot"></span> 兴趣爱好型</a></div></div>
            <div class="row bt"><div class="col-xs-12 bt5"><a href="#" class="btn btn-block btn-lg btn-danger"><span class="glyphicon glyphicon-comment"></span> 社团类型简介</a></div></div>
        </div>
    </div>
    <!--右侧社团列表-->
	<div class="rap col-xs-8">
    	
        <div class="option1">
			<div class="btn btn-block btn-lg">社团列表——理论学习型</div>
            <div class="list">
            	<ul>
                <?php foreach ($group1 as $group_list){?>
                    <li class="col-xs-12 list-li"><?php echo $group_list['group_name'];?></li>
                    <div class="col-xs-12 list-hide">简介：<?php echo $group_list['group-brief'];?><br>
						<a href="<?php echo base_url();?>user/join?group_id=<?php echo $group_list['group_id'];?>" class="btn btn-block btn-lg">立即报名</a>
                    </div>
                <?php };?>
                </ul>
            </div>
        </div>    
        <div class="option2">
			<div class="btn btn-block btn-lg btn-success">社团列表——学术科技型</div>
            <div class="list">
            	<ul>
                <?php foreach ($group2 as $group_list){ ;?>
                    <li class="col-xs-12 list-li"><?php echo $group_list['group_name'];?></li>
                    <div class="col-xs-12 list-hide">简介：<?php echo $group_list['group-brief'];?>
                    	<a href="<?php echo base_url();?>user/join?group_id=<?php echo $group_list['group_id'];?>" class="btn btn-block btn-lg">立即报名</a>
                    </div>
                <?php };?>
                </ul>
            </div>
        </div>
        <div class="option3">
            <div class="btn btn-block btn-lg btn-primary">社团列表——社会公益型</div>
            <div class="list">
            	<ul>
                <?php foreach ($group3 as $group_list){ ;?>
                    <li class="col-xs-12 list-li"><?php echo $group_list['group_name'];?></li>
                    <div class="col-xs-12 list-hide">简介：<?php echo $group_list['group-brief'];?>
                    	<a href="<?php echo base_url();?>user/join?group_id=<?php echo $group_list['group_id'];?>" class="btn btn-block btn-lg">立即报名</a>
                    </div>
                <?php };?>
                </ul>
            </div>
        </div>
        <div class="option4">
			<div class="btn btn-block btn-lg btn-info">社团列表——兴趣爱好型</div>
            <div class="list">
            	<ul>
                <?php foreach ($group4 as $group_list){?>
                    <li class="col-xs-12 list-li"><?php echo $group_list['group_name'];?></li>
                    <div class="col-xs-12 list-hide">简介：<?php echo $group_list['group-brief'];?>
                    	<a href="<?php echo base_url();?>user/join?group_id=<?php echo $group_list['group_id'];?>" class="btn btn-block btn-lg">立即报名</a>
                    </div>
                <?php };?>
                </ul>
            </div>
        </div>
        <div class="option5">
			<div class="btn btn-block btn-lg btn-danger">社团简介</div>
            <div class="list">
            	<?php echo $groupStyleBrief[0]['content'];?>
            </div>
        </div>
        
        
        
    </div>
</div>
</body>
</html>
