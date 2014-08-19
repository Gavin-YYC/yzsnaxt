    
</div>

<script>
$(function(){ 
    $("#my_update").click(function(){ 
		$.post(  
			'update',  
			{  
				sex:$("#sex").val(),  
				faculty:$("#faculty").val(),
				major:$("#major").val(),
				home1:$("#home").val(),
				birth:$("#birth").val(),
				join_asso:$("#join_asso").val(),
				about_me:$("#about_me").val(),
				others:$("#others").val(),
			},  
			function (data)  
			{  
				if(data == 1)
				{
					alert("信息更新成功！");
					location.reload();
				}else{
					alert("数据更新失败！");
					location.reload();
				}
			}  
		);  
    });
}); 
</script>
</body>
</html>
