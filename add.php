<?php
require_once('function.php');
require_once('connect.php');

$categories = get_category($connect);

$user = [];
$user_name = [];
$is_auth = 0;

if (isset($_SESSION['user'])) {
    $is_auth = 1;

if (isset($_SESSION['user']['0']['name'])) {
    $user_name = $_SESSION['user']['0']['name'];
}

$status = 1;

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $required_fields = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];

    $errors = [];

    $lot = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {

            $errors[$field] = $_POST[$field];

        }
    }
    if(isset($_POST['lot-name'])) {
        if(trim(($_POST['lot-name'])) === '') {
            $errors['lot-name'] = $_POST['lot-name'];
        }
        if(!isset($errors['lot-name'])){
            $lot['title'] = $_POST['lot-name'];
        }

    }

    if (isset($_POST['category'])) {
        $lot['category'] = $_POST['category'];
    }


    if (isset($_POST['message'])) {
        if (trim(($_POST['message'])) === '') {
            $errors['message'] = $_POST['message'];
        }

        if (!isset($errors['message'])) {
            $lot['description_lot'] = $_POST['message'];
        }
    }





    if(isset($_POST['lot-rate'])) {
        $error_lot_rate = $_POST['lot-rate'];
        if((int)$error_lot_rate <= 0 && !isset($errors['lot-rate'])){

         $errors['lot-rate-size'] = $_POST['lot-rate'];
        }

        if (!isset($errors['lot-rate']) && !isset($errors['lot-rate-size'])) {
            $lot['starting_price'] = $_POST['lot-rate'];
        }
    }



    if (isset($_POST['lot-step'])) {
        $error_lot_step = $_POST['lot-step'];
        if ((int)$error_lot_step <= 0 && !isset($errors['lot-step'])) {

            $errors['lot-step-size'] = $_POST['lot-step'];
        }

        if (!isset($errors['lot-step']) && !isset($errors['lot-step-size'])) {
            $lot['bid_step'] = $_POST['lot-step'];
        }
    }

    if (isset($_POST['lot-date'])) {
        if(trim(($_POST['lot-date'])) === ''){
            $errors['lot-date'] = $_POST['lot-date'];
        }

        if (!isset($errors['lot-date']) && check_date_format($_POST['lot-date']) == false || strtotime($_POST['lot-date']) < (time() + 86400)) {

            $errors['lot-date-format'] = $_POST['lot-date'];
        }

        if (!isset($errors['lot-date']) && !isset($errors['lot-date-format'])) {
            $lot['date_completion'] = date('Y-m-d', strtotime($_POST['lot-date']));
        }
    }



     if (!empty($_FILES['avatar']['name'])) {
        $tmp_name = $_FILES['avatar']['tmp_name'];
        $path = $_FILES['avatar']['name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);

        if($file_type == "image/jpeg"){
            $filename = uniqid() . '.jpeg';
        }
        else if($file_type == "image/jpg") {
            $filename = uniqid() . '.jpg';

        } else if($file_type == "image/png") {
            $filename = uniqid() . '.png';
        }

        if ($file_type !== "image/jpeg" && $file_type !== "image/jpg" && $file_type !== "image/png") {
            $errors['file-format'] = 'Загрузите картинку в формате JPEG, JPG или PNG';
        } else {
            move_uploaded_file($tmp_name, 'img/' . $filename);
            $lot['user_file'] = $filename;
        }
    } else {
        $errors['file'] = 'Вы не загрузили файл';
    }


    if(!count($errors)){

        $result = put_lot_in_database($connect, $lot);
        if($result) {
        $lot_id = mysqli_insert_id($connect);

        header("Location: /lot.php?id=" . $lot_id);
        die();
        }

    } else{
        $page_content = include_template('add.php', ['categories' => $categories, 'errors' => $errors, 'lot' => $lot]);

}
}
else{

  $page_content = include_template('add.php', ['categories' => $categories]);
}
} else {
    $page_content = include_template('403.php', []);
}
$layout = include_template('layout.php', ['content' => $page_content, 'title' => 'Добавление лота', 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories' => $categories]);

print($layout);
