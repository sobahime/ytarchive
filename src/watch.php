<?php
require_once 'database.php';
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>media</title>
        <link rel="stylesheet" href="style.css" />
        <link rel="icon" type="image/png" href="/favicon.png">
    </head>
    <body>
        <p class="back"><a href="#" onclick="history.back();">Back</a></p>
<?php
$sql = 'SELECT id, view_count, title, channel, upload_date, channel_id, ext,
            description
        FROM video
        WHERE id = :id;';
$sth = $pdo->prepare($sql);
$sth->execute(['id' => $_REQUEST['v']]);
$data = $sth->fetchAll();

foreach($data as $row) {
    $date = $row['upload_date'];
    if (isset($date) && strlen($date >= 8)) {
        $date = substr($date, 0, 4) . '/'
                . substr($date, 4, 2) . '/'
                . substr($date, 6, 2);
    }
    $url_escaped = 'watch.php?v=' . htmlspecialchars($row['id']);
   // $url_channel_escaped = 'channel.php?channel_id=' . htmlspecialchars($row['channel_id']);
    $url_channel_escaped = 'search.php?q=' . htmlspecialchars(urlencode('"' . $row['channel'] . '"')) . '&channel=on';
    echo '<video controls poster="content/'
        . htmlspecialchars($row['id']) . '.webp">';
    echo '<source src="content/'
        . htmlspecialchars($row['id']) . '.'
        . htmlspecialchars($row['ext']) .'" type="video/'
        . htmlspecialchars($row['ext']) .'" />';
    echo '</video>';
    echo '<div class="video_metadata">';
    echo '<strong class="video_title">' . htmlspecialchars($row['title']) . '</strong><br/>';
    echo '<p class="view_count">' . htmlspecialchars($row['view_count']) . ' views</p>';
    echo '<a class="channel" href="' . $url_channel_escaped . '">' . htmlspecialchars($row['channel']) . "</a><br/>";
    echo '<span class="watch_date">' . htmlspecialchars($date) . '</span>';
    echo '<p class="text_description">original description :</p>';
    echo '<p class="description">' . nl2br(htmlspecialchars($row['description'])) . '</p>';
    echo '</div>';
    echo '<style type="text/css">';
//    echo 'video {aspect-ratio: . }'
//	echo '</a>';
}
?>

    </body>
</html>
