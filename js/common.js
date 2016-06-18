   
    var CompareFirstLastLetter = function(newWord, oldWord)
    {
        newWord = newWord.charAt(0).toLowerCase();
        oldWord = (oldWord.charAt(oldWord.length - 1).toLowerCase() !== 'ь') ? oldWord.charAt(oldWord.length - 1).toLowerCase() : oldWord.charAt(oldWord.length - 2).toLowerCase();
        
        if (newWord === oldWord) {
            return true;
        } else {
            return false;
        }
    } 
   
    var LoadGameLog = function()
    {
	$.post(prefix + 'ajax/game-log', { mode: gameMode }, function(data) {
	    data = jQuery.parseJSON(data);
		
	    $('#gameLog').html('');
	    var str = '';
		
	    $.each(data, function(key, value) { str += ' - ' + key + '<sup>' + value + ' км.</sup>'; });
		
	    $('#gameLog').html(str.substring(3));
		
	});  
    }
    
   /*
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
    */
    
