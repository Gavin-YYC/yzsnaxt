
    
    <?php if($msg == "0"){;?>
    <div class="col-xs-8 my_info">
        <div class="col-xs-8"><button class="btn btn-lg btn-block" id="set_group">+点击创建社团</button></div>
    </div>
    <?php }else{;?>
    <div class="col-xs-8 my_details">
    	<div class="col-xs-12"><h4>提示：请认真填写下列信息，每项必填。</h4></div>
        <?php foreach ($group_post as $group_post){?>
        	<div class="col-xs-12 my_detail_1">
				<div class="col-xs-6">社团名称：<input type="text" id="group_name" value="<?php echo $group_post['group_name'];?>" /></div>
                <div class="col-xs-6">创建时间：<input type="text" id="group_fromdata" value="<?php echo $group_post['group-fromdata'];?>" /></div>
            </div>
            <div class="col-xs-12">
            	<div class="col-xs-12">隶属部门：<input type="text" id="group_belong" value="<?php echo $group_post['group-belong'];?>" required="required"/></div>
            </div>
            <div class="col-xs-12">
				<div class="col-xs-12">所属类型：
                	<select id="gid" class="form-control">
               			<option value="1">理论学习型</option>
                        <option value="2">学术科技型</option>
                        <option value="3">社会公益型</option>
                        <option value="4">兴趣爱好型</option>
                    </select>
                </div>
                <script>document.getElementById("gid").value=<?php echo $group_post['gid'];?></script>
            </div>
            <div class="col-xs-12"><div class="col-xs-12 my_detail_1">社团简介：</div></div>
            <div class="col-xs-12"><div class="col-xs-12 group_jianjie"><textarea id="group_brief" class="col-xs-12"><?php echo $group_post['group-brief'];?></textarea></div></div>
            <div class="col-xs-12"><div class="col-xs-12 my_detail_1">详细介绍：</div></div>
            <div class="col-xs-12"><div class="col-xs-12 group_jianjie"><textarea id="group_detail" class="col-xs-12"><?php echo $group_post['group-detail'];?></textarea></div></div>
            <div class="col-xs-12"><div class="col-xs-12 my_detail_1">纳新范围：</div></div>
            <div class="col-xs-12"><div class="col-xs-12 group_jianjie"><textarea id="group_wide" class="col-xs-12"><?php echo $group_post['group_wide'];?></textarea></div></div>
            <div class="col-xs-12"><div class="col-xs-12 my_detail_1">报名方式：</div></div>
            <div class="col-xs-12"><div class="col-xs-12 group_jianjie"><textarea id="group_way" class="col-xs-12"><?php echo $group_post['group_way'];?></textarea></div></div>
            <div class="col-xs-12"><div class="col-xs-12 my_detail_1">其他信息：</div></div>
            <div class="col-xs-12"><div class="col-xs-12 group_jianjie"><textarea id="group_others" class="col-xs-12"><?php echo $group_post['group_others'];?></textarea></div></div>
            <div class="col-xs-12"><button class="btn btn-block btn-lg btn-success" id="my_update">更新</button></div>
		<?php }?>
    </div>
    <?php };?>
