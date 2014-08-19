    
</div>

<script>
$(function(){ 
    $("#set_group").click(function(){ 
		$.post(  
			'set_group', 
			{
				
			},
			function (data)  
			{  				
				if(data == 0){
					alert("创建失败！");
					location.reload();	
				}else if(data == 1){
					alert("请继续补充信息！");
					location.reload();	
				}
			}  
		);  
    });

    $("#my_update").click(function(){ 
		$.post(  
			'group_update',  
			{  
				group_name:$("#group_name").val(),  
				group_fromdata:$("#group_fromdata").val(),
				group_belong:$("#group_belong").val(),
				gid:$("#gid").val(),
				group_brief:$("#group_brief").val(),
				group_detail:$("#group_detail").val(),
				group_wide:$("#group_wide").val(),
				group_way:$("#group_way").val(),
				group_others:$("#group_others").val(),
			},
			function (data)  
			{  
				if(data == 0){
					alert("更新失败！");	
					location.reload();
				}else if(data == 1){
					alert("信息更新成功！");
					location.reload();	
				}
			}  
		);  
    });

}); 
</script>
</body>
</html>