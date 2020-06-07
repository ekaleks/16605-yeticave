<?php
require_once('function.php');
require_once('connect.php');

$is_auth = rand(0, 1);

$user_name = 'Екатерина';

$categories = get_category($connect);


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $required_fields = ['email', 'password', 'name', 'message'];


    $errors = [];

    $form = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {

            $errors[$field] = $_POST[$field];

          }

    }


    if (isset($_POST['email'])) {

        if(!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

            $errors['email_validate'] = $_POST['email'];

        }

        if (!isset($errors['email_validate'])){

            $user_email = get_email_for_user($connect, $_POST['email']);


            if ($user_email) {
                $errors['email_unique'] = $_POST['email'];

        }
    }

        if (!isset($errors['email']) && !isset($errors['email_validate']) && !isset($errors['email_unique'])) {

            $form['e_mail'] = $_POST['email'];

        }

    }



    if (isset($_POST['password'])) {
        if (trim(($_POST['password'])) === '') {
            $errors['password'] = $_POST['password'];
        }
        if (!isset($errors['email'])) {
            $form['password'] = $_POST['password'];
        }
    }

    if (isset($_POST['name'])) {
        if (trim(($_POST['name'])) === '') {
            $errors['name'] = $_POST['name'];
        }
        if (!isset($errors['name'])) {
            $form['name'] = $_POST['name'];
        }
    }

    if (isset($_POST['message'])) {
        if (trim(($_POST['message'])) === '') {
            $errors['message'] = $_POST['message'];
        }
        if (!isset($errors['email'])) {
            $form['contacts'] = $_POST['message'];
        }
    }


    if (!empty($_FILES['avatar']['name'])) {
        $tmp_name = $_FILES['avatar']['tmp_name'];
        $path = $_FILES['avatar']['name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);

        if ($file_type == "image/jpeg") {
            $filename = uniqid() . '.jpeg';
        } else if ($file_type == "image/jpg") {
            $filename = uniqid() . '.jpg';
        } else if ($file_type == "image/png") {
            $filename = uniqid() . '.png';
        }

        if ($file_type !== "image/jpeg" && $file_type !== "image/jpg" && $file_type !== "image/png") {
            $errors['file'] = 'Загрузите картинку в формате JPEG, JPG или PNG';
        } else {
            move_uploaded_file($tmp_name, 'img/' . $filename);
            $form['user_file'] = $filename;
        }

    } else {
        $form['user_file'] = '';
    }


    if (!count($errors)) {


        $form['password'] = password_hash($form['password'], PASSWORD_DEFAULT);

        $result = put_user_in_database($connect, $form);

        if ($result) {

            header("Location: auth.php");
            die();
        } else {
            $page_content = include_template('registration.php', ['categories' => $categories, 'form' => $form, 'errors' => $errors]);
        }
    }
    $page_content = include_template('registration.php', ['categories' => $categories, 'form' => $form, 'errors' => $errors]);

}

 else {

$page_content = include_template('registration.php', ['categories' => $categories]); }

$layout = include_template(
    'layout.php', ['content' => $page_content, 'title' => 'Регистрация', 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories' => $categories]);

print($layout);
