
    <div class="col-xs-8 my_details">
        <?php foreach ($user_detail as $user_details){?>
        	<div class="col-xs-12 my_detail_1">
				<div class="col-xs-6">姓名：<?php echo $user_details['name'];?></div>
                <div class="col-xs-6">电话：<?php echo $user_details['tel'];?></div>
            </div>
            <div class="col-xs-12 my_detail_1">
            	<div class="col-xs-6">学院：<input type="text" id="faculty" value="<?php echo $user_details['faculty'];?>" required="required"/></div>
            	<div class="col-xs-6">班级：<input type="text" id="major" value="<?php echo $user_details['major'];?>" required="required"/></div>
            </div>
            <div class="col-xs-12 my_detail_1">
            	<div class="col-xs-6">家乡：<input type="text" id="home" value="<?php echo $user_details['home'];?>" required="required"/></div>
            	<div class="col-xs-6">性别：<input type="text" id="sex" value="<?php echo $user_details['sex'];?>" required="required"/></div>
            </div>
            <div class="col-xs-12"><div class="col-xs-12">生日：<input type="text" id="birth" value="<?php echo $user_details['birth'];?>" required="required"/></div></div>
            <div class="col-xs-12"><div class="col-xs-12 my_detail_1">申请职务：</div></div>
            <div class="col-xs-12"><div class="col-xs-12 group_jianjie"><textarea id="join_asso" class="col-xs-12"><?php echo $user_details['join_asso'];?></textarea></div></div>
            <div class="col-xs-12"><div class="col-xs-12 my_detail_1">自我介绍：</div></div>
            <div class="col-xs-12"><div class="col-xs-12 group_jianjie"><textarea id="about_me" class="col-xs-12"><?php echo $user_details['about_me'];?></textarea></div></div>
            <div class="col-xs-12"><div class="col-xs-12 my_detail_1">其他信息：</div></div>
            <div class="col-xs-12"><div class="col-xs-12 group_jianjie"><textarea id="others" class="col-xs-12"><?php echo $user_details['others'];?></textarea></div></div>
            <div class="col-xs-12"><button class="btn btn-block btn-lg btn-success" id="my_update">更新</button></div>
		<?php }?>
    </div>
