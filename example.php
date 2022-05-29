<?php

require 'FriendlyWeb/TimeAgo/TimeAgo.php';

$timeAgo = new \FriendlyWeb\TimeAgo();

$date = "2022-05-22 21:22";

// выведет примерно следующее: 6 days
echo $timeAgo->LangTimeSpan($date); 

// выведет примерно следующее: 6 дней назад
echo $timeAgo->LangTimeSpan($date, "ru") . " назад";

// выведет примерно следующее: 6 дней, 3 часа, 10 секунд
echo $timeAgo->LangTimeSpan($date, "ru", true);

?>