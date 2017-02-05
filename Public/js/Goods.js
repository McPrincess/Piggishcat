//删除友情连接
function del(id,btn){
	var url=$('#tab').attr('delurl');
	var tr = $(btn).parents('tr');
	$.get(url,{'gos_id':id},function(data){
		if(data =='1'){
			alert('删除成功');
			tr.remove();
		}else{
			alert('删除失败!');
		}
	});
}
