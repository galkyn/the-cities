$(function(){
   
    function CheckLetter() {
	
	if ($('#CheckLetterInput').val() == '_NA_') {
	    return true;
	} else {
	    var UserLetter = $('#CityNameInput').val().charAt(0);
	    if (UserLetter == $('#CheckLetterInput').val()) {
		return true;
	    } else {
		return false;
	    }
	}
	
	
    }   
   
    function LoadGameLog() {
        
	    $.post(prefix + 'ajax/game-log', { mode: gameMode }, function(data) {
		data = jQuery.parseJSON(data);
		
		$('#gameLog').html('');
		var str = '';
		
		$.each(data, function(key, value) { str += ' - ' + key + '<sup>' + value + ' км.</sup>'; });
		
		$('#gameLog').html(str.substring(3));
		
	    }); 
        
    }
   
    $('#SendAnswerButton').click(function(){
        
	if (CheckLetter) {
	    $.post(prefix + 'ajax/step', { mode: gameMode, answer: $('#CityNameInput').val(), letter: $('#CheckLetterInput').val() }, function(data){
		data = jQuery.parseJSON(data);
		$('#CityNameInput').val(data.letter);
		$('#CheckLetterInput').val(data.letter);
		$('#debug').html(data.message + " : " + data.error);
		LoadGameLog();
	    });
	}
    });
    
    $('#SkipAnswerButton').click(function(){
        
        $.post(prefix + 'ajax/ai-turn', { mode: gameMode, answer: $('#CityNameInput').val(), letter: $('#CheckLetterInput').val() }, function(data){
	    data = jQuery.parseJSON(data);
            $('#CityNameInput').val(data.letter);
            $('#CheckLetterInput').val(data.letter);
            $('#debug').html(data.message + " : " + data.error);
            LoadGameLog();
	});
        
    });
    
    LoadGameLog();
    
});