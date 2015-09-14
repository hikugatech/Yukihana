<?php
$title = 'encoder | Convert';
require_once ('incfiles/head.php');

if ($handle = opendir('upload')) {
	$no = 0;
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
			$files[$no] = $entry;
			$no++;
        }
    }
    closedir($handle);
}
$kk = isset($_POST['filename']) ? $_POST['filename'] : !empty($_SESSION['filename']);
if (in_array($kk, $files)) {
	
	
switch (isset($_GET['step'])?$_GET['step']:'') {
	
	//video setting
	case '2':
	echo '<div class="phdr"> Convert | Video Setting </div>';
	echo '<div class="div-div">';
	echo '<div class="menu">Input file : <b>'.$_SESSION['filename'].'</b></div>';
	require_once ('incfiles/video_setting.php');
	echo '</div>';
	break;
	
	//audio setting
	case '3':
	echo '<div class="phdr"> Convert | Audio Setting </div>';
	echo '<div class="div-div">';
	echo '<div class="menu">Input file : <b>'.$_SESSION['filename'].'</b></div>';
	require_once ('incfiles/audio_setting.php');
	echo '</div>';
	break;
	
	//Subtitle setting
	case '4':
	echo '<div class="phdr"> Convert | Subtitle Setting </div>';
	echo '<div class="div-div">';
	echo '<div class="menu">Input file : <b>'.$_SESSION['filename'].'</b></div>';
	//echo $_SESSION['video_setting'].$_SESSION['audio_setting'];
	require_once ('incfiles/sub_setting.php');
	echo '</div>';
	break;
	
	//muxing all
	case '5':
	echo '<div class="phdr"> Convert | Subtitle Setting </div>';
	echo '<div class="div-div">';
	echo '<div class="menu">Input file : <b>'.$_SESSION['filename'].'</b></div>';
	require_once ('incfiles/muxing_all.php');
	echo '</div>';
	break;
	
	//format setting
	default:
	echo '<div class="phdr"> Convert | Target Format </div>';
	echo '<div class="div-div">';
	$_SESSION['filename'] = isset($_POST['filename']) ? $_POST['filename'] : $_SESSION['filename'] ;
	echo '<div class="menu">Input file : <b>'.$_SESSION['filename'].'</b></div>';
	require_once ('incfiles/format_setting.php');
	echo '</div>';
	break;
}
} else {
		echo '<div class="rmenu">Error <br /> Empty/error your input</div>';
		require_once 'incfiles/end.php';
		exit;
}

require_once ('incfiles/end.php');
?>