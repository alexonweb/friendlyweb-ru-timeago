<?php

class TimeAgo 
{

    private $times_en = array (
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );

    private $times_ru = array (
        'y' => array('год','лет','года'),
        'm' => array('месяц','месяцев','месяца'),
        'w' => array('неделю','недель','недели'),
        'd' => array('день','дней','дня'),
        'h' => array('час','часов','часа'),
        'i' => array('минуту','минут','минуты'),
        's' => array('секунду','секунд','секунды'),
    );

    private $i18n = array(
        'RU' => array(
            'AGO' => 'назад',
            'JUST_NOW' => 'только что'
        ),
        'EN' => array(
            'AGO' => 'ago',
            'JUST_NOW' => 'just now'
        )
    );

    public function  LangTimeSpan ($datetime, $lang = 'en', $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        // Переводим язык в верхний реестр
        $lang = strtoupper($lang);

        // Подключаем языки
        if ($lang == "RU") {
            $string = $this->times_ru;
        } else {
            $string = $this->times_en;
        }

        foreach ($string as $k => &$v) {

            if ($diff->$k) {

                if ( is_array($v) ) {

                    $declension = $this->GetDeclension($diff->$k);

                    $v = $diff->$k . ' ' . $v[$declension];

                } else {

                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');

                }

            } else {

                unset($string[$k]);

            }

        }

        // Выводим полную дату
        if (!$full) $string = array_slice($string, 0, 1);

        //
        if ($string) {

            $result = implode(', ', $string);

        } else {

            $result = $this->i18n[$lang]['JUST_NOW'];

        }

        return $result;

    }



    // Получаем склоения в русском языке
    private function GetDeclension($date)
    {
        // 4 года
        if((($date % 10) > 4 && ($date % 10) < 10) || ($date > 10 && $date < 20)){
            return 1;
        }

        // 5 лет
        if(($date % 10) > 1 && ($date % 10) < 5){
            return 2;
        }

        // 1 год
        if(($date%10) == 1){
            return 0;
        }

        // 2 года
        else{
            return 1;
        }

    }

}


$timeAgo = new TimeAgo();

$date = new DateTime("now");

echo $timeAgo->LangTimeSpan($date, "ru");



?>
