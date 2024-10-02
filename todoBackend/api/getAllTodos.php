<?php

// Получение всех дел
function getAllTodos() {
    global $Link;

    $query = "SELECT id, name, done, edited_at, created_at FROM todo";
    $result = mysqli_query($Link, $query);

    $todos = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Приводим поле done к числовому значению
        $row['done'] = intval($row['done']);
        $todos[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($todos);
}
