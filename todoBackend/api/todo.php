<?php
include_once 'getAllTodos.php';
include_once 'createTodo.php';
include_once 'updateTodoNameById.php';
include_once 'getTodoById.php';
include_once 'updateTodoStatusById.php';
include_once 'deleteTodoById.php';
include_once 'loadTodosFromList.php';

function route($method, $urlList,  $requestData) {

    switch ($method) {
        
        case 'GET':
            switch ($urlList[2]){
                
                case 'getAllTodos':  
                    getAllTodos();
                    break;
                case 'getTodoById':  
                    getTodoById();
                    break;        
            }
            break;
        case 'POST':
            // Добавляем обработку POST-запросов с использованием case
            switch ($urlList[2]) {
                case 'createTodo':
                    createTodo($requestData);  // Создание одного дела
                    break;
                case 'loadTodosFromList':
                    loadTodosFromList($requestData);  // Загрузка списка дел
                    break;
                default:
                    setHTTPSStatus("400", "Bad Request: Invalid POST route");
                    break;
            }
            break;
        case 'PUT':
            switch ($urlList[2]) {
                // Если запрос направлен на обновление имени задачи
                case 'updateTodoNameById':
                    updateTodoNameById();  
                    break;
    
                // Если запрос направлен на обновление статуса задачи
                case 'updateTodoStatusById':
                    updateTodoStatusById();  
                    break;

                // Если маршрут не соответствует известным путям
                default:
                    setHTTPSStatus("400", "Bad Request: Invalid update route");
                    break;
            }
            break;
            
        case 'DELETE':
            deleteTodoById();  // Удаление задачи через параметр запроса
            break;

        default:
            setHTTPSStatus("405", "Method Not Allowed");
    }
}
