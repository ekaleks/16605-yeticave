<?php

function include_template($name, $data)
{
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function is_formatting_price($price)
{

    $price = ceil($price);
    if ($price < 1000) {
        return $price . ' ₽';
    } else {
        return number_format($price, '0', '', ' ') . ' ₽';
    }
}

function timer(){
    $my_time = strtotime('tomorrow') - time();
    $hours = floor($my_time / 3600);
    $minutes = floor(($my_time % 3600) / 60);
    $my_time = $hours.':'.$minutes;

    return $my_time;
}



?>
