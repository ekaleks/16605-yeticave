<?php
require_once('function.php');
require_once('connect.php');

$is_auth = rand(0, 1);

$my_time = timer();

$user_name = 'Екатерина';

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
}

$page_content = include_template('lot.php', ['ads' => $ads, 'categories' => $categories, 'my_time' => $my_time]);

}
}

$layout = include_template(
    'layout.php', ['content' => $page_content, 'title' => $title, 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories' => $categories]);

print($layout);

