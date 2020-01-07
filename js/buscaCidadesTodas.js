$(function() {    
    $("#cidadeResidencia").keyup(function(){
    	var cidadeDigitada = $(this).val();
    	if(cidadeDigitada != ''){
    		$.ajax({
    			url: 'DAO/banco-cidades-post.php',
    			method: 'post',
    			data: {cidade:cidadeDigitada, funcao: 2},

    			success: function(response){
    				$("#show-list").html(response);
    			}
    		});
    	}
    	else
    	{
    		$("#show-list").html('');
    	}
    	$(document).on('click', 'a', function(){
    		$("#cidadeResidencia").val($(this).text());
    		$("#show-list").html('');
    	});
    })
})