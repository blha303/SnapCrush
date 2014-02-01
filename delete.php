<?php
set_error_handler(
    create_function(
        '$severity, $message, $file, $line',
        'throw new ErrorException($message, $severity, $severity, $file, $line);'
    )
);
if (!isset($_GET['hash'])) {
    header('Location: index.php');
}
$url = "https://mediacru.sh/api/".$_GET['hash'];
try {
    $context = stream_context_create(array(
        'http' => array(
            'method' => 'DELETE'
        )
    ));
    $response = json_decode(file_get_contents($url, false, $context), true);
    if (isset($response['status'])) {
        if ($response['status'] == "success") {
            echo "File deleted successfully.";
        } else {
            echo $response['status'];
        }
    } else {
        echo "Error ".$response['error'];
    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    if (strpos($msg, '404 NOT FOUND') !== false) {
        echo "File already deleted.";
    } else if (strpos($msg, '401 UNAUTHORIZED') !== false) {
        echo "File not uploaded by SnapCrush.";
    } else {
        echo substr($msg, strpos($msg, 'HTTP/1.1 ') + 1);
    }
}
restore_error_handler();
