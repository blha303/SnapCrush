<?php
define("UPLOAD_DIR", "/home/blha/sites/blha303.com.au/snapcrush/tmp/");
 
if (!empty($_FILES["myFile"])) {
    $myFile = $_FILES["myFile"];
 
    if ($myFile["error"] !== UPLOAD_ERR_OK) {
        echo "<p>An error occurred.</p>";
        exit;
    }
 
    // ensure a safe filename
    $name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);
 
    // don't overwrite an existing file
    $i = 0;
    $parts = pathinfo($name);
    while (file_exists(UPLOAD_DIR . $name)) {
        $i++;
        $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
    }
 
    // preserve file from temporary directory
    $success = move_uploaded_file($myFile["tmp_name"],
        UPLOAD_DIR . $name);
    if (!$success) { 
        echo "<p>Unable to save file.</p>";
        exit;
    }
 
    // set proper permissions on the new file
    chmod(UPLOAD_DIR . $name, 0644);

    $url = "https://mediacru.sh/api/upload/url";
    $query = http_build_query(array('url' => 'http://blha303.com.au/snapcrush/tmp/'.$name));
    $ch = curl_init( $url );
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    $response = json_decode(curl_exec( $ch ), true);
    unlink(UPLOAD_DIR . $name);
    if (isset($response['hash'])) {
        print "Now give this link to your friend: <a href='http://blha303.com.au/snapcrush/view.php?hash=".$response['hash']."'>Link</a><br>They'll be able to delete it when they're done.";
    } else {
        print "Error " . $response['error'];
    }
}
