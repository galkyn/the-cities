$(function(){
   
    function LoadGameLog() {
        
        $.post('ajax/game-log', function(data) {
            data = jQuery.parseJSON(data);
            
            $('#gameLog').html('');
            
            $.each(data, function(key, value) {
                $('#gameLog').append(' - ' + key + '<sup>' + value + ' км.</sup>');
            });
            
        }); 
        
    }
   
    $('#SendAnswerButton').click(function(){
        
        $.post('ajax/step', { answer: $('#CityNameInput').val(), letter: $('#CheckLetterInput').val() }, function(data){
	    data = jQuery.parseJSON(data);    
            $('#debug').html(data.message + " : " + data.error);
            LoadGameLog();
	});
        
    });
    
    $('#SkipAnswerButton').click(function(){
        
        $.post('ajax/ai-turn', { answer: $('#CityNameInput').val(), letter: $('#CheckLetterInput').val() }, function(data){
	    data = jQuery.parseJSON(data);    
            $('#debug').html(data.message + " : " + data.error);
            LoadGameLog();
	});
        
    });
    
    LoadGameLog();
    
});