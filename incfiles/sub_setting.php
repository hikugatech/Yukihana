<?php
if (isset($_POST['step-3'])) {
	//security
	$suballow = array("ass", "srt", "ssa", "sub");
	
	//POST
	$endhardsub = !empty($_POST['end-hard-sub'])?intval($_POST['end-hard-sub']): '0';
	$endextsub = !empty($_POST['end-ext-sub']) ? intval($_POST['end-ext-sub']) : '' ;
	if (!empty($endextsub)) {
		$filenamesub = isset($_POST['filename-sub'])? $_POST['filename-sub'] : '' ;
		$fnamearray = explode('.', $filenamesub);
		$count = count($fnamearray)-1;
		$filenamesub = in_array($fnamearray[$count], $audioallow) ? $filenamesub : '' ;
		$extsub = $fnamearray[$count] == 'ass' ? $fnamearray[$count] : '' ;
	}
	
	//CLI
	$externalsub = !empty($filenamesub) ? $filenamesub : "cache/'".$_SESSION["filename"]."+extract.ass'" ;
	if ($endhardsub == true){
		$_SESSION['hardsub'] = $externalsub;
		$_SESSION['softsub'] = '';
	} else {
		$_SESSION['softsub'] = $externalsub;
		$_SESSION['hardsub'] = '';
	}
	//echo $_SESSION['softsub'].$_SESSION['hardsub'];
	header('location: convert.php?step=5');
}
echo '<form action="" method="POST">';

//hardsub
echo '<div class="xdiv">';
echo '<input type="checkbox" name="end-hard-sub" value="1" /> Hardsub';
echo '</div>';

//extern
echo '<div class="xdiv">';
echo 'Tambahan :<br />';
echo '<input type="checkbox" name="end-ext-sub" id="end-ext-sub" value="1" /> Sumber external sub (bukan dari video)';
echo '</div>';

$suballow = array("ass", "srt", "ssa", "sub");
echo '<div id="guardian1">';
if ($handle = opendir('upload')) {
	$no = 1;
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != ".." && in_array(strtolower(substr($entry, strrpos($entry, '.') + 1)), $suballow) ) {
			echo '<p>';
            echo '<input name="filename-sub" type="radio" value="'.$entry.'"> '.$entry.'';
			echo '</p>';
			$no++;
        }
    }
    closedir($handle);
}
echo '</div>';

echo '<input type="submit" name="step-3" value="Next >>" />';
echo '</form>';
?>
<script>
//var id
var endextsub = document.getElementById("end-ext-sub");
var guardian1 = document.getElementById("guardian1");

//event
endextsub.addEventListener("change", encodexternalinput, false);

//startup
encodexternalinput();

//function
function encodexternalinput() {
	if (endextsub.checked == true){
		guardian1.style.display = 'block';
	} else {
		guardian1.style.display = "none";
	}
}




</script>