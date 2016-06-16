$(function(){
    
    if (gameMode == 'single') {
        scoreTable.player = { player_type:'human', score:0 };
        scoreTable.comp = { player_type:'ai', score:0 };
    }
   
    var countdown;
    
    //alert(countdown.settings.seconds);
     
    var scoreTable = {};
    var scoreTableCount = 0;
    
    var citiesStack = {
        "Москва" : 1238,
        "Армавир" : 2538,
        "Рыбинск" : 2838,
        "Калина" : 4238
    };
    
    var BotNames = ["Bashful Bot", "Doc Bot", "Dopey Bot", "Grumpy Bot", "Happy Bot", "Sleepy Bot", "Sneezy Bot"]; 
    var BotCounter = 0;
    
    var isGameCreated = 0;
    var LapCount = 0;
    var CurrentLap = 1;
    var StepTime = 0;
    var CurrentPlayer = '';
    var CurrentPlayerCount = 0;
    
    var TopPlayerName = '';
    var TopPlayerScore = 0;
 
    var countdownComplete = function(unit, value, total){
        if(total<=0){
            $(this).fadeOut(800).replaceWith("<h2>Time's Up!</h2>");
        }
    }
 
    var CreateCountDown = function()
    {
        
        var timer = StepTime + 1;
        
        $("#countdown").attr('data-timer', timer); 
        
        countdown = $("#countdown").TimeCircles({
            "start": false,
            "animation": "smooth",
            "bg_width": 0.6,
            "fg_width": 0.05,
            "circle_bg_color": "#60686F",
            "total_duration": timer,
            "count_past_zero": false,
            "time": {
                "Days": { "show": false },
                "Hours": { "show": false },
                "Minutes": { "show": false },
                "Seconds": {
                    "text": "сек",
                    "color": "#99CCFF",
                    "show": true
                }
            }
        });
        
        countdown.addListener(countdownComplete);
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
    
    
    
    /*
     * 1. Проверка на совпадение букв: первая = последняя - done
     * 2. Проверка на наличие в стеке
     * 3. Проверка в БД, наличие города
     * 4. Рассчет расстояния
     */
    var ProceedAnswer = function()
    {
        countdown.stop();
        
        var newCity = $('#CityNameInput').val();
        var lastCity = $('#LastCityInput').val();
        
        if (lastCity !== '_NA_') {
            if(!CompareFirstLastLetter(newCity, lastCity)){
                alert("Не пойдет! Вы должны назвать город, начинающийся на букву: '" + lastCity.charAt(lastCity.length - 1).toUpperCase() + "'");
                countdown.start();
            } else {
                if (newCity in citiesStack) {
                    alert("Город " + newCity + " не так давно называл один из участников");
                    countdown.start();
                } else {
                    
                    $.post(prefix + 'ajax/check-city', { mode: gameMode, nCity: newCity, lCity: lastCity }, function(data){
                        data = jQuery.parseJSON(data);
                        for(name in data)
                        {
                            $('#debug').append(name + " - " + data[name] + "<br>");
                        }
                    });
                                
                }
            }
        }
        
    }
    
    //Возвращает случайное число в диапазоне от min до max
    var getRandomInt = function (min, max) {
        return Math.floor(Math.random() * (max - min)) + min;
    }
    
    //Прибавляем игроку отвеченный круг - ход переходит к следующему. Очки не начисляются, город не меняется
    var SkipAnswer = function()
    {
        scoreTable[CurrentPlayer].lap_count++;
        ShowPlayersList();
        ProceedGame();
    }
    
    $('#AddBotToListButton').click(function() { AddBotToList(); });
    $('#SendAnswerButton').click(function() { ProceedAnswer(); });
    $('#SkipAnswerButton').click(function() { SkipAnswer(); });
    
    $(document).on('click', '.DelPlayerButton', function(event){
        var playerName = event.target.id;
        
        delete scoreTable[playerName];
        scoreTableCount--;
        BotCounter = 0;
        ShowPlayersList();
        
    });

    $('#CreateGameButton').click(function() {
        LapCount = parseInt($('#LapCount').val());
        if (LapCount == 0) { LapCount = 1000000; }
        
        StepTime = parseInt($('#StepTime').val());
        isGameCreated = 1;
            
        $('.DelPlayerButton').each(function() {
            $(this).hide();
        });
            
        for(player in scoreTable)
        {
            scoreTable[player]['lap_count'] = 1;
            scoreTableCount++;
        }
            
        $('#CreateGameForm').hide();
            
        $('#CurrentPlayerIndicator').text("Запуск игры, приготовьтесь.");
            
        CreateCountDown();
            
        setTimeout(ProceedGame, 3000);
            
    });

    var ProceedGame = function()
    {
        
        if (CurrentPlayerCount == scoreTableCount) {
            CurrentLap++;
            CurrentPlayerCount = 0;
        }
        
        if (CurrentLap <= LapCount) {
            
            for(player in scoreTable)
            {
                
                //alert("Player: " + player + " Lap: " + scoreTable[player].lap_count);
                
                if (scoreTable[player].lap_count <= CurrentLap) {
                    
                    CurrentPlayer = player;
                    CurrentPlayerCount++;
                    
                    //alert(CurrentPlayer + " - " + scoreTable[CurrentPlayer].lap_count);
                    $('#CurrentPlayerIndicator').text("Отвечает: " + player);
                    $('#CurrentLapIndicator').text(scoreTable[player].lap_count);
                    break;
                } else {
                    continue;
                }
            }
            
            if (CurrentLap == 0) { countdown.start(); }
            else { countdown.restart(); }
            
        } else {
            
            countdown.destroy();
            $("#countdown").html('');
            
            for(player in scoreTable)
            {
                if (scoreTable[player].score > TopPlayerScore) {
                    TopPlayerScore = scoreTable[player].score;
                    TopPlayerName = player;
                }
            }
            
            $('#CurrentPlayerIndicator').html("Игра окончена<br>Победу одержал " + TopPlayerName + " с результатом " + TopPlayerScore + " очков");
        }
        
    }
    
    var ShowPlayersList = function()
    {
        $('#PlayersListBox').html("<tr><td colspan='4' style='background:#1A4C6D; color:#fff; text-align:center; padding:1%; border-radius: 3px;'><strong>Список игроков</strong></td></tr>");
            
        for(name in scoreTable)
        {
            $('#PlayersListBox').append("<tr><td width='8%' align='left' style='padding:3px;'><img src='" + prefix + "/images/icons/" + scoreTable[name].player_type + ".png' width='24' height='24'></td><td width='72%'>" + name + "</td><td width='20%' align='center'>" + scoreTable[name].score + "</td><td align='right'><img src='" + prefix + "/images/icons/delete.png' width='24' height='24' style='cursor:pointer;' class='DelPlayerButton' id='" + name + "'></td></tr>");
        }
    }

});