//删除友情连接
function del(id,btn){
	var url=$('#tab').attr('delurl');
	var tr = $(btn).parents('tr');
	$.get(url,{'bll_id':id},function(data){
		if(data =='1'){
			alert('删除成功');
			tr.remove();
		}else{
			alert('删除失败!');
		}
	});
}

//修改连接状态z
function action(id,btn){
	var url = $('#up').attr('Saveurl');
	console.log(url);
	var status = $(btn).parent().parent().parent().prev().prev().html();

	if(status == '停用'){
		$.get(url,{'bll_id':id,'bll_status':2},function(data){
			if(data =='1'){
			}
		});
		// 改变状态栏
		$(btn).parent().parent().parent().prev().prev().html('启用');
		//改变button的内容
		$(btn).html('停用');
		//套上span的背景样式
		$(btn).append("<span class='am-icon-pencil-square-o'>");

	}else if(status == '启用'){
		$.get(url,{'bll_id':id,'bll_status':1},function(data){
			if(data =='1'){
			}
		});
		// 改变状态栏
		$(btn).parent().parent().parent().prev().prev().html('停用');
		//改变button的内容
		$(btn).html('启用');
		//套上span的背景样式
		$(btn).append("<span class='am-icon-pencil-square-o'>");
	}
}
