  <?php
    require_once('function.php');
    require_once('connect.php');

    $is_auth = rand(0, 1);

    $user_name = 'Екатерина';

    $status = 1;

    $categories = get_category($connect);


    $page_content = include_template('auth.php', ['categories' => $categories]);


    $layout = include_template('layout.php', ['content' => $page_content, 'title' => 'Добавление лота', 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories' => $categories]);

    print($layout);
