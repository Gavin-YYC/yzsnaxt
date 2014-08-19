$(document).ready(function(){
	<!--选项卡切换-->
	$(".bt1").click(function(){
		$(".option1").show();
		$(".option2").hide();
		$(".option3").hide();
		$(".option4").hide();
		$(".option5").hide();
	});
	$(".bt2").click(function(){
		$(".option2").show();
		$(".option1").hide();
		$(".option3").hide();
		$(".option4").hide();
		$(".option5").hide();
	});
	$(".bt3").click(function(){
		$(".option3").show();
		$(".option2").hide();
		$(".option1").hide();
		$(".option4").hide();
		$(".option5").hide();
	});
	$(".bt4").click(function(){
		$(".option4").show();
		$(".option2").hide();
		$(".option3").hide();
		$(".option1").hide();
		$(".option5").hide();
	});
	$(".bt5").click(function(){
		$(".option5").show();
		$(".option2").hide();
		$(".option3").hide();
		$(".option1").hide();
		$(".option4").hide();
	});
	$(".list-li").click(function(){
		$(this).next(".list-hide").slideToggle();	
	});
	
	$(".group_text").mouseover(function(){
		$(this).css("background-color","#98bf21");	
	});
	$(".group_text").mouseout(function(){
		$(this).css("background-color","#fff");	
	});
	
	$("#shadow1,#shadow2").mouseover(function(){
		$(this).addClass("shadow");	
	});
	$("#shadow1,#shadow2").mouseout(function(){
		$(this).removeClass("shadow");	
	});
	
	$("#addBtn").click(function(){
		$("#addAdminAera").slideToggle();	
	});
	
	$("#groupStyleInfo").click(function(){
		$("#addAdminAera1").slideToggle();	
	});
	
	$("#exportWord").click(function(){
		$("#addAdminAera2").slideToggle();	
	});

	
	//前台搜索功能
    $("#sub-key").click(function(){ 
		var keyword = $("#keyworld").val();
		if(keyword==""){
			$(".tips-search").html('<div class="panel panel-success"><span class="glyphicon glyphicon-warning-sign"></span>  输入为空！</div>');	
		}else{
			$.post(  
				'/user/search',  
				{  
					keyword:$("#keyworld").val(), 
				},
				function (data)  
				{  	
					var objdata = eval("("+data+")");
					var html = ('');
					if(objdata.length == 0){
						html = ('<span class="glyphicon glyphicon-warning-sign"></span>  没有找到！');	
					}else{
						for(var i=0;i<objdata.length;i++){
							html += '<span class="glyphicon glyphicon-play"></span><a href="/user/join?group_id='+objdata[i]["group_id"]+'">'+objdata[i]["group_name"]+'  </a>';
						}
					}
					$(".tips-search").html('<div class="panel panel-success">'+html+'</div>');
				}  
			); 
		} 
    });
	//添加管理员
    $("#sub-key2").click(function(){ 
		var keyword = $("#keyworld").val();
		if(keyword==""){
			$(".tips-search").html('<div class="panel panel-success"><span class="glyphicon glyphicon-warning-sign"></span>  输入为空！</div>');	
		}else{
			$.post(  
				'/youth_admin/search',  
				{  
					keyword:$("#keyworld").val(), 
				},
				function (data)  
				{  	
					var objdata = eval("("+data+")");
					var html = ('');
					if(objdata.length == 0){
						html = ('<span class="glyphicon glyphicon-warning-sign"></span>  没有找到！');	
					}else{
						for(var i=0;i<objdata.length;i++){
							if(objdata[i]["reg_style"]=="0"){
								html += '<span class="glyphicon glyphicon-play"></span>【个人】<a href="/user/join?group_id='+objdata[i]["uid"]+'">'+objdata[i]["name"]+'  </a>';
							}else{
								if(objdata[i]["name"]==keyword){
									html += '<span class="glyphicon glyphicon-play"></span>【社团负责人】<a href="/CodeIgniter_2.2.0/user/join?group_id='+objdata[i]["uid"]+'">'+objdata[i]["name"]+'  </a>';
								}else{
									html += '<span class="glyphicon glyphicon-play"></span>【社团名称】<a href="/CodeIgniter_2.2.0/user/join?group_id='+objdata[i]["uid"]+'">'+objdata[i]["group_name"]+'  </a>';
								}
							}
						}
					}
					$(".tips-search").html('<div class="panel panel-success">'+html+'</div>');
				}  
			); 
		} 
    });

});
