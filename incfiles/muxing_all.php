<?php

$cache = 'cache/';
$tenbit = $_SESSION['videosetting_profilebit'];
file_put_contents(''.$cache.'video', '');

//extract 
//extract video 
$extract = $ffmpeg.' -y -i "upload/'.$_SESSION['filename'].'" -c:v copy -an "'.$cache.$_SESSION['filename'].'+extract.'.$_SESSION['format_format'].'"';
$extract .= ' 1> '.$cache.'output.txt 2>&1 && ';
//extract audio
$extract .= $ffmpeg.' -y -i "upload/'.$_SESSION['filename'].'" -vn -c:a copy "'.$cache.$_SESSION['filename'].'+extractaac.mp4"';
$extract .= ' 1> '.$cache.'output.txt 2>&1 && ';
//extract sub
$extract .= $ffmpeg.' -y -i "upload/'.$_SESSION['filename'].'" -vn -an "'.$cache.$_SESSION['filename'].'+extract.ass"';
$extract .= ' 1> '.$cache.'output.txt 2>&1 && ';


//input
//video input
if (empty($tenbit)) {
$inputvideo = $ffmpeg.' -y -i "'.$cache.$_SESSION['filename'].'+extract.'.$_SESSION['format_format'].'"';
} else {
$inputvideo = $ffmpeg10bit.' -y -i "'.$cache.$_SESSION['filename'].'+extract.'.$_SESSION['format_format'].'"';
}
//audio input
$inputaudio = $ffmpeg;
$inputaudio .= empty($_SESSION['audiosetting_externalaudio'])? ' -y -i "'.$cache.$_SESSION['filename'].'+extractaac.mp4"' : $_SESSION['audiosetting_externalaudio'];

//subtitle input SOFTSUB
if (!empty($_SESSION['softsub'])) {
	$softsub = ' -i '.$_SESSION['softsub'].'';
	$scodecsub = ' -scodec copy';
	$mapsubs = ' -map 2:s:0';
}



//Video filter  
//resolusi
$resolution = !empty($_SESSION['format_changeresolution']) ? ' -s '.$_SESSION['format_changeresolution'].'' : '';
//ratio
$ratio = !empty($_SESSION['format_changeratio']) ? ' -aspect '.$_SESSION['format_changeratio'].'' : '';
//subtitles HARDSUB
$subtitles = isset($_SESSION['hardsub']) ? $_SESSION['hardsub'] : '' ;
$vf = !empty($subtitles) ? '-vf "ass='.$subtitles.'"': '' ;

