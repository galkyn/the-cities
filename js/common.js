$(function(){
   
    function LoadGameLog() {
        
        $.post(prefix + 'ajax/game-log', function(data) {
            data = jQuery.parseJSON(data);
            
            $('#gameLog').html('');
            
            $.each(data, function(key, value) {
                $('#gameLog').append(' - ' + key + '<sup>' + value + ' км.</sup>');
            });
            
        }); 
        
    }
   
    $('#SendAnswerButton').click(function(){
        
        $.post(prefix + 'ajax/step', { answer: $('#CityNameInput').val(), letter: $('#CheckLetterInput').val() }, function(data){
	    data = jQuery.parseJSON(data);
            $('#CityNameInput').val(data.letter);
            $('#CheckLetterInput').val(data.letter);
            $('#debug').html(data.message + " : " + data.error);
            LoadGameLog();
	});
        
    });
    
    $('#SkipAnswerButton').click(function(){
        
        $.post(prefix + 'ajax/ai-turn', { answer: $('#CityNameInput').val(), letter: $('#CheckLetterInput').val() }, function(data){
	    data = jQuery.parseJSON(data);
            $('#CityNameInput').val(data.letter);
            $('#CheckLetterInput').val(data.letter);
            $('#debug').html(data.message + " : " + data.error);
            LoadGameLog();
	});
        
    });
    
    LoadGameLog();
    
});