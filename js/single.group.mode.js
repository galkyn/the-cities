$(document).ready( function() {
    
    if (gameMode == 'single') {
        scoreTable.player = { player_type:'human', score:0 };
        scoreTable.comp = { player_type:'ai', score:0 };
    }
   
    var countdown =  $("#countdown").countdown360({
        radius      : 50,
        seconds     : 30,
        strokeWidth : 5,
        fontColor   : '#FFFFFF',
        label       : ["сек"],
        smooth      : true,
        autostart   : false,
        onComplete  : function () { SkipStep(); }
    });
    
    //alert(countdown.settings.seconds);
     
    var scoreTable = {};
    
    var CitiesStack = {};
    
    var BotNames = ["Bashful Bot", "Doc Bot", "Dopey Bot", "Grumpy Bot", "Happy Bot", "Sleepy Bot", "Sneezy Bot"]; 
    var BotCounter = 0;
    
    var isGameCreated = 0;
    var LapCount = 0;
    var CurrentLap = 1;
    var StepTime = 0;
    var CurrentPlayer = '';
 
    var SkipStep = function()
    {
        alert("fooo");
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
    
    var AddBotToList = function()
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
    
    $('#AddBotToListButton').click(function() { AddBotToList(); });
    
    $(document).on('click', '.DelPlayerButton', function(event){
        var playerName = event.target.id;
        
        delete scoreTable[playerName];
        BotCounter = 0;
        ShowPlayersList();
        
    });

    $('#CreateGameButton').click(function() {
        LapCount = $('#LapCount').val();
        StepTime = $('#StepTime').val();
        countdown.settings.seconds = $('#StepTime').val();//Устанавливаем таймер обратного отсчета
        isGameCreated = 1;
            
        $('.DelPlayerButton').each(function() {
            $(this).hide();
        });
            
        for(player in scoreTable)
        {
            scoreTable[player]['lap_count'] = 1;
        }
            
        $('#CreateGameForm').hide();
            
        $('#CurrentPlayerIndicator').text("Запуск игры, приготовьтесь.");
            
        setTimeout(GameProceed, 3000);
            
    });

    var ShowPlayersList = function()
    {
        $('#PlayersListBox').html("<tr><td colspan='4' style='background:#1A4C6D; color:#fff; text-align:center; padding:1%; border-radius: 3px;'><strong>Список игроков</strong></td></tr>");
            
        for(name in scoreTable)
        {
            $('#PlayersListBox').append("<tr><td width='8%' align='left' style='padding:3px;'><img src='" + prefix + "/images/icons/" + scoreTable[name].player_type + ".png' width='24' height='24'></td><td width='72%'>" + name + "</td><td width='20%' align='center'>" + scoreTable[name].score + "</td><td align='right'><img src='" + prefix + "/images/icons/delete.png' width='24' height='24' style='cursor:pointer;' class='DelPlayerButton' id='" + name + "'></td></tr>");
        }
    }
    
    var GameProceed = function()
    {
        if (LapCount == 0) { LapCount = 1000000; }
        
        if (CurrentLap <= LapCount) {
            for(player in scoreTable)
            {
                if (scoreTable[player].lap_count == CurrentLap) {
                    
                    $('#CurrentPlayerIndicator').text("Отвечает: " + player);
                    $('#CurrentLapIndicator').text(scoreTable[player].lap_count);
                    countdown.start();
                }
            }
        }
        
    }

});