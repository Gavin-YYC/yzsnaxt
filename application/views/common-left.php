
<style>
.my_info{margin-top:30px;}
.my_info_def{margin-bottom:20px;}
.my_details,.my_post{margin-top:30px; border-left:1px solid #CCC;}
h4{color:red; border-bottom:1px solid #ccc}
.imgupload{margin:10px;}
.img{max-height:300px; max-width:300px;}
</style>
	<?php foreach ($user_detail as $user_details){?>
    <div class="col-xs-4 my_info">
    	<div class="col-xs-offset-1 col-xs-10">
        	<div class="alert alert-danger" role="alert">
            	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                点击图片，更改个人照片或社团标志.
            </div>
        </div>
        <div class="col-xs-offset-3 col-xs-6 my_info_def"><img id="mylogo" src="<?php 
		if($user_details['user_logo']==""){
			echo base_url().'source/uploads/defaultpic.jpg';	
		}else{
			echo base_url().'source/uploads/'.$user_details['user_logo']; 
		}
		?>" class="img-responsive" /></div>
        <div class="col-xs-offset-1 col-xs-10 my_info_def"><a href="<?php echo base_url();?>user/info" class="btn btn-block btn-lg"><span class="glyphicon glyphicon-cog"></span> 基本信息</a></div>
        <div class="col-xs-offset-1 col-xs-10 my_info_def"><a href="<?php echo base_url();?>user/myletters" class="btn btn-block btn-lg"><span class="glyphicon glyphicon-envelope"></span> 我的信箱</a></div>
    	<div class="col-xs-offset-1 col-xs-10 my_info_def"><a href="<?php echo base_url();?>user/recycle" class="btn btn-block btn-lg"><span class="glyphicon glyphicon-trash"></span> 回收站</a></div>
    </div>
	<?php }?>
	<!--隐藏modal-->
    <div class="modal fade bs-example-modal-lg" id="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      	<div class="modal-dialog modal-lg">
        	<div class="modal-content">
          		<div class="imgupload">
                	<div class="alert alert-danger" role="alert">注意：个人证件照尺寸：100*131，社团标志：200*200，请自行调整。</div>
                    <div class="alert alert-danger" role="alert">注意：图片允许格式为：jpg、jpeg、png、gif，且图片大小小于300KB。</div>
                    <form action="<?php echo base_url();?>user/upload" method="post" enctype="multipart/form-data">
						<input type="file" name="image" class="col-xs-12 my_info_def alert alert-info" id="img_file" required="required"/> 
                    	<input type="submit" name="upload" value="立即上传" class="btn btn-block my_info_def" id="img_btn" />
                    </form>
                </div>
        	</div>
      	</div>
    </div>
<script>
$(document).ready(function() {
    $("#mylogo").click(function(){
		$('#modal').modal('show');	
	});
});
</script>