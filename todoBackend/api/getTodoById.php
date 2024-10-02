
<?php
// Получение дела по ID через параметр запроса
function getTodoById() {
    global $Link;

    // Проверяем, передан ли параметр id
    if (isset($_GET['id'])) {
        // Защита от SQL-инъекций
        $id = intval($_GET['id']);

        $query = "SELECT * FROM todo WHERE id = $id";
        $result = mysqli_query($Link, $query);

        if (mysqli_num_rows($result) == 1) {
            // Возвращаем задачу в формате JSON
            echo json_encode(mysqli_fetch_assoc($result));
        } else {
            // Если задача не найдена, возвращаем 404
            setHTTPSStatus("404", "Todo not found");
        }
    } else {
        // Если параметр id не передан, возвращаем ошибку
        setHTTPSStatus("400", "Bad Request: Missing 'id' parameter");
    }
}

