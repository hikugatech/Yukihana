<?php session_start();

if (file_exists('incfiles/core.php')){
	require_once 'incfiles/core.php';
} else {
	echo 'Please install first!!!!';
	exit;
}

if (empty($_SESSION['user_login']) || empty($_SESSION['pass_login']) || $_SESSION['pass_login'] != $pass || $_SESSION['user_login'] != $user){
	
	if (isset($_POST['log-in'])){
		$username = check($_POST['user']);
		$password = check($_POST['pass']);
		
		if (empty($username) || empty($password) || md5($password) != $pass || md5($username) != $user) {
			echo 'login Failed';
		} else {
			$_SESSION['user_login'] = md5($username);
			$_SESSION['pass_login'] = md5($password);
			header('location: manager.php');
		}
	}
	
	echo '<form action="" method="POST">';
	echo '<div> Username : <br />';
	echo '<input type="text" placeholder="Username" name="user" /></div>';
	echo '<div> Password : <br />';
	echo '<input type="password" placeholder="password" name="pass" /></div>';
	echo '<input type="submit" name="log-in" value="Login" />';
	echo '</form>';
	
	exit;
} 

echo'<!DOCTYPE html>' .
    "\n" . '<html lang="ID">' .
    "\n" . '<head>' .
    "\n" . '<meta charset="utf-8">' .
    "\n" . '<meta http-equiv="X-UA-Compatible" content="IE=edge"">' .
    "\n" . '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">' .
    "\n" . '<meta name="HandheldFriendly" content="true">' .
    "\n" . '<meta name="MobileOptimized" content="width">' .
    "\n" . '<meta content="yes" name="apple-mobile-web-app-capable">' .
    "\n" . '<meta name="Generator" content="">' .
 //   (!empty($set['meta_key']) ? "\n" . '<meta name="keywords" content="' . $set['meta_key'] . '">' : '') .
   // (!empty($set['meta_desc']) ? "\n" . '<meta name="description" content="' . $set['meta_desc'] . '">' : '') .
    "\n" . '<link href="'.$site.'/css/bootstrap.min.css" rel="stylesheet">' .
    "\n" . '<link href="'.$site.'/css/simple-sidebar.css" rel="stylesheet">' . 
	"\n" . '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' .
    "\n" . '<link href="'.$site.'/css/style.css" rel="stylesheet">' . 
	"\n" . '<link rel="shortcut icon" href="favicon.ico">' .
	"\n" . '<title>' . $title . '</title>' .
    "\n" . '</head><body>';
	
		 
	
	

echo '<div class="header">';
echo '<div class="one"><div class="two" style="float : left;font-weight: bold;"><a href="'.$site.'">Yukihana</a> </div><div class="two" style="margin-right:20px;">&nbsp;&nbsp;<a href="'.$site.'setting.php">Setting</a></div><div class="two">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$site.'manager.php" style="margin-right:20px;">File Manager</a></div></div>';
echo '</div>'; 
echo '<div class="maintxt">';



function checkin($str) {
	if (function_exists('iconv')) {
		$str = iconv("UTF-8", "UTF-8", $str);
	}

	// Фильтруем невидимые символы
	$str = preg_replace('/[^\P{C}\n]+/u', '', $str);
	return trim($str);
}
function check($str){
	$str = htmlspecialchars(trim($str), ENT_QUOTES | ENT_IGNORE, 'UTF-8'); 
	$str = htmlentities(trim($str), ENT_QUOTES | ENT_IGNORE, 'UTF-8');
	$str = checkin($str);
	$str = nl2br($str);
	$str = addslashes($str);
	$str = stripslashes($str);
	
	return $str;
}




?>