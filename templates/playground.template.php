
<input type='hidden' id='CheckLetterInput' value='_NA_'>


<div class='container-fluid'>

<div class='row' style='background: #1A4C6D; padding: 1%;'>
    <div class='col-xs-4 col-sm-3 col-md-2'>
        <a href='<?=Route::$prefix?>'>
            <img src='<?=Route::$prefix?>images/icons/<?=self::$gameMode?>.png' class='game-mode-icon'>
        </a>
    </div>
    <div class='col-xs-8 col-sm-9 col-md-10'>
        <div class='game-mode-title'><?=$this->gameModeTitle?></div>
        <div class='hidden-xs game-mode-desc blockquote'><?=$this->gameModeDescFull?></div>
        <div class='visible-xs game-mode-desc blockquote'><?=$this->gameModeDescShort?></div>
    </div>
</div>

<div class='row'>
    <div class='col-xs-12 col-sm-4 col-sm-push-4 central'>
	<div class='row'>
	    <div class='col-xs-12'>
		<div id='CurrentLapIndicator'></div>
	    </div>
	</div>
        <div class='row'>
            <div class='col-xs-12' style='text-align: center;'>
                <h3><span id='CurrentPlayerIndicator'></span></h3>
            </div>
        </div>

        <div class='row'>
            <div class='col-xs-12' style='text-align: center;'>
		
		<div id="countdown"></div>
		<!--
		<script type="text/javascript" charset="utf-8">

		 	
			countdown.start();
			console.log('countdown360 ',countdown);
		</script>
	-->
            </div>
        </div>
        
        <div class='row' style='margin-top: 5%;'>
            <div class='col-xs-12'>
                <label for= 'CityNameInput'>Введите название города:</label>
                <input type='text' id='CityNameInput' class='form-control'>
            </div>
        </div>
        <div class='row'>
            <div class='col-xs-12'>
                <div id='debug'></div>
            </div>
        </div>
        
        <div class='row' style='margin-top: 5%;'>
            <div class='col-xs-12 col-sm-6' style='text-align: center; padding-bottom: 5%;'>
                <input type='button' class='btn btn-success btn-md' value='Ответить' id='SendAnswerButton' style='width: 100%;'>
            </div>
            <div class='col-xs-12 col-sm-6' style='text-align: center; padding-bottom: 5%;'>
                <input type='button' class='btn btn-danger btn-md' value='Не знаю' id='SkipAnswerButton' style='width: 100%;'>
            </div>
        </div>
        
    </div>

    <div class='col-xs-12 col-sm-4 col-sm-pull-4 side'>
	<div id='CreateGameForm' style='padding-bottom: 2%; margin-bottom: 2%;'>
	    <div class='row' style='margin-top: 2%;'>
		<div class='col-xs-6'>
		    <label for='LapCount'>Количество кругов:<img src='<?=Route::$prefix?>images/icons/info.png' width='16' height='16' alt='Сколько раз каждый участник отвечает' title='Сколько раз каждый участник отвечает'></label>
		    <input type='text' id='LapCount' class='form-control' value='10'>
		</div>
		<div class='col-xs-6'>
		    <label for='StepTime'>Время на ход (сек):</label>
		    <input type='text' id='StepTime' class='form-control' value='30'>
		</div>
	    </div>
	    <div class='row' style='margin-top: 2%;'>
		<div class='col-xs-12'><label for='PlayerName'>Добавьте игроков:<img src='<?=Route::$prefix?>images/icons/info.png' width='16' height='16' alt='Введите имя/ник игрока и нажмите кнопку "+" для добавления игрока в список участников' title='Введите имя/ник игрока и нажмите кнопку "+" для добавления игрока в список участников'></label></div>
		<div class='col-xs-9 col-sm-9 col-md-10'>
		    <input type='text' id='PlayerName' class='form-control' value='Игрок 1'>
		</div>
		<div class='col-xs-3 col-sm-3 col-md-2'><input type='button' class='btn btn-info btn-md' style='width: 100%;' value='+' id='AddNewPlayerToScoreListButton'></div>
	    </div>
	    <div class='row' style='margin-top: 2%;'>
		<div class='hidden-xs hidden-sm col-md-12 col-lg-8'>Если не хватает остроты, можете добавить бота. Это добавит динамики и интереса игре.</div>
		<div class='col-xs-12 col-sm-12 col-md-12 col-lg-4'><input type='button' class='btn btn-info btn-md' style='width: 100%;' value='Добавить бота' id='AddBotToListButton'></div>
	    </div>
	    <div class='row' style='margin-top: 2%;'>
		<div class='col-xs-12'><input type='button' class='btn btn-primary btn-md' style='width: 100%;' value='Создать игру' id='CreateGameButton'></div>
	    </div>
	</div>
	<div style='margin-top: 2%;'>
            <table border='0' cellpadding='0' cellspacing='0' align='center' width='100%' id='PlayersListBox'>
		
	    </table>
        </div>
    </div>
    <div class='col-xs-12 col-sm-4 side'>
        <div id='gameLog' class='column'></div>
    </div>

</div>

</div>
