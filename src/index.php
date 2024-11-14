<?php
require_once 'database.php';
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>media</title>
	<style>
html {
    height: 100%;
}
body {
	font-family: sans-serif;
    background-image: url(noise.jpg);
    background-size: cover;
    color: white;
    height: 95%;
}
.contenant {
    height: 88vh;
}
a {
	color: white;
	text-decoration: none;
}
.video_list {
    background-size: cover;
    background-repeat: repeat-x;
	display: flex;
    flex-direction: column;
	flex-wrap: wrap;
    padding: 2em;
    padding-bottom: 0;
    padding-top: 0;
    height: 100%;
}
.video_link {
    background-color: rgba(0.1,0.1,0.1,0.8);
	display: flex;
    flex-direction: column;
	padding: 4px;
    margin: 0.2em;
    text-align: center;
    width: 32vh;
    height: 26vh;
}
.thumbnail {
    text-align: center;
    width: 100%;
    aspect-ratio: 16 / 9;
	object-fit: contain;
}
.video_link_meta {
    padding: 0;
}
.titre {
    width: 100%;
    height: 10%;
}
.titretexte {
    position: fixed;
    left: 50%;
    transform: translateX(-50%);
    margin: 0;
    vertical-align: middle;
    padding: 0;
    font-size: 4em;
    text-align: center;
    mix-blend-mode: screen;
}
.titretexte.R {
    color: #ff0000;
}
.titretexte.G {
    color: #00ff00;
}
.titretexte.B {
    color: #0000ff;
}
.titre:hover .R {
  animation: shake 0.82s cubic-bezier(.36,.07,.80,.97) both infinite;
  transform: translate(-50%, 0);
}
.titre:hover .G {
  animation: shake 0.40s cubic-bezier(.36,.07,.19,.97) both infinite;
  transform: translate(-50%, 0);
}
.titre:hover .B {
  animation: shake 0.60s cubic-bezier(0,.07,.19,.97) both infinite;
  transform: translate(-50%, 0);
}
@keyframes shake {
  10%, 90% {
    transform: translate(calc(-50% - 1px), 0);
  }

  20%, 80% {
    transform: translate(calc(-50% - 2px), 0);
  }

  30%, 50%, 70% {
    transform: translate(calc(-50% - 4px), 4px);
  }

  40%, 60% {
    transform: translate(calc(-50% + 4px), 0);
  }
}
</style>
    </head>
    <body>
<div class="titre">
    <h1 class="titretexte R" >YTPMV/音MAD archive</h1>
    <h1 class="titretexte G">YTPMV/音MAD archive</h1>
    <h1 class="titretexte B">YTPMV/音MAD archive</h1>
</div>
<div class="contenant">
<div class="video_list">
<?php
$sql = 'SELECT id, title, thumbnail, channel, timestamp, channel_id FROM video;';
$sth = $pdo->prepare($sql);
$sth->execute();
$data = $sth->fetchAll();

foreach($data as $row) {
	$url_escaped = 'watch.php?v=' . htmlspecialchars($row["id"]);
    $url_channel_escaped = 'channel.php?channel_id=' . htmlspecialchars($row["channel_id"]);
	echo '<div class="video_link">';
	echo '<a href="' . $url_escaped . '">';
	echo '<img class="thumbnail" src="' . htmlspecialchars($row["thumbnail"]) . '"/>';
	echo '</a>';
//	echo '<b class="video_link_meta" href="' . $url_escaped . '">';
	echo '<a class="title" href="' . $url_escaped . '"><strong>' . htmlspecialchars($row["title"]) . "</strong><br/></a>";
	echo '<a class="channel" href="' . $url_channel_escaped . '">' . htmlspecialchars($row["channel"]) . "</a><br/>";
	echo '<span class="date">' . htmlspecialchars(date("Y/m/d", $row["timestamp"])) . '</span>';
//	echo '</a>';
	echo '</div><br/>';
}
?>

</div>
</div>
	<script>
		function transformScroll(event) {
  if (!event.deltaY) {
    return;
  }

  event.currentTarget.scrollLeft += event.deltaY + event.deltaX;
  event.preventDefault();
}

var element = document.scrollingElement || document.documentElement;
element.addEventListener('wheel', transformScroll);
		</script>
    </body>
</html>
