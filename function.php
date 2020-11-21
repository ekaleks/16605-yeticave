<?php
// подключение сессии
session_start();

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
 * Подсчитывает количество времени, оставшееся до окончания торгов по лоту.
 *
 * @return $my_time количество времени оставшееся до окончания торгов по лоту в часах и минутах
 */

function timer($data){
    $my_time = strtotime($data) - time();
    $hours = floor($my_time / 3600);
    $minutes = floor(($my_time % 3600) / 60);
    $my_time = $hours .' ч'. ' : '.$minutes. ' м';

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
    $sql_query = 'SELECT l.id, date_creation, l.title, c.title AS category, user_file, starting_price AS price, date_completion FROM lots l JOIN categories c ON l.category_id = c.id WHERE status = ? ORDER BY date_creation DESC LIMIT 9';
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
    $sql_query = 'SELECT l.id, date_creation, l.title, c.title AS category, user_file, starting_price, bid_step, description_lot, date_completion, creation_user_id FROM lots l JOIN categories c ON l.category_id = c.id WHERE l.id = ?';
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
    $sql_query = 'INSERT INTO lots (title, category_id, description_lot, starting_price, bid_step, date_completion, user_file, creation_user_id ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $result = mysqli_insert_id($connect);
    }

    return $result;
};

/**
 * Добавляет в БД новую ставку
 *
 * @param $connect Ресурс соединения
 * @param array $data Данные для запроса из базы SQL
 *
 * @return bool
 */
function put_cost_in_database($connect, $data)
{
    $sql_query = 'INSERT INTO rates (date_posting, lot_price, lot_id, user_id ) VALUES (NOW(), ?, ?, ?)';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $result = mysqli_insert_id($connect);
    }

    return $result;
};



/**
 * Получает из БД список email-ов юзеров по email
 *
 * @param $connect Ресурс соединения
 * @param string $data Email юзера для запроса из базы SQL
 *
 * @return array $result Массив юзеров
 */
function get_email_for_user($connect, $data)
{
    $data = [$data];
    $sql_query = 'SELECT e_mail AS email FROM users WHERE e_mail = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

/**
 * Получает из БД юзера по email
 *
 * @param $connect Ресурс соединения
 * @param string $data Email юзера для запроса из базы SQL
 *
 * @return array $result юзер
 */
function get_user_for_email($connect, $data)
{
    $data = [$data];
    $sql_query = 'SELECT id, date_registration, e_mail AS email, name, password, user_file, contacts FROM users WHERE e_mail = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};



/**
 * Добавляет в БД нового юзера
 *
 * @param $connect Ресурс соединения
 * @param array $data Данные для запроса из базы SQL
 *
 * @return bool
 */
function put_user_in_database($connect, $data)
{
    $sql_query = 'INSERT INTO users (e_mail, password, name, contacts, user_file) VALUES (?, ?, ?, ?, ?)';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $result = mysqli_insert_id($connect);
    }

    return $result;
};

function get_rates_for_lot($connect, $data)
{
    $data = [$data];
    $sql_query = 'SELECT u.name, lot_price, date_posting FROM users u JOIN rates r ON u.id = r.user_id JOIN lots l ON r.lot_id = l.id WHERE l.id = ? ORDER BY date_posting DESC';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

/**
 * Получает из БД ставку для лота и юзера.
 *
 * @param $connect Ресурс соединения
 * @param string $data id лота и id юзера для запроса из базы SQL
 *
 * @return array $result
 */
function get_rate_for_user_and_lot($connect, $data)
{

    $sql_query = 'SELECT lot_price FROM rates WHERE user_id = ? AND lot_id =?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};


/**
 * Меняет статус лота на "закрыт"
 *
 * @param $connect Ресурс соединения
 * @param integer $data Id задачи для запроса из базы SQL
 *
 * @return bool
 */
function update_lot_status_check($connect, $data)
{
    $data = [$data];
    $sql_query = 'UPDATE lots SET status = 0 WHERE id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $result = mysqli_insert_id($connect);
    }

    return $result;
};
