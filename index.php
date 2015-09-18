<?php
$title = 'encoder | Upload';
require_once ('incfiles/head.php');


echo '<div class="phdr"> Upload file </div>';
echo '<div class="div-div">';
echo '<div class="gmenu">Allowed Video files</div>';
echo '<form id="upload_form" enctype="multipart/form-data" method="post">';
echo	'<input type="file" name="file1" id="file1"><br>';
echo	'<input type="button" value="Upload File" onclick="uploadFile()">';
echo'</form>';
echo '<div class="phdr"> Status Upload </div>';
echo '<div class="div-div">';
echo	'<progress id="progressBar" value="0" max="100" style="width:300px;"></progress>';
echo	'<h3 id="status"></h3>';
echo	'<p id="loaded_n_total"></p>';
echo '</div></div>';



echo '<div class="phdr"> Remote Upload </div>';
echo '<div class="div-div">';
echo '<input type="text" id="link" placeholder="http://" />';
echo '<input type="submit" value="Download" onclick="download_c()">';
echo '<div id="status-curl"> </div>';
echo '</div>';



require_once ('incfiles/end.php');
?>
<script src="incfiles/jquery.min.js"></script>
<script type="text/javascript">
function download_c(){
	var link = _('link');
	// Create our XMLHttpRequest object
	var hr = new XMLHttpRequest();

	// Create some variables we need to send to our PHP file
	var url = "upload.php";
	var fn = link.value;
	var vars = "curl="+fn;
	hr.open("POST", url, true);

	// Set content type header information for sending url encoded variables in the request
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	// Send the data to PHP now... and wait for response to update the status div
	hr.send(vars); // Actually execute the request

	setTimeout(window.setInterval(function(){ download(); }, 1000), 5000);
}

function download_get(){
	$.get('cache/progress.txt').then( function(content){
		_('status-curl').innerHTML = content;
	});
}




function _(el){
	return document.getElementById(el);
}
function uploadFile(){
	var file = _("file1").files[0];
	// alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("file1", file);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "upload.php");
	ajax.send(formdata);
}
function progressHandler(event){
	_("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
	var percent = (event.loaded / event.total) * 100;
	_("progressBar").value = Math.round(percent);
	_("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
}
function completeHandler(event){
	_("status").innerHTML = event.target.responseText;
	_("progressBar").value = 0;
}
function errorHandler(event){
	_("status").innerHTML = "Upload Failed";
}
function abortHandler(event){
	_("status").innerHTML = "Upload Aborted";
}
</script>
<script type="text/javascript">



function download() {
	$.get('cache/downtarget.txt').then( function(content){
		var target = 0, namafile = 0, progress = 0;
		var result = {};
		
		var matches = (content) ? content.match(/(.*?)\+/) : [];
		target = matches[1];
		var matches = (content) ? content.match(/\+(.*?)\+/) : [];
		namafile = matches[1];
		
		var xhr = $.ajax({
			type: "HEAD",
			url: 'upload/'+namafile,
			success: function(msg){
				var downloaded = xhr.getResponseHeader('Content-Length');
				progress = (downloaded * 100)/target;
				
				
				if(progress>=100){
					for (var c = 1; c < 99999; c++)
					window.clearInterval(c);
					_('status-curl').innerHTML = 'Sukses';
				} else {
					_('status-curl').innerHTML = 'Downloading...';
				}
				result.downloaded = downloaded;
				result.target = target;
				result.progress = progress;
				console.log(result);
			}
		});

	});
}

</script>
