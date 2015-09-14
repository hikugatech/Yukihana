<?php

if (isset($_POST['step-3'])){
	//security
	$endsamplingallow = array('8000', '11025', '22050', '32000', '44100', '48000', '96000');
	$endchannelallow = array('1', '2', '3', '4', '5', '6');
	$audioallow = array("mp4", "aac", "mp3", "mkv");
	
	//POST
	$endsampling = in_array($_POST['end-sampling'], $endsamplingallow)? $_POST['end-sampling'] : '' ;
	$endchannel = in_array($_POST['end-channel'], $endchannelallow)? $_POST['end-channel'] : '' ;
	$endbitrateaudio = intval($_POST['end-bitrate-audio']) > 0 ? intval($_POST['end-bitrate-audio']) : '0' ;
	$endexternalinputext = !empty($_POST['end-external-inputext']) ? intval($_POST['end-external-inputext']) : '' ;

	if (!empty($endexternalinputext)) {
		$filenameaudio = isset($_POST['filename-audio'])? $_POST['filename-audio'] : '' ;
		$fnamearray = explode('.', $filenameaudio);
		$count = count($fnamearray)-1;
		$filenameaudio = in_array($fnamearray[$count], $audioallow) ? $filenameaudio : '' ;
	}
	
	//security
	if (empty($endsampling) || empty($endchannel) || empty($endbitrateaudio)){
		echo '<div class="rmenu">Error <br /> Empty/error your input</div>';
		require_once 'incfiles/end.php';
		exit;
	}
	
	//CLI mode
	$endsampling = isset($endsampling)? ' -ar '.$endsampling :'';
	$endchannel = isset($endchannel)? ' -ac '.$endchannel :'';	
	$endbitrateaudio = isset($endbitrateaudio)? ' -b:a '.$endbitrateaudio.'k' :'';
	$externalaudio = !empty($filenameaudio) && !empty($endexternalinputext) ? ' -i "upload/'.$filenameaudio.'"' :'';
	$_SESSION['audiosetting_externalaudio'] = $externalaudio;
	$_SESSION['audiosetting_bitrateaudio'] = $endbitrateaudio;
	$_SESSION['audiosetting_channel'] = $endchannel;
	$_SESSION['audiosetting_sampling'] = $endsampling;
	header('location: convert.php?step=4');
}

echo '<form action="" method="POST">';

//#right#
echo '<div class="prus-right" style="width:100%; text-align:left;max-width:580px;">';
echo '<div class="xdiv">';
echo 'Audio Sampling : <select name="end-sampling">';
	echo '<option value="8000">8000 Hz</option>';
	echo '<option value="11025">11025 Hz</option>';
	echo '<option value="22050">22050 Hz</option>';
	echo '<option value="32000">32000 Hz</option>';
	echo '<option value="44100">44100 Hz</option>';
	echo '<option value="48000" selected>48000 Hz</option>';
	echo '<option value="96000">96000 Hz</option>';
echo '</select>';
echo '</div>';
echo '</div>';


//#left#
echo '<div class="prus-center" style="width:100%;max-width:580px">';

//channel audio
echo '<div class="xdiv">';
echo 'Audio Channels : <select name="end-channel">';
	echo '<option value="1">Mono</option>';
	echo '<option value="2" selected>Stereo</option>';
	echo '<option value="3">Stereo/surround (3 speaker)</option>';
	echo '<option value="4">Surround 4 channel</option>';
	echo '<option value="5">Surround 5 channel</option>';
	echo '<option value="6">Surround 6 channel</option>';
echo '</select>';
echo '</div>';

echo '</div>';

//#Center#
echo '<div class="xdiv">';
echo 'Bitrate : <input type="number" name="end-bitrate-audio" placeholder="bitrate" value="128" /> Kbps';
echo '</div>';

echo '<div class="xdiv">';
echo 'External :<br />';
echo '<input type="checkbox" name="end-external-inputext" id="end-external-inputext" value="1" /> Sumber external (bukan dari video)';
echo '</div>';

$audioallow = array("mp4", "aac", "mp3", "mkv");

echo '<div id="guardian">';
if ($handle = opendir('upload')) {
	$no = 1;
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != ".." && in_array(strtolower(substr($entry, strrpos($entry, '.') + 1)), $audioallow) ) {
			echo '<p>';
            echo '<input name="filename-audio" type="radio" value="'.$entry.'"> '.$entry.'';
			echo '</p>';
			$no++;
        }
    }
    closedir($handle);
}
echo '</div>';

echo '<input type="submit" name="step-3" value="NEXT >>" />';
echo '</form>';
?>
<script>
//var id
var endexternalinputext = document.getElementById("end-external-inputext");
var guardian = document.getElementById("guardian");

//event
endexternalinputext.addEventListener("change", encodexternalinput, false);

//startup
encodexternalinput();

//function
function encodexternalinput() {
	if (endexternalinputext.checked == true){
		guardian.style.display = 'block';
	} else {
		guardian.style.display = "none";
	}
}




</script>