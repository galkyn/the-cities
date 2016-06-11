
<input type='hidden' id='CheckLetterInput' value='_NA_'>


<div class='container-fluid'>

<div class='row' style='background: #1A4C6D; padding: 1%;'>
    <div class='col-xs-4 col-sm-3 col-md-2'>
        <a href='<?=Route::$prefix?>'>
            <img src='<?=Route::$prefix?>images/icons/<?=GameController::$gameMode?>.png' class='game-mode-icon'>
        </a>
    </div>
    <div class='col-xs-8 col-sm-9 col-md-10'>
        <div class='game-mode-title'>Игра против всех</div>
        <div class='hidden-xs game-mode-desc blockquote'>
            в этом режиме игрок соревнуется с другими такими же игроками по всему миру. Указав логин и пароль, игрок получает доступ к глобальному рейтингу. Рейтинг отображается по трем параметрам: количеству набранных очков, количеству сыгранных игровых сессий, среднему количеству очков, набранных за одну игровую сессию.
        </div>
        <div class='visible-xs game-mode-desc blockquote'>
            в этом режиме игрок соревнуется с другими такими же игроками по всему миру. Указав логин и пароль, игрок получает доступ к глобальному рейтингу. 
        </div>
    </div>
</div>

<div class='row'>
    <div class='col-xs-12 col-sm-4 col-sm-push-4 central'>
        <div class='row'>
            <div class='col-xs-12' style='text-align: center;'>
                <h3>Отвечает: ЗлобныйПерец</h3>
            </div>
        </div>

        <div class='row'>
            <div class='col-xs-12' style='text-align: center;'>
		<div id="countdown"></div>
		<script type="text/javascript" charset="utf-8">

		 	var countdown =  $("#countdown").countdown360({
                            radius      : 50,
                            seconds     : 5,
                            strokeWidth : 5,
                            fontColor   : '#FFFFFF',
                            label       : ["сек"],
                            smooth      : true,
                            autostart   : false,
                            onComplete  : function () { alert('Апаздал!!!') }
                        });
			countdown.start();
			console.log('countdown360 ',countdown);
		</script>
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
                <input type='button' class='btn btn-warning btn-md' value='Не знаю' id='SkipAnswerButton' style='width: 100%;'>
            </div>
        </div>
        
    </div>

    <div class='col-xs-12 col-sm-4 col-sm-pull-4 side'>
        <div class='column'>
            рейтинг юзеров<br><Br><br><br><br><br><br>&nbsp;
        </div>
    </div>
    <div class='col-xs-12 col-sm-4 side'>
        <div id='gameLog' class='column'></div>
    </div>

</div>

</div>
