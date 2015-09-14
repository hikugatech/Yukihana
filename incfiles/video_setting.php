<?php
if (isset($_POST['step2'])) {
	//security
	$endtuneallow = array('film', 'animation', 'grain', 'stillimage', 'psnr', 'ssim', 'fastdecode', 'zerolatency');
	$endprofileallow = array('baseline', 'main', 'high');
	$endprofile10bitallow = array('high10', 'high422', 'high444');
	$endlevelallow = array('auto', 'level 1', 'level 1b', 'level 1.1', 'level 1.2', 'level 1.3', 'level 2', 'level 2.1', 'level 2.2', 'level 3', 'level 3.1', 'level 3.2', 'level 4', 'level 4.1', 'level 4.2', 'level 5', 'level 5.1', 'level 5.2');
	$endmodeallow = array('crf', 'pass1', 'pass2', 'pass3');
	$endpresentlabelallow = array('UltraFast', 'SuperFast', 'VeryFast', 'Faster', 'Fast', 'Medium', 'Slow', 'Slower', 'VerySlow', 'Placebo');
	$endpixfmtallow = array('yuv444p', 'yuv422p');
	
	//POST
	$endtune = in_array($_POST['end-tune'], $endtuneallow)? $_POST['end-tune'] : '';
	if (isset($_POST['end-profile-bit'])){
		$endprofile = in_array($_POST['end-profile'], $endprofile10bitallow)? $_POST['end-profile'] : '';
	} else {
		$endprofile = in_array($_POST['end-profile'], $endprofileallow)? $_POST['end-profile'] : '';		
	}
	if ($endprofile == 'high444' || $endprofile == 'high422'){
		$endpixfmt = in_array($_POST['end-pixfmt'], $endpixfmtallow)? $_POST['end-pixfmt'] : '';
	}
	$endlevel = in_array($_POST['end-level'], $endlevelallow)? $_POST['end-level'] : '';
	$endmode = in_array($_POST['end-mode'], $endmodeallow)? $_POST['end-mode'] : '';
	$endpresentlabel = strtolower(in_array($_POST['end-present-label'], $endpresentlabelallow)? $_POST['end-present-label'] : '');
	$endrate = intval(isset($_POST['end-rate'])? $_POST['end-rate'] : '0');
	
	//security POST
	if (empty($endtune) || empty($endprofile) || empty($endlevel) || empty($endmode) || empty($endpresentlabel) || empty($endrate) || $endrate < 0) {
		echo '<div class="rmenu">Error <br /> Empty/error your input</div>';
		require_once 'incfiles/end.php';
		exit;
	}
	
	//CLI mode
	$endpixfmt = isset($endpixfmt)? ' -pix_fmt '.$endpixfmt: '';
	$endtune = isset($endtune)? ' -tune '.$endtune :'';
	$endprofile = isset($endprofile)? ' -profile:v '.$endprofile :'';
	$endlevel = $endlevel != 'auto'? ' -'.$endlevel.' ' : '' ;
	$endmode = isset($endmode)? ''.$endmode :'';
	$endpresentlabel = isset($endpresentlabel)? ' -preset '.$endpresentlabel :'';
	if ($endmode != 'crf') {
		$endrate = ' -b:v '.$endrate.'k';
	} else {
		$endrate = ' -crf '.$endrate;
	}	
	$_SESSION['videosetting_pixfmt'] = $endpixfmt;
	$_SESSION['videosetting_tune'] = $endtune;
	$_SESSION['videosetting_profile'] = $endprofile;
	$_SESSION['videosetting_level'] = $endlevel;
	$_SESSION['videosetting_present'] = $endpresentlabel;
	$_SESSION['videosetting_rate'] = $endrate;
	$_SESSION['videosetting_mode'] = $endmode;
	$_SESSION['videosetting_profilebit'] = isset($_POST['end-profile-bit']) ? $_POST['end-profile-bit'] : '' ;
	header('location: convert.php?step=3');
}
echo '<form action="" method="POST">';

//#right#
echo '<div class="prus-right" style="width:100%; text-align:left;max-width:580px;">';

// Tuning
echo '<div class="xdiv">';
echo '<p>Tuning : ';
echo '<select name="end-tune">';
echo	 '<option value="film">film</option>';
echo	 '<option value="animation">animation</option>';
echo	 '<option value="grain">grain</option>';
echo	 '<option value="stillimage">stillimage</option>';
echo	 '<option value="psnr">psnr</option>';
echo	 '<option value="ssim">ssim</option>';
echo	 '<option value="fastdecode">fastdecode</option>';
echo	 '<option value="zerolatency">zerolatency</option>';
echo '</select></p>';
echo '</div>';

//Profile
echo '<div class="xdiv">';
echo '<p>Profile : ';
echo '<select name="end-profile" id="end-profile">';
echo '</select> Pixel Format <select name="end-pixfmt" id="end-pixfmt"></select></p>';
echo '<p><input type="checkbox" id="end-profile-bit" name="end-profile-bit" value="1" /> 10 Bit Encode</p>';
echo '</div>';

