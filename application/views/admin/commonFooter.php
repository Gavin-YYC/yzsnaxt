    
    <!--底部-->
    <div class="row footer">
    	
    </div>

</div>
<script type="text/javascript"> 
	function allCkb(items){
		$('[class='+items+']:checkbox').attr("checked", true);
	}
	function unAllCkb(){
		$('[type=checkbox]:checkbox').attr('checked', false);
	}
	 function delcfm(data) { 
		if (!confirm(data)) { 
			window.event.returnValue = false; 
		} 
	} 
</script>
</body>
</html>