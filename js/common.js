$(function(){
   
    $('#SendAnswerButton').click(function(){
        
        $.post('ajax/ai-turn', { answer: $('#CityNameInput').val(), letter: $('#CheckLetterInput').val() }, function(data){
	    //data = jQuery.parseJSON(data);    
            $('#debug').html(data);  
	});
        
    });
    
});