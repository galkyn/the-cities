
var scoreTable = {};

var CitiesStack = {};

$(function(){
    
    if (gameMode == 'single') {
        scoreTable.player = { player_type:'human', score:0 };
        scoreTable.comp = { player_type:'ai', score:0 };
    }

    $('#AddNewPlayerToScoreListButton').click(function() {
        var playerName = $('#PlayerName').val();
        
        scoreTable[playerName] = { player_type:'human', score:0 }
        
        ShowPlayersList();
        
    });
    
    
    function ShowPlayersList()
    {
        $('#PlayersListDiv').html('');
        
        for(name in scoreTable)
        {
            $('#PlayersListDiv').append(name + ' - ' + scoreTable[name].player_type + ' - ' + scoreTable[name].score + '<br>');
        }
    }
    
});