//video set
if ($_SESSION['videosetting_mode'] == 'pass1' || $_SESSION['videosetting_mode'] == 'crf') {
	$video = $inputvideo.' -c:v libx264'.$_SESSION['videosetting_present'].$_SESSION['videosetting_profile'].$_SESSION['videosetting_level'].$_SESSION['videosetting_tune'].$_SESSION['videosetting_pixfmt'].$_SESSION['videosetting_rate'].' -passlogfile "cache/logsvideo" -an '.$vf.$resolution.$ratio.' 1> '.$cache.'output.txt 2>&1 && ';
} else if ($_SESSION['videosetting_mode'] == 'pass2'){
	$pass1 = $inputvideo.' -c:v libx264 -pass 1'.$_SESSION['videosetting_present'].$_SESSION['videosetting_profile'].$_SESSION['videosetting_level'].$_SESSION['videosetting_tune'].$_SESSION['videosetting_pixfmt'].$_SESSION['videosetting_rate'].' '.$vf.$resolution.$ratio.' -passlogfile "cache/logsvideo" -an';
	$pass2 = $inputvideo.' -c:v libx264 -pass 2'.$_SESSION['videosetting_present'].$_SESSION['videosetting_profile'].$_SESSION['videosetting_level'].$_SESSION['videosetting_tune'].$_SESSION['videosetting_pixfmt'].$_SESSION['videosetting_rate'].' '.$vf.$resolution.$ratio.' -passlogfile "cache/logsvideo" -an';
	$video = $pass1.' -f mp4 cache/video 1> '.$cache.'output.txt 2>&1 && '.$pass2.' "'.$cache.$_SESSION['filename'].'+compile.'.$_SESSION['format_format'].'" 1> '.$cache.'output.txt 2>&1 && ';
} else if ($_SESSION['videosetting_mode'] == 'pass3'){
	$pass1 = $inputvideo.' -c:v libx264 -pass 1'.$_SESSION['videosetting_present'].$_SESSION['videosetting_profile'].$_SESSION['videosetting_level'].$_SESSION['videosetting_tune'].$_SESSION['videosetting_pixfmt'].$_SESSION['videosetting_rate'].' '.$vf.$resolution.$ratio.' -passlogfile "cache/logsvideo" -an';
	$pass2 = $inputvideo.' -c:v libx264 -pass 2'.$_SESSION['videosetting_present'].$_SESSION['videosetting_profile'].$_SESSION['videosetting_level'].$_SESSION['videosetting_tune'].$_SESSION['videosetting_pixfmt'].$_SESSION['videosetting_rate'].' '.$vf.$resolution.$ratio.' -passlogfile "cache/logsvideo" -an';
	$pass3 = $inputvideo.' -c:v libx264 -pass 3'.$_SESSION['videosetting_present'].$_SESSION['videosetting_profile'].$_SESSION['videosetting_level'].$_SESSION['videosetting_tune'].$_SESSION['videosetting_pixfmt'].$_SESSION['videosetting_rate'].' '.$vf.$resolution.$ratio.' -passlogfile "cache/logsvideo" -an';
	$video = $pass1.' -f mp4 cache/video 1> '.$cache.'output.txt 2>&1 && '.$pass2.' -f mp4 cache/video 1> '.$cache.'output.txt 2>&1 && '.$pass3.' "'.$cache.$_SESSION['filename'].'+compile.'.$_SESSION['format_format'].'" 1> '.$cache.'output.txt 2>&1 && ';
}
 
//audio set 
$audio = $inputaudio.' -c:a libfdk_aac'.$_SESSION['audiosetting_channel'].$_SESSION['audiosetting_sampling'].$_SESSION['audiosetting_bitrateaudio'].' "'.$cache.$_SESSION['filename'].'+compileaac.mp4" 1> '.$cache.'output.txt 2>&1 && ';

//Compile
if ($_SESSION['format_format'] == 'mkv'){
	$compile = $ffmpeg.' -y -i "'.$cache.$_SESSION['filename'].'+compile.'.$_SESSION['format_format'].'" -i "'.$cache.$_SESSION['filename'].'+compileaac.mp4"'.$softsub.' -c copy -map 0:v:0 -map 1:a:0'.$mapsubs.' "upload/'.$_SESSION['filename'].'muxed.'.$_SESSION['format_format'].'" 1> '.$cache.'output.txt 2>&1';
} else if ($_SESSION['format_format'] == 'mp4'){
	$compile = $ffmpeg.' -y -i "'.$cache.$_SESSION['filename'].'+compile.'.$_SESSION['format_format'].'" -i "'.$cache.$_SESSION['filename'].'+compileaac.mp4" -c copy "upload/'.$_SESSION['filename'].'muxed.'.$_SESSION['format_format'].'" 1> '.$cache.'output.txt 2>&1';	
}

//ffmpeg compile
$_SESSION['ffmpeg'] = $extract.$video.$audio.$compile;

//echo $_SESSION['ffmpeg'];  

if (isset($_POST['ajax']) && isset($_SESSION['ffmpeg'])){
	//shell_exec('/home/bin/ffmpeg -y -i "upload/Fate Illya.mp4" -c:v libx264 -pass 1 -preset medium -profile:v high10 -tune film -b:v 10k cache.h264 1> output.txt 2>&1');
	shell_exec($_SESSION['ffmpeg']); 
	} 
	
if (isset($_POST['delete'])){
	unlink($_POST['delete']);
} 
echo '<div id="status"></div>';
echo '<div style="border:1px solid blue;position: relative; height:10px;vertical-align : top;float : left; max-width:100%; width:100%;margin:5px;">';
	echo '<span id="progressbar" style="height: 100%; position: absolute; top: 0px; left: 0px; width:0; max-width: 100%; background: blue;"></span>';
echo '</div>';

