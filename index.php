<?php
 require_once('function.php');
 require_once('connect.php');

$is_auth = rand(0, 1);

$my_time = timer();

$user_name = 'Екатерина';

/*$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];

$ads = [
    [
        'Название' => '2014 Rossignol District Snowboard',
        'Категория' => 'Доски и лыжи',
        'Цена' => '10999',
        'URL' => 'img/lot-1.jpg'
    ],
    [
        'Название' => 'DC Ply Mens 2016/2017 Snowboard',
        'Категория' => 'Доски и лыжи',
        'Цена' => '159999',
        'URL' => 'img/lot-2.jpg'
    ],
    [
        'Название' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'Категория' => 'Крепления',
        'Цена' => '8000',
        'URL' => 'img/lot-3.jpg'

    ],
    [
        'Название' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'Категория' => 'Ботинки',
        'Цена' => '10999',
        'URL' => 'img/lot-4.jpg'
    ],
    [
        'Название' => 'Куртка для сноуборда DC Mutiny Charocal',
        'Категория' => 'Одежда',
        'Цена' => '7500',
        'URL' => 'img/lot-5.jpg'

    ],
    [
        'Название' => 'Маска Oakley Canopy',
        'Категория' => 'Разное',
        'Цена' => '5400',
        'URL' => 'img/lot-6.jpg'

    ]
];*/


$page_content = include_template('index.php', ['ads' => $ads, 'categories' => $categories, 'my_time' => $my_time]);

$layout = include_template('layout.php',
['content' => $page_content, 'title' => 'Главная', 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories' => $categories]);

print($layout);

?>
