<?php
$title = 'encoder | Setting';
require_once ('incfiles/head.php');

if (isset($_POST['verify'])) {
	$ffmpeg1 = !empty($_POST['ffmpeg']) ? $_POST['ffmpeg']: $ffmpeg ;
	$user1 = !empty($_POST['user']) ? md5($_POST['user']) : $user;
	$passlama = !empty($_POST['pass']) ? md5($_POST['pass']): '';
	if ($pass == md5($passlama)){
		$passbaru = isset($_POST['pass1']) ? md5($_POST['pass1']): $pass;
		$pesan = 'pass error';
	} else {
		$passbaru = $pass;
	}
	$ffmpeg10bit1 = !empty($_POST['ffmpeg10bit']) ? $_POST['ffmpeg10bit'] : $ffmpeg10bit  ;
	$site1 = !empty($_POST['install']) ? $_POST['install'] : $site;
	$situs1 = $_SERVER['HTTP_HOST'];
	

	if (isset($pesan)) {
		echo $pesan;
	} else {
		$input = '<?php $ffmpeg = "'.$ffmpeg1.'";';
		$input .= '$ffmpeg10bit = "'.$ffmpeg10bit1.'";';
		$input .= '$site = "'.$site1.'";';
		$input .= '$user = "'.$user1.'";';
		$input .= '$pass = "'.$passbaru.'"; ?>';
		
		chmod("incfiles", 777);
		file_put_contents('incfiles/core.php', $input);
		chmod("incfiles", 755);
		header('location: index.php');
	}
}

echo '<div class="phdr"> Setting umum </div>';
echo '<div class="div-div">';
echo '<form action="" method="POST">';
echo 'Please input Here';
echo '<div> Location FFMPEG (linux directory) : <br />';
echo '<input type="text" name="ffmpeg" placeholder="ex : /home/bin/ffmpeg" />';
echo '</div>';
echo '<div> Location FFMPEG 10 bit (linux directory) : <br />';
echo '<input type="text" name="ffmpeg10bit" placeholder="ex : /home/bin/ffmpeg" />';
echo '</div>';
echo '<div> alamat situs : <br />';
echo '<input type="text" name="install" placeholder="http://anu.com" />';
echo '</div>';
echo '<input type="submit" name="verify" value="verify" />';
echo '</div>';

echo '<div class="phdr"> password </div>';
echo '<div class="div-div">';
echo '<div> pass lama : <br />';
echo '<input type="password" name="pass1" placeholder="ex : kopyor" />';
echo '</div>';
echo '<div> pass baru : <br />';
echo '<input type="password" name="pass" placeholder="ex : kopyor" />';
echo '</div>';
echo '<input type="submit" name="verify" value="verify" />';
echo '</div>';
echo '</form>';

echo '<div class="phdr"> Tentang </div>';
echo '<div class="div-div">';
echo '<p>Yukihana 1.0 (Ryuunosuke)</p>';
echo '<p>Aplikasi ini di buat oleh Master hafid.</p><p> lisensi GNU public license GPL v3</p>';
echo '</div>';

require_once ('incfiles/end.php');
?>