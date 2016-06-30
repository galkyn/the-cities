   
    var GetLastLetter = function(word)
    {
	return (word.charAt(word.length - 1).toLowerCase() === 'ь' || word.charAt(word.length - 1).toLowerCase() === 'ы') ? word.charAt(word.length - 2).toUpperCase() : word.charAt(word.length - 1).toUpperCase();
    }
   
    var CompareFirstLastLetter = function(newWord, oldWord)
    {
        newWord = newWord.charAt(0).toLowerCase();
        oldWord = GetLastLetter(oldWord);
        
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
    