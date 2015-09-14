<?php

$title = 'encoder | File manager';
require_once ('incfiles/head.php');

echo '<div class="phdr"> File Manager </div>';
echo '<div class="div-div">';

$situs = $_SERVER['HTTP_HOST'];

//*core*
//Download file
if (isset($_GET['download'])){
	$files = rawurldecode($_GET['download']);
	$nb = explode('.', $files);
	$count = count($nb)-1;
	$file = 'upload/'.$files;
	
	header('location: '.$file.'');
	
//echo $file;
}

//Delete file
if (isset($_GET['delete'])){
	$filename = urldecode($_GET['delete']);
	unlink ('upload/'.$filename);
	header('location: manager.php');

//Rename step 1
} else if (isset($_POST['after'])){	
	$filename = $_POST['home1'];
	$nmafter = explode(".", $_POST['after']);
	$anu = $_POST['after'];
	$allowedExts = array("mp4", "3gp", "mkv", "webm", "ass", "jpg");
	
	if (in_array($nmafter[1], $allowedExts)) {
		rename('upload/'.$filename.'', 'upload/'.$anu.'');
		echo '<div class="gmenu">Sukses</div>';
		echo '<a href="manager.php">Next</a>';
	} else {
		echo '<div class="rmenu">Ext not allowed</div>';
		echo '<a href="manager.php">Next</a>';
	}

//Rename step 2	
} else if (isset($_GET['rename'])){
	$filename = urldecode($_GET['rename']);
	echo 'before Rename : '.$filename.'';
	echo '<form action="" name="kiki" method="post">';
	echo '<p><input type="text" name="after" placeholder="masukkan textnya" style="width:350px;" /></p>';
	echo '<button href="#" onclick="javascript:document.kiki.submit();" />Rename</button>';
	echo '<input type="hidden" name="home1" value="'.$filename.'">';
	echo '</form>';
	
} else {

//tampilan
$ext = array("mp4", "3gp", "mkv", "webm", "ass", "jpg");
echo '<form action="convert.php" method="POST">';
echo '<input type="submit" name="goto" value="Convert">';
$dir = 'upload';
if (is_dir($dir)) {
	if ($handle = opendir($dir)) {
		while (false !== ($entry = readdir($handle))) {
			$lavu = explode('.', $entry);
			$count =  count($lavu)-1;
			if ($entry != "." && $entry != ".." && in_array($lavu[$count], $ext)) {
				echo '<p><input type="radio" value="'.$entry.'" name="filename"> <a href="manager.php?download='.rawurlencode($entry).'">'.$entry.'</a> [ <a href="manager.php?rename='.urlencode($entry).'">Rename</a> ] | [ <a href="manager.php?delete='.urlencode($entry).'">Delete</a> ]</p>';
			}
		}
		closedir($handle);
	}
}
echo '</form>';
}
echo '</div>';


require_once ('incfiles/end.php');
?>