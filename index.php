<?php
 require_once('function.php');
 require_once('connect.php');

$user = [];
$is_auth = 0;
$user_name = [];

if (isset($_SESSION['user'])) {

    $is_auth = 1;

  if (isset($_SESSION['user']['0']['name'])) {

    $user_name = $_SESSION['user']['0']['name'];
 }
}
$status = 1;

$categories = get_category($connect);

$ads = get_open_new_lots($connect, $status);

$page_content = include_template('index.php', ['ads' => $ads, 'categories' => $categories]);

$layout = include_template('layout.php', ['content' => $page_content, 'title' => 'Главная', 'is_auth' => $is_auth, 'user' => $user, 'user_name' => $user_name, 'categories' => $categories]);

print($layout);


