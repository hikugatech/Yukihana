<?php

	
	if (isset($_POST['format'])) {
		//security
		$endchangeratiorateallow = array('16:9', '4:3');
		$extallow = array('mkv', 'mp4');
		
		//POST
		$_SESSION['format_format'] = in_array($_POST['format'], $extallow) ? ''.$_POST['format'].'' : '' ;
		$endchangeresolution = !empty($_POST['end-change-resolution']) ? intval($_POST['end-change-resolution']) : '0';
		$endchangeratio = !empty($_POST['end-change-ratio']) ? intval($_POST['end-change-ratio']) : '0';
		if (!empty($endchangeresolution)) {
			$endchangereswidth = !empty($_POST['end-change-res-width']) ? intval($_POST['end-change-res-width']) : '' ;			
			$endchangeresheight = !empty($_POST['end-change-res-height']) ? intval($_POST['end-change-res-height']) : '' ;
		}
		if (empty($endchangereswidth) || empty($endchangeresheight)){
			$endchangeresolution = '';
		}
		if (!empty($endchangeratio)) {
			$endchangeratiorate = in_array($_POST['end-change-ratio-rate'], $endchangeratiorateallow) ? $_POST['end-change-ratio-rate'] : '' ;
		}
		
		//CLI
		$_SESSION['format_changeresolution'] = !empty($endchangeresolution) ? $endchangereswidth.'x'.$endchangeresheight : '' ;
		$_SESSION['format_changeratio'] = !empty($endchangeratio) && isset($endchangeratiorate) ? $endchangeratiorate : '' ;
	//	echo $_SESSION['format_format'];
		header('location: convert.php?step=2');
	}
	
	echo '<form action="" name="keok" method="POST">';
	echo '<div class="xdiv">';
	echo '<p>Output Format</p>';
	echo '<p><select name="format">';
	$ac = explode('+', $_SESSION['format']);
	if (isset($_SESSION['format'])){
		echo '<option value="'.$ac[0].'">'.$ac[0].'</option>';
	}
	echo '<option value="mkv">Matroska File (MKV)</option>';
	echo '<option value="mp4">MPEG-4 (MP4)</option>';
	echo '</select></p>';
	echo '</div>';
	echo '<div class="xdiv">';
	echo '<input type="checkbox" name="end-change-resolution" id="end-change-resolution" value="1" /> Ganti resolusi';
	echo '<div id="end-change-res-display">';
	echo '<input type="number" name="end-change-res-width" placeholder="lebar" id="end-change-res-width" /> X <input type="number" name="end-change-res-height" id="end-change-res-height" placeholder="Tinggi" />';
	echo '</div>';
	echo '</div>';
	echo '<div class="xdiv">';
	echo '<input type="checkbox" name="end-change-ratio" id="end-change-ratio" value="1" /> Ganti resolusi';
	echo '<div id="end-change-ratio-display">';
	echo '<select name="end-change-ratio-rate">';
		echo '<option value="16:9">16:9</option>';
		echo '<option value="4:3">4:3</option>';
	echo '</select>';
	echo '</div>';
	echo '</div>';
	echo '<button href="#" onclick="javascript:document.keok.submit();">NEXT >> </button>';
	echo '</form>';
?>
<script>
//var
var endchangeratio = document.getElementById("end-change-ratio");
var endchangeresolution = document.getElementById("end-change-resolution");
var endchangereswidth = document.getElementById("end-change-res-width");
var endchangeresheight = document.getElementById("end-change-res-height");
var endchangeresdisplay = document.getElementById("end-change-res-display");
var endchangeratiodisplay = document.getElementById("end-change-ratio-display");

//event
endchangeresolution.addEventListener("change", encodchangeresolution, false);
endchangeratio.addEventListener("change", encodchangeratio, false);
endchangereswidth.addEventListener("change", encodchangereswidth, false);

//startup
encodchangeresolution();
encodchangereswidth();
encodchangeratio();

//function
function encodchangeresolution() {
	if (endchangeresolution.checked == true){
		endchangeresdisplay.style.display = 'block';
	} else {
		endchangeresdisplay.style.display = "none";
	}
}
function encodchangeratio() {
	if (endchangeratio.checked == true){
		endchangeratiodisplay.style.display = 'block';
	} else {
		endchangeratiodisplay.style.display = "none";
	}
}
function encodchangereswidth() {
	if (endchangereswidth.value == '1280') {
		endchangeresheight.value = '720';
	} else if (endchangereswidth.value == '848') {
		endchangeresheight.value = '480';		
	} else if (endchangereswidth.value == '640') {
		endchangeresheight.value = '360';		
	} else if (endchangereswidth.value == '320') {
		endchangeresheight.value = '240';		
	}	
}
</script>