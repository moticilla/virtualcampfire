<html>
 <head>
  <title>Virtual Campfire</title>
<script>
function choose(url) { 
  window.currentAudioElement = document.getElementById('player');
  if (typeof window.currentAudioElement === 'undefined') { 
    alert('your browser does not like audio.');
  } else {
    if (!window.currentAudioElement.paused) {
      window.currentAudioElement.pause();
      window.currentAudioElement.currentTime = 0;   
    }
    window.currentAudioElement.src = url;
    window.currentAudioElement.play();
  }

  var lUrl = lyricsUrl(url);
  var urlExists = false;
  var request = new XMLHttpRequest();  
  // Open a synchronous request so that urlExists is set
  request.open('GET', lUrl, false);
  request.onreadystatechange = function(){
    if (request.readyState === 4){
      if (request.status !== 404) {
        urlExists = true;
      }
    }
  };
  request.send();
  if (urlExists) {         
   window.open(lUrl, 'lyrics');
  }
}

function lyricsUrl(url) { 
  var plain = new RegExp("^([^\(]+)\.mp3$");
  var m = plain.exec(decodeURI(url));
  if (m != null) { 
   return m[1] + ".html";
  } else { 
   var withBrackets = new RegExp(/^([^\(]+?)_\(([^\)]+)\)/);
   var wb = withBrackets.exec(decodeURI(url));
   if (wb != null) { 
     return wb[1] + ".html";
   } else { 
     alert('foo');
     return "foo.txt";
   }
  }

} 

</script>
<link href="song_styles.css" rel="stylesheet" type="text/css" />
</head>
<body>

<a href="https://github.com/timp/virtualcampfire"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/652c5b9acfaddf3a9c326fa6bde407b87f7be0f4/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6f72616e67655f6666373630302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_orange_ff7600.png"></a>

<audio 
  id="player" 
  type="audio/mpeg"
  loop >
</audio>
<div id="left" style='float:left; width:20%; textalign:left;'>
<div id="logo"></div>
<ul>
<li>Email <a href="mailto:fergus@virtualcampfire.co.uk">Fergus</a> to contribute songs or feedback</li>
<li>
Or make a <a href="https://github.com/timp/virtualccampfire">pull request</a>
</li>
</ul>
</div>
<div align='center'>
<h1>Virtual Campfire</h1>
<p>
A place for <a href="http://fsc.org.uk/">Forest School Campers</a> 
to learn and teach traditional songs online. 
</p>
<table id="songlist" class="sortable">
<?php	
// Install with: sudo apt-get install php-getid3
// or use  getid3/getID3-1.9.12/getid3/
require_once('getid3/getID3-1.9.12/getid3/getid3.php'); 

// Initialize getID3 engine 
$getID3 = new getID3; 


	$handle = opendir(".");

while ($filename = readdir($handle)) {
	if (preg_match("/mp3$/", $filename) )
	{
		$files[] = $filename;
	}
}

natcasesort($files);

foreach($files as $filename) {
  $ThisFileInfo = $getID3->analyze($filename); 

  $filetime = filemtime($filename);
  $file_mb  = round((filesize($filename) / 1048576), 2);
  $title = str_replace(".mp3", "", $filename );	
  $title = str_replace("_", " ", $title );	
  $title=str_replace("-", " ", $title );	
  print 
'<tr class="song">
  <td class="songname">
    <a onclick="choose(\''.rawurlencode($filename).'\')"
       title="['.$ThisFileInfo['playtime_string'].']"
    > 
    <img src="playbutton.png" alt="Play '.$title.'">
     '.$title.'



    </a>
  </td>
  <td class="download">
    <a href="'.$filename.'" title="Download '.$file_mb.'Mb mp3">
      <img src="downloadButton.png" alt="Download raw mp3">
    </a>
  </td>
</tr>
';

}
?>
</table>
<p>
This page was originally put together by <a href="http://leomurray.co.uk">Leo Murray</a> and Jack Freedman. 
</p>
<p>
<a href="http://oolong.co.uk">Fergus</a> just took over the development of it in September 2009.
</p>
<p>
<a href="http://tim.pizey.net/">Tim</a> updated the site in July 2014.
</p>
</div>
</body>
</html>