//Level
echo '<div class="xdiv">';
echo '<p>AVC Level : ';
echo '<select name="end-level">';
echo	 '<option value="auto">Auto</option>';
echo	 '<option value="level 1">level 1</option>';
echo	 '<option value="level 1b">level 1b</option>';
echo	 '<option value="level 1.1">level 1.1</option>';
echo	 '<option value="level 1.2">level 1.2</option>';
echo	 '<option value="level 1.3">level 1.3</option>';
echo	 '<option value="level 2">level 2</option>';
echo	 '<option value="level 2.1">level 2.1</option>';
echo	 '<option value="level 2.2">level 2.2</option>';
echo	 '<option value="level 3">level 3</option>';
echo	 '<option value="level 3.1">level 3.1</option>';
echo	 '<option value="level 3.2">level 3.2</option>';
echo	 '<option value="level 4">level 4</option>';
echo	 '<option value="level 4.1">level 4.1</option>';
echo	 '<option value="level 4.2">level 4.2</option>';
echo	 '<option value="level 5">level 5</option>';
echo	 '<option value="level 5.1">level 5.1</option>';
echo	 '<option value="level 5.2">level 5.2</option>';
echo '</select></p>';
echo '</div>';


echo '</div>';

//#left#
echo '<div class="prus-center" style="width:100%;max-width:580px">';

//encoding mode 
echo '<div class="xdiv">';
echo '<p>Encoding Mode : ';
echo '<select name="end-mode" id="end-mode">';
echo	 '<option value="crf">CRF</option>';
echo	 '<option value="pass1">Automatic Pass 1</option>';
echo	 '<option value="pass2">Automatic Pass 2</option>';
echo	 '<option value="pass3">Automatic Pass 3</option>';
echo '</select>';
echo '&nbsp;<kp id="end-rate-bt">Quality</kp>&nbsp;<input type="number" name="end-rate" id="end-rate" placeholder="input rate"></p>';
echo '</div>';

//present
echo '<div class="xdiv" style="padding-top:27px; padding-bottom:27px;">';
echo '<p style="padding-bottom:10px;">Present : ';
echo '&nbsp;<input type="hidden" name="end-present-label" id="end-present-label1" /><kp id="end-present-label"></kp>&nbsp;</p>';
echo '<input type="range" min="1" max="10" value="6" id="end-present-rate" name="end-present-rate" />';
echo '</div>';

echo '</div>';

//submit
echo '<input type="submit" name="step2" value="NEXT >>" />';
echo '</form>';

?>
<script>
//var id
var endmode = document.getElementById("end-mode");
var endratebt = document.getElementById("end-rate-bt");
var endrate = document.getElementById("end-rate");
var endpresentlabel = document.getElementById("end-present-label");
var endpresentlabel1 = document.getElementById("end-present-label1");
var endmode = document.getElementById("end-mode");
var endpresentrate = document.getElementById("end-present-rate");
var endprofile = document.getElementById("end-profile");
var endprofilebit = document.getElementById("end-profile-bit");
var endpixfmt = document.getElementById("end-pixfmt");

//event
endmode.addEventListener("change", encodmode, false);
endpresentrate.addEventListener("change", encodpresent, false);
endprofilebit.addEventListener("change", encodprofilebit, false);
endprofile.addEventListener("change", encodpixfmt, false);

//startup
encodpresent();
encodmode();
encodprofilebit();

//function
function encodmode() {
	if (endmode.value != 'crf') {
		endrate.value = '1000';
		endratebt.innerHTML = 'Bitrate';
	} else {
		endrate.value = '24';
		endratebt.innerHTML = 'Quality';
	}
}

function encodprofilebit() {
	if (endprofilebit.checked == true) {
		endprofile.innerHTML = '<option value="high10">high10</option><option value="high422">high422</option><option value="high444">high444</option>';
	} else {
		endprofile.innerHTML = '<option value="baseline">baseline</option><option value="main">main</option><option value="high">high</option>';
	}
}

function encodpixfmt() {
	if (endprofile.value == 'high422') {
		endpixfmt.innerHTML = '<option value="yuv422p">yuv422p</option>';
	} else if (endprofile.value == 'high444'){
		endpixfmt.innerHTML = '<option value="yuv422p">yuv422p</option><option value="yuv444p">yuv444p</option>';
	}
}

function encodpresent() {
	if (endpresentrate.value == '1' ){
		endpresentlabel.innerHTML = 'UltraFast';
		endpresentlabel1.value = 'UltraFast';
	} else if (endpresentrate.value == '2'){
		endpresentlabel.innerHTML = 'SuperFast';
		endpresentlabel1.value = 'SuperFast';
	} else if (endpresentrate.value == '3'){
		endpresentlabel.innerHTML = 'VeryFast';
		endpresentlabel1.value = 'VeryFast';
	} else if (endpresentrate.value == '4'){
		endpresentlabel.innerHTML = 'Faster';
		endpresentlabel1.value = 'Faster';
	} else if (endpresentrate.value == '5'){
		endpresentlabel.innerHTML = 'Fast';
		endpresentlabel1.value = 'Fast';
	} else if (endpresentrate.value == '6'){
		endpresentlabel.innerHTML = 'Medium';
		endpresentlabel1.value = 'Medium';
	} else if (endpresentrate.value == '7'){
		endpresentlabel.innerHTML = 'Slow';
		endpresentlabel1.value = 'Slow';
	} else if (endpresentrate.value == '8'){
		endpresentlabel.innerHTML = 'Slower';
		endpresentlabel1.value = 'Slower';
	} else if (endpresentrate.value == '9'){
		endpresentlabel.innerHTML = 'VerySlow';
		endpresentlabel1.value = 'VerySlow';
	} else if (endpresentrate.value == '10'){
		endpresentlabel.innerHTML = 'Placebo';
		endpresentlabel1.value = 'Placebo';
	}
}


</script>