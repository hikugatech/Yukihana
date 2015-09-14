<?php
set_time_limit(0);

// CURL Download
if(isset($_POST['curl'])){

$curl = addslashes($_POST['curl']);
$anu = explode('/', $curl);
$count = count($anu)-1;
 
$file = $curl;

    $ch = curl_init($file);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $data = curl_exec($ch);
    curl_close($ch);

    if (preg_match('/Content-Length: (\d+)/', $data, $matches)) {

        // Contains file size in bytes
        $contentLength = (int)$matches[1];

    }

$namefile = $anu[$count];


$allowext = array("mp4", "3gp", "mkv", "webm", "ass", "srt");
$cek = explode('.',$namefile);
$hit = count($cek)-1;


//security
if (!in_array($cek[$hit], $allowext)) {
	echo 'Not allow ext';
	exit;
}


if (isset($contentLength)) {
file_put_contents('cache/downtarget.txt', ''.$contentLength.'+'.$namefile.'+');
if (file_exists("upload/$namefile")){
unlink("upload/$namefile");
file_put_contents("upload/$namefile", fopen("$curl", 'r'));
} else {
file_put_contents("upload/$namefile", fopen("$curl", 'r'));
}
}
}


// Upload file
 if (isset($_FILES["file1"])){
if (empty($_FILES["file1"]["name"])) {
	echo 'NOT ALLOWED';
	exit();
}
 
$allowedExts = array("mp4", "3gp", "mkv", "webm", "ass");
$fileName = $_FILES["file1"]["name"]; // The file name
$fileTmpLoc = $_FILES["file1"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["file1"]["type"]; // The type of file it is
$fileSize = $_FILES["file1"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["file1"]["error"]; // 0 for false... and 1 for true
if (!$fileTmpLoc) { // if file not chosen
    echo "ERROR: Please browse for a file before clicking the upload button.";
    exit();
}
$anu = explode('.', $fileName);
$anu = $anu[1];
if (($fileSize <= 2000000000) && in_array($fileType, $allowedExts) || in_array($anu, $allowedExts)) {
if(move_uploaded_file($fileTmpLoc, "upload/$fileName")){
    echo "$fileName upload is complete";
} else {
    echo "move_uploaded_file function failed";
} 
} else {
	echo 'Ext Not allowed';
}
 }
 
 
 
 
 
 
 
 

?>