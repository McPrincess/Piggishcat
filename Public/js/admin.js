function del(id,btn){
	var url=$('#tab').attr('delurl');
	var tr = $(btn).parents('tr');
	$.get(url,{'adn_id':id},function(data){
		if(data =='1'){
			alert('删除成功');
			tr.remove();
		}else{
			alert('删除失败!');
		}
	});
	// alert(url);
}

function test(id,btn)
      {
         var status = $(btn).html(); 
         var url = $('#savestatus').attr('saveual');
         if (status == '启用') {
              $.get(url,{'adn_id':id,'adn_status':1},function(data){
              	if (data == '1') {
              		alert('启用成功');
              		 // $(btn).html('禁用');
              	}
              });
         }
      }

function stu(id,btn)
      {
         var status = $(btn).html(); 
         var url = $('#savestatus').attr('saveual');
         if (status == '禁用') {
              $.get(url,{'adn_id':id,'adn_status':2},function(data){
              	if (data == '1') {
              		alert('禁用成功');
              		 // $(btn).html('禁用');
              	}
              });
         }
      }
