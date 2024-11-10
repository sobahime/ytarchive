<?php
require_once 'database.php';
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>media</title>
	<style>
body {
	font-family: sans-serif;
}
a {
	color: #000000;
	text-decoration: none;
}
.video_list {
	display: flex;
	flex-wrap: wrap;
}
.video_link {
	display: flex;
	padding: 12px;
}
.thumbnail {
	display: block;
	width: 160px;
	height: 90px;
	object-fit: cover;
	border-radius: 12px;
}
.video_link_meta {
	padding-left: 12px;
	width: 320px;
}
</style>
    </head>
    <body>

<div class="video_list">
<?php
$sql = 'SELECT title, thumbnail, channel, timestamp FROM video;';
$sth = $pdo->prepare($sql);
$sth->execute();
$data = $sth->fetchAll();

foreach($data as $row) {
	$url_escaped = '#';
	echo '<div class="video_link">';
	echo '<a href="' . $url_escaped . '">';
	echo '<img class="thumbnail" src="' . htmlspecialchars($row["thumbnail"]) . '"/>';
	echo '</a>';
	echo '<a class="video_link_meta" href="' . $url_escaped . '">';
	echo '<strong>' . htmlspecialchars($row["title"]) . "</strong><br/>";
	echo htmlspecialchars($row["channel"]) . "<br/>";
	echo htmlspecialchars(date("d/m/Y H:i:s", $row["timestamp"]));
	echo '</a>';
	echo '</div><br/>';
}
?>

</div>

    </body>
</html>
