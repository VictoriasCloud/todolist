<?php
// Обновление статуса задачи по ID через параметр запроса
function updateTodoStatusById() {
    global $Link;

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        
        // Получаем данные из тела запроса
        $data = json_decode(file_get_contents('php://input'));

        // Проверяем наличие поля done
        if (isset($data->done)) {
            // Приводим логическое значение к числовому (1 для true и 0 для false)
            $done = ($data->done === true || $data->done === 1 || $data->done === "true") ? 1 : 0;

            // Обновляем статус задачи в базе данных
            $query = "UPDATE todo SET done = $done, edited_at = NOW() WHERE id = $id";

            if (mysqli_query($Link, $query)) {
                // Возвращаем обновленные данные задачи
                $updatedQuery = "SELECT id, name, done FROM todo WHERE id = $id";
                $result = mysqli_query($Link, $updatedQuery);
                $updatedTodo = mysqli_fetch_assoc($result);

                // Устанавливаем заголовок и возвращаем обновленную задачу в формате JSON
                header('Content-Type: application/json');
                echo json_encode($updatedTodo);
            } else {
                setHTTPSStatus("500", "Ошибка обновления задачи");
            }
        } else {
            setHTTPSStatus("400", "Некорректные данные: отсутствует поле done");
        }
    } else {
        setHTTPSStatus("400", "Некорректные данные: отсутствует id задачи");
    }
}
