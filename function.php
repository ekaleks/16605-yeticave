<?php

require_once('mysql_helper.php');

/**
 * Функция - шаблонизатор
 *
 * @param $name Имя файла шаблона
 * @param array $data Данные для этого шаблона
 *
 * @return $result Итоговый HTML-код с подставленными данными
 */
function include_template($name, $data)
{
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

/**
 * Форматирует цену лота
 *
 * @param $data Цена лота
 *
 * @return $price Отформатированный HTML-код
 */
function is_formatting_price($data)
{

    $price = ceil($data);
    if ($price < 1000) {
        return $price . ' ₽';
    } else {
        return number_format($price, '0', '', ' ') . ' ₽';
    }
}

/**
 * Подсчитывает количество времени, оставшееся до следующих суток
 *
 * @return $my_time количество времени до следующих суток в часах и минутах
 */

function timer($data){
    $my_time = strtotime($data) - time();
    $hours = floor($my_time / 3600);
    $minutes = floor(($my_time % 3600) / 60);
    $my_time = $hours.':'.$minutes;

    return $my_time;
}

/**
 * Проверяет, что переданная дата соответствует формату ДД.ММ.ГГГГ
 * @param string $date строка с датой
 * @return bool
 */
function check_date_format($date) {
    $result = false;
    $regexp = '/(\d{2})\.(\d{2})\.(\d{4})/m';

    if (preg_match($regexp, $date, $parts) && count($parts) == 4) {
        $result = checkdate($parts[2], $parts[1], $parts[3]);
    }

    return $result;
}


/**
 * Получает из БД список категорий лотов
 *
 * @param $connect Ресурс соединения
 *
 * @return array $result Массив с категориями лотов
 */
function get_category($connect)
    {
        $sql_query ='SELECT id, title FROM categories';
        $result =  mysqli_query($connect, $sql_query);
        if ($result) {
            $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        return $result;
    };

function get_category_for_id($connect, $data)
{
    $data = [$data];
    $sql_query = 'SELECT title FROM categories WHERE id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};



/**
 * Получает из БД список лотов
 *
 * @param $connect Ресурс соединения
 *
 *
 * @return array $result Массив с лотами
 */

function get_open_new_lots($connect, $data)
{
    $data = [$data];
    $sql_query = 'SELECT l.id, date_creation, l.title, c.title AS category, user_file, starting_price AS price, date_completion FROM lots l JOIN categories c ON l.category_id = c.id WHERE status = ? ORDER BY date_creation DESC';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

function get_lots_for_ld($connect, $data)
{
    $data = [$data];
    $sql_query = 'SELECT l.id, date_creation, l.title, c.title AS category, user_file, starting_price AS price, bid_step, description_lot, date_completion FROM lots l JOIN categories c ON l.category_id = c.id WHERE l.id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

/**
 * Добавляет в БД новый лот
 *
 * @param $connect Ресурс соединения
 * @param array $data Данные для запроса из базы SQL
 *
 * @return bool
 */
function put_lot_in_database($connect, $data)
{
    $sql_query = 'INSERT INTO lots (title, category_id, description_lot, starting_price, bid_step, date_completion, user_file, creation_user_id ) VALUES (?, ?, ?, ?, ?, ?, ?, 2)';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $result = mysqli_insert_id($connect);
    }

    return $result;
};
