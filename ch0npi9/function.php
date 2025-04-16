<?php

function curl_load($url){
    curl_setopt($ch=curl_init(), CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

function getModule(){
    $url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $parsed_url = parse_url($url);
    $path = $parsed_url['path'];

	if(basename($path) == "media.php"){
		return $_GET['module'];
	}else{
		return basename($path);	
	}
}


function getUserLevel($obj){
	switch ($obj) { 
		case 1:
			return "Administrator";
			break;
		case 2:
			return "Admin";
			break;
		case 3:
			return "Afiliator";
			break;
		case 4:
			return "Calon Legislatif";
			break;
		case 5:
			return "Tim Sukses";
			break;
        case 6:
            return "Pengguna Baru";
            break;
	
	}
}

function getStatus($obj){
	switch ($obj) { 
		case 1:
			return "Aktif";
			break;
		case 2:
			return "Tidak Aktif";
			break;
		case 3:
			return "Dihapus";
			break;
		case 4:
			return "Menunggu Konfirmasi";
			break;
	}
}

function encryptUrl($url) {
    $arr = explode("&", $url);
    $module = explode("=", $arr[0])[1];
    $encrypted = base64_encode(implode("&", array_slice($arr, 1)));
    return [
        "module" => $module,
        "url" => $encrypted
    ];
}

function decryptUrl($array) {
    $decrypted = base64_decode($array["url"]);
    return "module=".$array["module"] . "&" . $decrypted;

	//module=kabkota&act=edit&id=3&tahun=2020
	//pages/kabkota?act=edit&id=3&tahun=2020
}

function uploadFile($namafileyangdiinginkan, $fileType = "image", $fileSize = 1000000, $uploadFolder = "") {

    $targetDir = "uploads/";
    
    $allowedTypes = ["image/jpeg", "image/png", "application/pdf"];
    $maxFileSize = $fileSize;
    $code = 0;
    $message = "";

    if (!isset($_FILES["file"]) || $_FILES["file"]["error"] === 4) {
        return [
            "code" => 2,
            "message" => "Sorry, no file was uploaded.",
        ];
    }
    
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    if (file_exists($targetFile)) {
        unlink($targetFile);
    }
    
    $fileName = basename($_FILES["file"]["name"]);
    $fileType_original = $_FILES["file"]["type"];

    if (!in_array($fileType_original, $allowedTypes)) {
        return [
            "code" => 400,
            "message" => "Invalid file type, only " . implode(", ", $allowedTypes) . " are allowed",
        ];
    }

    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    if ($fileType == "image") {
    $acceptedExtensions = array("jpg", "jpeg", "png", "gif");

    if (!in_array($fileExtension, $acceptedExtensions)) {
        return array("code" => 400, "message" => "Invalid image file type");
    }

    $targetDir .= "pictures/";
    } elseif ($fileType == "pdf") {
        if ($fileExtension != "pdf") {
            return array("code" => 400, "message" => "Invalid pdf file type");
        }

        $targetDir .= "documents/";
    } else {
        return array("code" => 400, "message" => "Invalid file type");
    }

	$targetDir .= $uploadFolder;
    

    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
  
    $targetFile = $targetDir . basename($namafileyangdiinginkan);
  
  
    if ($_FILES["file"]["size"] > $maxFileSize) {
        $code = 1;
        $message = "Sorry, your file is too large.";
    }
  
    if ($code === 0) {

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            
            $message = "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
        } else {
            $code = 1;
            $message = "Sorry, there was an error uploading your file.";
        }
    }
    
    return [
        "code" => $code,
        "message" => $message,
    ];
}


function sentEmail($toEmail,$nama_user,$type){
    
    if($type == "signup"){
        $message = '
        
        ';
    }elseif($type == "reset"){

    }
}
?>