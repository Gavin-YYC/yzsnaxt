        <!--left-->
        <div class="col-xs-7">
        	
        	<div class="alert alert-success shadow" role="alert"><b><?php echo $alertTitle;?></b></div>
            
            <!--新生用户面板-->
        	<div class="panel panel-info" id="shadow1">
            	<div class="panel-heading">
              		<h3 class="panel-title">可以设置的信息有：（提示：请可以使用html标签进行排版！）</span></h3>
            	</div>
            	<div class="panel-body">
                	<div class="col-xs-12"><span class="tips4"></span></div>
					<div class="col-xs-12 mainLeft"><button class="btn btn-block" id="groupStyleInfo">社团类型简介</button></div>
                    <div class="col-xs-12 mainLeft" style="display:none" id="addAdminAera1">
                        <textarea class="col-xs-12" id="styleAera">
                        <?php  foreach($message as $message){
                            if($message['content']!="") 
                                echo $message['content']; 
                            else 
                                echo "还没有任何内容！";
                        }?>
                        </textarea>
                    	<button class="btn btn-block btn-info" id="goupStyleBtn">提交</button>
                    </div>
                    <div class="col-xs-12 mainLeft"><button class="btn btn-block" id="exportWord">导出word备注</button></div>
                    <div class="col-xs-12 mainLeft" style="display:none" id="addAdminAera2"><textarea class="col-xs-12" id="exportAera">
                    <?php  foreach($message1 as $message){
						if($message['content']!="") 
							echo $message['content']; 
						else 
							echo "还没有任何内容！";
					}?>
                    </textarea>
                    	<button class="btn btn-block btn-info" id="exportWordBtn">提交</button>
                    </div>
            	</div>
          	</div>
        </div>
    </div>
    
    <script>
    $(document).ready(function() {
		$("#goupStyleBtn").click(function(){
			var content = $("#styleAera").val();
			$.post(  
				'<?php echo base_url();?>youth_admin/updateMessage?id=1',  
				{  
					content:$("#styleAera").val(), 
				},
				function (data)  
				{  	
					if(data == 0) $(".tips4").html("<b>*更新失败，出现错误！</b>");
					if(data == 1) $(".tips4").html("<b>*修改成功！</b>");
				}  
			);
		});
		$("#exportWordBtn").click(function(){
			var content = $("#exportAera").val();
			$.post(  
				'<?php echo base_url();?>youth_admin/updateMessage?id=2',  
				{  
					content:$("#exportAera").val(), 
				},
				function (data)  
				{  	
					if(data == 0) $(".tips4").html("<b>*更新失败，出现错误！</b>");
					if(data == 1) $(".tips4").html("<b>*修改成功！</b>");
				}  
			);
		});
    });
    </script>
