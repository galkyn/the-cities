$(function(){
    
    var countdown;
    
    //alert(countdown.settings.seconds);
     
    var scoreTable = {};
    var scoreTableCount = 0;
    
    var citiesStack = {};
    
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
 
    // Функция, отрабатывающая, когда время на ответ вышло 
    var countdownComplete = function(unit, value, total){
        if(total<=0){
            //$(this).fadeOut(800).replaceWith("<h2>Time's Up!</h2>");
            $('#CurrentPlayerIndicator').text("Время вышло! Ход переходит к следующему игроку!");
            setTimeout(SkipAnswer, 2000);
        }
    }

    // Функция, создающая таймер обратного отчета 
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

    // Функция, добавляющая игрока в список играющих 
    $('#AddNewPlayerToScoreListButton').click(function() {
        var playerName = $('#PlayerName').val();
        
        if (!(playerName in scoreTable)) {
            scoreTable[playerName] = { player_type:'human', score:0 };
            ShowPlayersList();
        } else {
            alert("Игрок с именем " + playerName + " уже зарегистрирован.");
        }
        
    });
    
    // Функция, добавляющая бота в список играющих 
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
    
    // Функция, ответ бота 
    var AiAnswer = function()
    {
        countdown.stop();
        
        var lastCity = $('#LastCityInput').val();
        var botCity;
        
        $.post(prefix + 'ajax/ai-answer', { mode: gameMode, lCity: lastCity }, function(data){
            //alert(data);
            botCity = jQuery.parseJSON(data);
            
            
            var lastLetter = GetLastLetter(botCity.city);
            
            
            //alert(botCity.city + " - " + lastLetter);
            
            if (botCity.city in citiesStack) {
                AiAnswer();
            } else {
                if (botCity.error == 'no error') {
                        
                    citiesStack[botCity.city] = { distance:botCity.distance, coords:botCity.coords };
                        
                    scoreTable[CurrentPlayer].score = scoreTable[CurrentPlayer].score + Math.floor(parseFloat(botCity.distance));
                    scoreTable[CurrentPlayer].lap_count++;
                    $('#debug').html(botCity.message + ": +" + botCity.distance + " км.");
                    $('#CityNameInput').val(lastLetter);
                    $('#LastCityInput').val(botCity.city);
                    ShowPlayersList();
                    ShowCitiesStack();
                    ProceedGame();
                }
                    
            }        
            
        });
        
    }
    
    // Функция, ответ человека 
    var HumanAnswer = function()
    {
        countdown.stop();
        
        var newCity = $('#CityNameInput').val();
        var lastCity = $('#LastCityInput').val();
        var lastLetter = GetLastLetter(newCity);
        
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
                        
                    if (data.error == 'no error') {
                            
                        citiesStack[data.city] = { distance:data.distance, coords:data.coords };
                        scoreTable[CurrentPlayer].score = scoreTable[CurrentPlayer].score + Math.floor(parseFloat(data.distance));
                        scoreTable[CurrentPlayer].lap_count++;
                            
                        $('#debug').html(data.message + ": +" + data.distance + " км.");
                        $('#CityNameInput').val(lastLetter);
                        $('#LastCityInput').val(newCity);
                        ShowPlayersList();
                        ShowCitiesStack();
                        ProceedGame();
                    } else {
                        $('#debug').html(data.error);
                        countdown.start();
                    }
                        
                });
                     
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
    
    //Перехват событий кнопок: Добавление бота в список игроков, ответ игрока, игрок жмет кнопку "не знаю"
    $('#AddBotToListButton').click(function() { AddBotToList(); });
    $('#SendAnswerButton').click(function() { HumanAnswer(); });
    $('#SkipAnswerButton').click(function() { SkipAnswer(); });
    
    //Перехват кнопок с классом "удалить игрока"
    $(document).on('click', '.DelPlayerButton', function(event){
        var playerName = event.target.id;
        
        delete scoreTable[playerName];
        scoreTableCount--;
        BotCounter = 0;
        ShowPlayersList();
        
    });
    
    //Перехват нажатия кнопки Enter -> эмуляция нажатия кнопки "Ответить"
    $("#CityNameInput").keyup(function(event){
        if(event.keyCode == 13){
            $("#SendAnswerButton").click();
        }
    });

    //Функция создания игры
    $('#CreateGameButton').click(function() {
        LapCount = parseInt($('#LapCount').val());
        if (LapCount == 0) { LapCount = 1000000; }
        
        StepTime = parseInt($('#StepTime').val());
        
        $('#CurrentLap').html('Круг ' + CurrentLap + ' из ' + LapCount);
            
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
         
        if (isGameCreated == 0) {
               
            $.post(prefix + 'ajax/ai-answer', { mode: gameMode, lCity: '_NA_' }, function(data){
                var randomCity = jQuery.parseJSON(data);
                var lastLetter = GetLastLetter(randomCity.city);
                
                isGameCreated = 1;
                
                $('#LastCityInput').val(randomCity.city);
                $('#CityNameInput').val(lastLetter);
                $('#CurrentPlayerIndicator').text("Начальный город: " + randomCity.city);
                
                setTimeout(ProceedGame, 2000);
                
            });   
        }
            
    });

    //Движок игры, главная функция обеспечивающая процесс игры
    var ProceedGame = function()
    {
        
        if (CurrentPlayerCount === scoreTableCount) {
            
            CurrentLap++;
            
            CurrentPlayerCount = 0;
            DrawLapIndicator();
        }
        
        if (CurrentLap <= LapCount) {
            
            for(player in scoreTable)
            {
                
                
                if (scoreTable[player].lap_count <= CurrentLap) {
                    
                    CurrentPlayer = player;
                    CurrentPlayerCount++;
                    
                    $('#CurrentPlayerIndicator').text("Отвечает: " + player);
                    
                    if (scoreTable[player].player_type === 'ai') { AiAnswer(); }
                    
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
            
            $('#CurrentLap').html('');
            
            $('#CurrentPlayerIndicator').html("Игра окончена<br>Победу одержал " + TopPlayerName + " с результатом " + TopPlayerScore + " очков");
        }
        
    }
    
    //Функция отображающая список игроков
    var ShowPlayersList = function()
    {
        $('#PlayersListBox').html("<tr><td colspan='4' style='background:#1A4C6D; color:#fff; text-align:center; padding:1%; border-radius: 3px;'><strong>Список игроков</strong></td></tr>");
            
        for(name in scoreTable)
        {
            $('#PlayersListBox').append("<tr><td width='8%' align='left' style='padding:3px;'><img src='" + prefix + "/images/icons/" + scoreTable[name].player_type + ".png' width='24' height='24'></td><td width='72%'>" + name + "</td><td width='20%' align='center'>" + scoreTable[name].score + "</td><td align='right'><img src='" + prefix + "/images/icons/delete.png' width='24' height='24' style='cursor:pointer;' class='DelPlayerButton' id='" + name + "'></td></tr>");
        }
    }

    //Функция отображающая список названных городов
    var ShowCitiesStack = function()
    {
        var str = '';
        var lastCity = $('#LastCityInput').val();
        
        $.each(citiesStack, function(key, value){
            
            str += (key === lastCity) ? " - <b>" + key + "</b><sup>" + value.distance + " км.</sup>" : " - " + key + "<sup>" + value.distance + " км.</sup>";
        });
	
        $('#gameLog').html(str.substring(3));
    }
    
    //Функция отображающая прогресс игры (сколько кругов прошло и сколько осталось)
    var DrawLapIndicator = function()
    {
        var width = $('#CurrentLapIndicator').width();
        var step = width / LapCount;
        var progress = width - Math.ceil(step * (CurrentLap - 1));
        
        $('#CurrentLap').html('Круг ' + CurrentLap + ' из ' + LapCount);
        
        $('#LapIndicatorProgress').animate({
            width: progress
        }, 500);
        
    }
    
});