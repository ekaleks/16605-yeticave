<?php
require_once('function.php');
require_once('connect.php');

$title = null;

$categories = get_category($connect);

$user = [];

$user_name = [];

$is_auth = 0;

$add_cost = null;

$history_cost = null;

$last_cost = null;

$rate = [];

$price = null;

$creation_user = null;

if (isset($_SESSION['user'])) {

    if (isset($_SESSION['user']['0']['name'])) {
        $user_name = $_SESSION['user']['0']['name'];
    }

    if (isset($_SESSION['user']['0']['id'])) {
        $rate['user_id'] = strval($_SESSION['user']['0']['id']);
    }

    $is_auth = 1;



    $add_cost = include_template('add-cost.php', []);
}



if (isset($_GET['id'])) {

    $costs = [];

    $id = $_GET['id'];

    $result_sql = get_lots_for_ld($connect, $id);

    if ($result_sql === []) {
        $page_content = include_template('404.php', []);
    }
    else {
        $ads = $result_sql;
        $title = $ads[0]['title'];
        $my_time = timer($ads[0]['date_completion']);
        $bid_step = $ads[0]['bid_step'];
        $price = $ads[0]['starting_price'];
        $creation_user =$ads[0]['creation_user_id'];

if(isset($_SESSION['user']['0']['id'])){
        if($my_time < 0 || $creation_user == $_SESSION['user']['0']['id']) {
            $add_cost = null;
        }

        $result = get_rate_for_user_and_lot($connect, [$_SESSION['user']['0']['id'], $id]);



        if ($result != []) {
            $add_cost = null;
        }
    }

        $costs = get_rates_for_lot($connect, $id);
        if(isset($costs[0]['lot_price'])) {

        $last_cost = $costs[0]['lot_price'];

            if ($last_cost !== null) {
                $price = $last_cost;
            }
    }

        $history_cost = include_template('history-cost.php', ['costs' => $costs]);

    if(isset($_SESSION)){
        $_SESSION['lot'] = $result_sql;

    }
        $page_content = include_template('lot.php', ['last_cost' => $last_cost, 'price' => $price, 'ads' => $ads, 'categories' => $categories, 'my_time' => $my_time, 'add_cost' => $add_cost, 'history_cost' => $history_cost]);
    }

}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $errors = [];

    $last_cost;


    if(isset($_SESSION['lot'])){

    $ads = $_SESSION['lot'];

        $id = $_SESSION['lot'][0]['id'];

        $rate['lot_id'] = strval($id);

        $costs = get_rates_for_lot($connect, $id);

        if (isset($costs[0]['lot_price'])) {
            $last_cost = $costs[0]['lot_price'];
        }

        $title = $ads[0]['title'];
        $my_time = timer($ads[0]['date_completion']);
        $bid_step = $ads[0]['bid_step'];
        $price = $ads[0]['starting_price'];
        $creation_user = $ads[0]['creation_user_id'];


        if ($my_time < 0 || $creation_user == $_SESSION['user']['0']['id'] ) {
            $add_cost = null;
        }

        $result = get_rate_for_user_and_lot($connect, [$_SESSION['user']['0']['id'], $id]);


        if($result !== []){
            $add_cost = null;
        }



        if($last_cost !== null) {
            $price = $last_cost;
        }


    }

    if (empty($_POST['cost']) || trim(($_POST['cost'])) === '') {
        $errors['cost'] = $_POST['cost'];


    } else {
        $rate['lot_price'] = $_POST['cost'];
    }


    if(!empty($_POST['cost']) && $_POST['cost'] < ($price + $bid_step) ) {
        $errors['cost-size'] = $_POST['cost'];

    } else {
        $rate['lot_price'] = $_POST['cost'];
    }

    if (!empty($_POST['cost']) && strval(round($_POST['cost'])) !== $_POST['cost']) {

        $errors['cost-round'] = $_POST['cost'];

    } else {
        $rate['lot_price'] = $_POST['cost'];
    }


    if (!count($errors)) {

        $rate = array_reverse($rate);

        $result = put_cost_in_database($connect, $rate);

        if ($result) {
        header("Location: /lot.php?id=" . $rate['lot_id']);
        die();
    }

    } else {
        $history_cost = include_template('history-cost.php', ['costs' => $costs]);
        $add_cost = include_template('add-cost.php', ['errors' => $errors,'rate' => $rate]);
        $page_content = include_template('lot.php', ['ads' => $ads, 'last_cost' => $last_cost, 'price' => $price, 'categories' => $categories, 'my_time' => $my_time, 'add_cost' => $add_cost, 'history_cost' => $history_cost]);
    }
}

$layout = include_template(
    'layout.php', ['content' => $page_content, 'title' => $title, 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories' => $categories]);

print($layout);

