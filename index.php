<?php
 require_once('function.php');
 require_once('connect.php');

$user = [];
$is_auth = 0;
$user_name = [];
$status = 1;
$my_time = null;

if (isset($_SESSION['user'])) {

    $is_auth = 1;

  if (isset($_SESSION['user']['0']['name'])) {

    $user_name = $_SESSION['user']['0']['name'];
 }
}

$ads = get_open_new_lots($connect, $status);

foreach($ads as $ad){

$my_time = timer($ad['date_completion']);

if(isset($ad['id']) && $my_time < 0) {
 update_lot_status_check($connect, $ad['id']);
}

}





$categories = get_category($connect);


$page_content = include_template('index.php', ['ads' => $ads, 'categories' => $categories,'my_time' => $my_time]);

$layout = include_template('layout.php', ['content' => $page_content, 'title' => 'Главная', 'is_auth' => $is_auth, 'user' => $user, 'user_name' => $user_name, 'categories' => $categories]);

print($layout);


