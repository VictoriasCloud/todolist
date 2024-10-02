<?php
// Создание нового дела
function createTodo($requestData) {
    global $Link;
    $data = $requestData->body;

    if (isset($data->name)) {
        $name = $data->name;
        $query = "INSERT INTO todo (name, done, created_at, edited_at) VALUES ('$name', 0, NOW(), NOW())";
        if (mysqli_query($Link, $query)) {
            setHTTPSStatus("201", "Todo created");
        } else {
            setHTTPSStatus("500", "Error creating todo");
        }
    } else {
        setHTTPSStatus("400", "Bad Request: Missing 'name' field");
    }
}