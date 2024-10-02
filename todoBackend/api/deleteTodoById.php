
<?php
// Удаление задачи по ID через параметр запроса
// Удаление задачи по ID через параметр запроса
function deleteTodoById() {
    global $Link;

    // Проверяем, передан ли параметр id
    if (isset($_GET['id'])) {
        // Защита от SQL-инъекций
        $id = intval($_GET['id']);
        
        // Удаляем задачу из базы данных
        $query = "DELETE FROM todo WHERE id = $id";

        if (mysqli_query($Link, $query)) {
            // Возвращаем успешный ответ
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Task deleted successfully']);
        } else {
            // Возвращаем ошибку при удалении
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error deleting task']);
        }
    } else {
        // Возвращаем ошибку, если id не передан
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Missing id parameter']);
    }
}

