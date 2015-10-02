<?php
if (isset($_POST['verify'])) {
	$ffmpeg = isset($_POST['ffmpeg']) ? $_POST['ffmpeg']: '';
	$user = isset($_POST['user']) ? md5($_POST['user']) : '';
	$pass = isset($_POST['pass']) ? md5($_POST['pass']): '';
	$ffmpeg10bit = isset($_POST['ffmpeg10bit']) ? $_POST['ffmpeg10bit'] : '' ;
	$site = isset($_POST['install']) ? $_POST['install'] : '/';
	$situs = $_SERVER['HTTP_HOST'];
	
	if (empty($ffmpeg) || empty($user) || empty($pass)) {
		echo 'please input here';
	} else {
		$input = '<?php $ffmpeg = "'.$ffmpeg.'";';
		$input .= '$ffmpeg10bit = "'.$ffmpeg10bit.'";';
		$input .= '$site = "'.$site.'";';
		$input .= '$user = "'.$user.'";';
		$input .= '$pass = "'.$pass.'"; ?>';
		
		@chmod("incfiles", 777);
		@chmod("cache", 777);
		@chmod("upload", 777);
		@file_put_contents('incfiles/core.php', $input);
		@chmod("incfiles", 755);
		@unlink('install.php');
		header('location: index.php');
	}
	echo 'anu';
}
echo '<form action="" method="POST">';
echo 'Please input Here';
echo '<div> Location FFMPEG (linux directory) : <br />';
echo '<input type="text" name="ffmpeg" placeholder="ex : /home/bin/ffmpeg" />';
echo '</div>';
echo '<div> Location FFMPEG 10 bit (linux directory) : <br />';
echo '<input type="text" name="ffmpeg10bit" placeholder="ex : /home/bin/ffmpeg" />';
echo '</div>';
echo '<div> Alamat situs : <br />';
echo '<input type="text" name="install" placeholder="http://anu.com" />';
echo '</div>';
echo '<div> User Login : <br />';
echo '<input type="text" name="user" placeholder="ex : kopyor" />';
echo '</div>';
echo '<div> pass login : <br />';
echo '<input type="text" name="pass" placeholder="ex : kopyor" />';
echo '</div>';
echo '<input type="submit" name="verify" value="verify" />';
echo '</form>';
?>