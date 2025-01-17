$(document).ready(function(){
	var totalPage = parseInt($('#totalPages').val());	
	console.log("==totalPage=="+totalPage);
	var pag = $('#pagination').simplePaginator({
		totalPages: totalPage,
		maxButtonsVisible: 5,
		currentPage: 1,
		nextLabel: 'Next',
		prevLabel: 'Prev',
		firstLabel: 'First',
		lastLabel: 'Last',
		clickCurrentPage: true,
		pageChange: function(page) {			
			$("#content1").html('<tr><td colspan="6"><strong>loading...</strong></td></tr>');
            $.ajax({
				url:"ajax-dept-list.php",
				method:"POST",
				dataType: "json",		
				data:{page:	page},
				success:function(responseData){
					$('#content1').html(responseData.html);
				}
			});
		}
	});
});
