<?php
require_once 'database.php';
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>media</title>
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
        <p class="back"><a href="#" onclick="history.back();">Back</a></p>
<?php
$sql = 'SELECT id, title, channel, timestamp, channel_id, ext,
            description
        FROM video
        WHERE id = :id;';
$sth = $pdo->prepare($sql);
$sth->execute(['id' => $_REQUEST['v']]);
$data = $sth->fetchAll();

foreach($data as $row) {
    $url_escaped = 'watch.php?v=' . htmlspecialchars($row['id']);
    $url_channel_escaped = 'channel.php?channel_id=' . htmlspecialchars($row['channel_id']);
    echo '<video controls width="640" poster="content/'
        . htmlspecialchars($row['id']) . '.webp">';
    echo '<source src="content/'
        . htmlspecialchars($row['id']) . '.'
        . htmlspecialchars($row['ext']) .'" type="video/'
        . htmlspecialchars($row['ext']) .'" />';
    echo '</video>';
    echo '<div class="video_metadata">';
    echo '<strong>' . htmlspecialchars($row['title']) . '</strong><br/>';
    echo '<a class="channel" href="' . $url_channel_escaped . '">' . htmlspecialchars($row['channel']) . "</a><br/>";
    echo '<span class="date">' . htmlspecialchars(date("Y/m/d", $row['timestamp'])) . '</span>';
    echo '<p class="description">' . htmlspecialchars($row['description']) . '</p>';
    echo '</div>';
//	echo '</a>';
}
?>

    </body>
</html>
