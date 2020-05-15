<?php

$connect = mysqli_connect('localhost', 'root', '', 'yeticave');

if ($connect == false) {
    print('Ошибка подключения' . mysqli_connect_error());
    exit;
}
mysqli_set_charset($connect, 'utf8');

