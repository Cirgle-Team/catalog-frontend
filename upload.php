<?php
if($_FILES['file']['error'] !== 0) {
    die(json_encode(array("result"=>"-1", "error"=>"파일 업로드에 실패했습니다")));
}

$name = $_FILES['file']['name'];
$ext = strtolower(end(explode('.', $name)));
$volume = $_FILES['file']['size'];
$date = strtotime("now");

$upload_name = base64_encode($name);

if($name = "") {
    die(json_encode(array("result"=>"-1", "error"=>"파일 업로드에 실패했습니다")));
}

if(strpos($ext, "php") !== false || strpos($ext, "htm") !== false || strlen($ext) > 5) {
    die(json_encode(array("result"=>"-1", "error"=>"허용되지 않는 확장자입니다!")));
}

if(!move_uploaded_file($_FILES['file']['tmp_name'],"./Uploaded/".$upload_name.".".$ext)){
    die(json_encode(array("result"=>"-1", "error"=>"파일 업로드에 실패했습니다")));
}

#base64Encode

die(json_encode(array("result"=>"0", "file"=>"/Uploaded/$upload_name.$ext", "volume"=>$volume)));

?>