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

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $required_fields = ['email', 'password'];


        $errors = [];

        $form = [];

        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {

                $errors[$field] = $_POST[$field];
            }
            else {
                $form[$field] = $_POST[$field];
            }
        }

        if (isset($form['email'])){
           $user = get_user_for_email($connect, $form['email']);

            if (!count($errors) && $user){
                if (password_verify($form['password'], $user['0']['password'])) {
                $_SESSION['user'] = $user;

                } else {
                    $errors['password_error'] = 'Неверный пароль';
                }
           } else {
                $errors['email_error'] = 'Пользователь не найден';
           }
        }




if (!count($errors)){
            header("Location: /index.php");
            die();

} else {
    $page_content = include_template('auth.php', ['categories' => $categories, 'form' => $form, 'errors' => $errors]);
}
    }

else{
    $page_content = include_template('auth.php', ['categories' => $categories]);

}

    $layout = include_template('layout.php', ['content' => $page_content, 'title' => 'Добавление лота', 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories' => $categories]);

    print($layout);
