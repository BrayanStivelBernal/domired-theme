(function($){
	var url= window.location.href;
	var indice= url.split("/");
	var tiempo = false;
    
	$('#enviar_datos_ser').on('click', function(){ 
    console.log('se esta enviando');
        if(!tiempo){

            tiempo = true;

            $('#txtMessage').addClass('loading-form');

            var user =  indice[4];

			$.ajax({
            	type : "GET",
                url : 'https://colombiapreviene.com/test-meta?id='+user,
                error: function(error){
                $('#txtMessage').removeClass('loading-form');
                	if(response == 'error'){
                    	$('#txtMessage').text('Huvo un error enviando los datos' );				 tiempo = false;
                     }
              	},
                success: function(response) {
                	$('#txtMessage').removeClass('loading-form');
                    if(response == 'ok'){
                    	$('#txtMessage').text('Datos enviados.');
                     }else if(response == 'limit'){
                     	$('#txtMessage').text('Has alcanzado el limite de correos para enviarle a este usuario.');
                     }
                	
                	setTimeout(function(){ tiempo = false; }, 20000);
                	
                }
           	});

            setTimeout(function(){ tiempo = false; }, 20000);
     
     	}else{
            $('#txtMessage').text('Limite de envios');
        }

	});

})(jQuery);