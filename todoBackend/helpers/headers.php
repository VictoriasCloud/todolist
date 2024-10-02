<?php
function setHTTPSStatus($status = "200", $message = null) {
    switch ($status) {
        case "200":
            $statusHeader = "HTTP/1.1 200 OK";
            break;
        case "201":
            $statusHeader = "HTTP/1.1 201 Created";
            break;
        case "404":
            $statusHeader = "HTTP/1.1 404 Not Found";
            break;
        case "500":
            $statusHeader = "HTTP/1.1 500 Internal Server Error";
            break;
    }
    header($statusHeader);
    if ($message) {
        echo json_encode(['message' => $message]);
    }
}
