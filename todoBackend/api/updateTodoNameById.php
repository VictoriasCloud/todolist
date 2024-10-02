<?php

// Обновление имени задачи по ID через параметр запроса
function updateTodoNameById() {
    global $Link;

    // Проверяем, передан ли параметр id
    if (isset($_GET['id'])) {
        // Защита от SQL-инъекций
        $id = intval($_GET['id']);
        
        // Логируем ID задачи
        error_log("ID задачи: " . $id);

        // Получаем данные из тела запроса
        $data = json_decode(file_get_contents('php://input'));

        // Логируем полученные данные
        error_log("Данные запроса: " . json_encode($data));

        // Проверяем, что передано поле name
        if (isset($data->name)) {
            // Защита от SQL-инъекций для имени
            $name = mysqli_real_escape_string($Link, $data->name);

            // Логируем новое имя
            error_log("Новое имя задачи: " . $name);

            // Обновляем имя задачи и время редактирования в базе данных
            $query = "UPDATE todo SET name = '$name', edited_at = NOW() WHERE id = $id";

            // Логируем запрос
            error_log("SQL-запрос: " . $query);

            if (mysqli_query($Link, $query)) {
                // Успешное обновление
                error_log("Задача обновлена");

                // Возвращаем обновленные данные задачи
                $updatedQuery = "SELECT id, name, edited_at FROM todo WHERE id = $id";
                $result = mysqli_query($Link, $updatedQuery);
                $updatedTodo = mysqli_fetch_assoc($result);

                // Устанавливаем заголовок и возвращаем обновленную задачу в формате JSON
                header('Content-Type: application/json');
                echo json_encode($updatedTodo);
            } else {
                // Логируем ошибку базы данных
                error_log("Ошибка обновления задачи: " . mysqli_error($Link));
                setHTTPSStatus("500", "Error updating todo name");
            }
        } else {
            setHTTPSStatus("400", "Bad Request: Missing 'name' field");
        }
    } else {
        setHTTPSStatus("400", "Bad Request: Missing 'id' parameter");
    }
}

