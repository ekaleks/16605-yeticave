<?php
require_once('function.php');
require_once('connect.php');

$user = [];
$user_name = [];
$is_auth = 0;
$add_cost = null;

if (isset($_SESSION['user'])) {
    if (isset($_SESSION['user']['0']['name'])) {
        $user_name = $_SESSION['user']['0']['name'];
    }

    $is_auth = 1;
    $add_cost = include_template('add-cost.php', []);

}


$title = null;

$categories = get_category($connect);

if(isset($_GET['id'])){

$id = $_GET['id'];

$result_sql = get_lots_for_ld($connect, $id);

    if ($result_sql === []) {
        $page_content = include_template('404.php', []);
    } else{

$ads = $result_sql;


foreach ($ads as $ad =>$value){
$title = $value['title'];
$my_time = timer($value['date_completion']);
}


$page_content = include_template('lot.php', ['ads' => $ads, 'categories' => $categories, 'my_time' => $my_time, 'add_cost' => $add_cost]);

}
}

$layout = include_template(
    'layout.php', ['content' => $page_content, 'title' => $title, 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories' => $categories]);

print($layout);

