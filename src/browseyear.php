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
        <style type="text/css">
           body {
            background-image: url(noisebrowse.gif);
            background-position-x: 100%;
            animation: bgscroll 40s linear infinite; 
} 
@keyframes bgscroll {
    0% {
    background-position-x: 100%;
}
    100% {
    background-position-x: 0%;
}
}
        </style>
    </head>
    <body>
<div class="titre">
    <h1 class="titretexte shadow">YTPMV/音MAD archive</h1>
    <h1 class="titretexte R" >YTPMV/音MAD archive</h1>
    <h1 class="titretexte G">YTPMV/音MAD archive</h1>
    <h1 class="titretexte B">YTPMV/音MAD archive</h1>
    <a href="index.php" class="titretexte indexlink">YTPMV/音MAD archive</a>
</div>
<div class="contenant">
<div class="video_list">
<?php

if (isset($_REQUEST["year"])) {
    $sql = "SELECT id, title, channel, upload_date, channel_id, view_count, comment_count
        FROM video
        WHERE SUBSTRING(upload_date, 0, 5) = :year
        ORDER BY upload_date;
    ";
    $sth = $pdo->prepare($sql);
    $sth->execute(['year' => $_REQUEST['year']]);
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
        echo '<div class="video_link">';
        echo '<a href="' . $url_escaped . '">';
        echo '<img class="thumbnail" src="content/'
            . htmlspecialchars($row['id']) . '.webp"/>';
        echo '</a>';
    //	echo '<b class="video_link_meta" href="' . $url_escaped . '">';
        echo '<section class="video_link_meta">';
        echo '<a class="title" href="' . $url_escaped . '"><strong>' . htmlspecialchars($row['title']) . "</strong><br/></a>";
        echo '<a class="channel" href="' . $url_channel_escaped . '">' . htmlspecialchars($row['channel']) . "</a><br/>";
        echo '<span class="date">' . htmlspecialchars($date) . '</span>';
    //	echo '</a>';
        echo '</section></div>';
    }

} else {
    $sql = "SELECT DISTINCT
            SUBSTRING(upload_date, 0, 5) AS upload_year
            FROM video
            WHERE upload_date IS NOT NULL
            ORDER BY upload_year;
    ";
    $sth = $pdo->prepare($sql);
    $sth->execute();
    $data = $sth->fetchAll();

    foreach($data as $row) {
        $date = $row['upload_date'];

        $url_escaped = 'browseyear.php?year=' . htmlspecialchars($row['upload_year']);

        echo '<div class="video_link">';
        /*
        echo '<a href="' . $url_escaped . '">';
        echo '<img class="thumbnail" src="content/'
            . htmlspecialchars($row['id']) . '.webp"/>';
        echo '</a>';
        */
        echo '<section class="video_link_meta">';
        echo '<a class="title" href="' . $url_escaped . '"><strong>' . htmlspecialchars($row['upload_year']) . "</strong><br/></a>";
    //	echo '</a>';
        echo '</section></div>';
    }
}

?>

</div>
</div>
    <script>
        function transformScroll(event) {
  if (!event.deltaY) {
    return;
  }

  event.currentTarget.scrollLeft += (event.deltaY + event.deltaX)*4;
  event.preventDefault();
}

var element = document.scrollingElement || document.documentElement;
element.addEventListener('wheel', transformScroll);
        </script>
    </body>
</html>
