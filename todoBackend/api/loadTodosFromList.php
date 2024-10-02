<?php
include_once 'createTodo.php';

// Загрузка списка дел (очищает таблицу и вставляет новые записи)
function loadTodosFromList($requestData) {
    global $Link;

    // Получаем данные из тела запроса
    $data = $requestData->body;

    // Проверяем, что данные переданы и это массив
    if (is_array($data)) {
        // Очищаем таблицу перед загрузкой новых данных
        $truncateQuery = "TRUNCATE TABLE todo";
        if (!mysqli_query($Link, $truncateQuery)) {
            setHTTPSStatus("500", "Error truncating table");
            return;
        }

        // Проходим по каждому делу в списке и создаем новое дело
        foreach ($data as $todo) {
            createTodoFromList($todo);  
        }

        // Успешно загрузили все дела
        setHTTPSStatus("201", "Todos loaded successfully");
    } else {
        setHTTPSStatus("400", "Bad Request: Expected a list of todos");
    }
}

// Создание нового дела из списка с полным набором полей
function createTodoFromList($todo) {
    global $Link;

    // Проверяем наличие обязательного поля 'name'
    if (isset($todo->name)) {
        // Извлекаем поля, если они присутствуют, или назначаем значения по умолчанию
        $name = mysqli_real_escape_string($Link, $todo->name);
        $done = isset($todo->done) ? intval($todo->done) : 0;  // Если done не передан, ставим 0
        $created_at = isset($todo->created_at) ? mysqli_real_escape_string($Link, $todo->created_at) : 'NOW()';
        $edited_at = isset($todo->edited_at) ? mysqli_real_escape_string($Link, $todo->edited_at) : 'NOW()';

        // Если передаются значения created_at и edited_at, они вставляются напрямую, иначе ставим текущие
        $query = "INSERT INTO todo (name, done, created_at, edited_at) 
                  VALUES ('$name', $done, 
                  " . ($created_at === 'NOW()' ? "NOW()" : "'$created_at'") . ", 
                  " . ($edited_at === 'NOW()' ? "NOW()" : "'$edited_at'") . ")";

        if (!mysqli_query($Link, $query)) {
            setHTTPSStatus("500", "Error inserting todo from list");
        }
    } else {
        setHTTPSStatus("400", "Bad Request: Missing 'name' field");
    }
}


