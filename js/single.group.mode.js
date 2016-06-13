
var scoreTable = {};

var CitiesStack = {};

var BotNames = ["Bashful Bot", "Doc Bot", "Dopey Bot", "Grumpy Bot", "Happy Bot", "Sleepy Bot", "Sneezy Bot"]; 
var BotCounter = 0;

function ShowPlayersList()
{
     $('#PlayersListBox').html('');
        
    for(name in scoreTable)
    {
        $('#PlayersListBox').append("<tr><td width='8%' align='left' style='padding:3px;'><img src='" + prefix + "/images/icons/" + scoreTable[name].player_type + ".png' width='24' height='24'></td><td>" + name + "</td><td width='20%' align='center'>" + scoreTable[name].score + "</td><td width='8%' align='right' style='padding:3px;'><img src='" + prefix + "/images/icons/delete.png' width='24' height='24' style='cursor:pointer;' onClick='DetelePlayerFromList(\"" + name + "\");'></td></tr>");
    }
}
 
function AddBotToList()
{
    if (BotCounter < BotNames.length) {
        var playerName = BotNames[BotCounter];
        
        if (playerName in scoreTable) {
            BotCounter++;
            AddBotToList();
        } else {
            scoreTable[playerName] = { player_type:'ai', score:0 };
            BotCounter++;
            ShowPlayersList();
        }
    } else {
        alert("Пожалуй хватит! Пусть и для людей место останется.");
    } 
}
    
function DetelePlayerFromList(playerName)
{
    delete scoreTable[playerName];
    BotCounter = 0;
    ShowPlayersList();
}


$(function(){
    
    if (gameMode == 'single') {
        scoreTable.player = { player_type:'human', score:0 };
        scoreTable.comp = { player_type:'ai', score:0 };
    }

    $('#AddNewPlayerToScoreListButton').click(function() {
        var playerName = $('#PlayerName').val();
        
        if (!(playerName in scoreTable)) {
            scoreTable[playerName] = { player_type:'human', score:0 };
            ShowPlayersList();
        } else {
            alert("Игрок с именем " + playerName + " уже зарегистрирован.");
        }
        
    });
    
    
});