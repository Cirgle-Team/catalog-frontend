<?php
error_reporting( E_ALL );
ini_set( "display_errors", 1 );
if (!isset($_POST["req"], $_POST["path"])) {
    die("{\"code\":\"invalid-000\", \"message\":\"Invalid Request\"}");
}

$BASE_URL = "http://localhost:8080/";
$headers = array('Content-Type: application/json');
if (isset($_POST["header"])) {
    array_push($headers, $_POST["header"]);
}

$ch = curl_init($BASE_URL.$_POST["path"]);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_POST, true);
if (isset($_POST["method"])) {
    if ($_POST["method"] == "GET") {
        curl_setopt($ch,CURLOPT_POST, false);
    }
    if ($_POST["method"] == "POST") {
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $_POST["req"]);
    }
    if ($_POST["method"] == "DELETE") {
        //curl_setopt($ch,CURLOPT_POST, false);
        die("아직 구현 안했어 이 씨발롬아");
    }
} else {
    curl_setopt($ch,CURLOPT_POSTFIELDS, $_POST["req"]);
}
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
if (strpos($result, "GMT") !== FALSE) {
    if (strpos($result, "close") !== FALSE) {
        die(substr($result, strpos($result, "close")+7));
    } else {
        die(substr($result, strpos($result, "GMT")+4));
    }
} else {
    die(substr($result, strpos($result, "close")+7));
}
?>