//nb JS
$aa = $_SESSION['videosetting_mode'];
$cv = $_SESSION['videosetting_profilebit'];
$cx = ''.$cache.'output.txt';
?>
<script src="incfiles/jquery.min.js"></script>
<script>

var erot = document.getElementById("status");
var pass = '<?php echo $aa; ?>';
var profilebit = '<?php echo $cv ?>';
var output = '<?php echo $cx ?>';

ajax_post();
//setTimeout(function(){ progressk(0); }, 2000);	
function ajax_post(){
	// Create our XMLHttpRequest object
	var hr = new XMLHttpRequest();

	// Create some variables we need to send to our PHP file
	var url = "convert.php?step=5";
	var fn = 1;
	var vars = "ajax="+fn;
	hr.open("POST", url, true);

	// Set content type header information for sending url encoded variables in the request
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	// Send the data to PHP now... and wait for response to update the status div
	hr.send(vars); // Actually execute the request
} 
	
function post_delete(input){
	// Create our XMLHttpRequest object
	var hr = new XMLHttpRequest();

	// Create some variables we need to send to our PHP file
	var url = "convert.php?step=5";
	var fn = input;
	var vars = "delete="+fn;
	hr.open("POST", url, true);

	// Set content type header information for sending url encoded variables in the request
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	// Send the data to PHP now... and wait for response to update the status div
	hr.send(vars); // Actually execute the request

	
	
}
	var _progress = function(i){
    i++;
    // THIS MUST BE THE PATH OF THE .txt FILE SPECIFIED IN [1] : 
    var logfile = output;

/* (example requires dojo) */

$.get(logfile).then( function(content){
// AJAX success
    var duration = 0, time = 0, progress = 0, kk = 1;
    var result = {};

    // get duration of source
    var matches = (content) ? content.match(/Duration: (.*?), start:/) : [];

	if (matches.length == 0) {
		setTimeout(function(){ _progress(0); }, 5000); 
	}
	
        var rawDuration = matches[1];
        // convert rawDuration from 00:00:00.00 to seconds.
        var ar = rawDuration.split(":").reverse();
        duration = parseFloat(ar[0]);
        if (ar[1]) duration += parseInt(ar[1]) * 60;
        if (ar[2]) duration += parseInt(ar[2]) * 60 * 60;
		
        // get the time 
        matches = content.match(/time=(.*?) bitrate/g);
        //console.log( matches );

            var rawTime = matches.pop();
            // needed if there is more than one match
            if ($.isArray(rawTime)){ 
                rawTime = rawTime.pop().replace('time=','').replace(' bitrate',''); 
            } else {
                rawTime = rawTime.replace('time=','').replace(' bitrate','');
            }

            // convert rawTime from 00:00:00.00 to seconds.
            ar = rawTime.split(":").reverse();
            time = parseFloat(ar[0]);
            if (ar[1]) time += parseInt(ar[1]) * 60;
            if (ar[2]) time += parseInt(ar[2]) * 60 * 60;

            //calculate the progress
            progress = ((time/duration) * 100);
        

        result.status = 200;
        result.duration = duration;
        result.current  = time;
        result.progress = progress;
		progressbar.style.width = progress+'%';

        console.log(result); 

        /* UPDATE YOUR PROGRESSBAR HERE with above values ... */ 

        if(progress==0 && i>50 || progress>=100){
			for (var c = 1; c < 99999; c++)
			window.clearInterval(c);
			erot.innerHTML = 'Selesai';
            // TODO err - giving up after 8 sec. no progress - handle progress errors here
            console.log('{"status":-400, "error":"there is no progress while we tried to encode the video" }'); 
            return; 
        } else if(progress<100){ 
			erot.innerHTML = 'Masih proses, ngopi ngopi dulu sana. <br /> Jangan di close. ganti tab gak papa yang penting jangan di close';
        }

},
function(err){
// AJAX error
    if(i<50){
        // retry
        setTimeout(function(){ _progress(0); }, 400);
    } else {
        console.log('{"status":-400, "error":"there is no progress while we tried to encode the video" }');
        console.log( err ); 
    }
    return; 
});
}
var progressbar = document.getElementById("progressbar");
window.setInterval(function(){ _progress(); }, 1000);
//clearInterval(anu);

</script> 
