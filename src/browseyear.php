<?php
require_once 'database.php';
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>media</title>
        <link rel="stylesheet" href="style.css" />
        <link rel="icon" type="image/png" href="/favicon.png"/>
        <script src="./bundle.js"></script>
        <style type="text/css">
           body {
            background-image: url(noisebrowse.gif);
            background-position-x: 100%;
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
<div class="year_list">
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
        echo '<a class="channellist" href="' . $url_channel_escaped . '">' . htmlspecialchars($row['channel']) . "<hr class='channelbar'/></a>";
        echo '<span class="date browsedate">' . htmlspecialchars($date) . '</span>';
        echo '<span class="counts">' . $row['view_count'] . ' views, ' . $row['comment_count'] . ' comments</span>';
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

        echo '<div class="year_link">';
        
       // echo '<a href="' . $url_escaped . '">';
        
        //echo '<img class="yearthumbnail" src="years/'
        //    . htmlspecialchars($row['upload_year']) . '.jpg"/>';
       // echo '</a>';
        $sql2 = "
            SELECT id FROM video 
            WHERE SUBSTRING(upload_date, 0, 5) = :year
            ORDER BY RANDOM()
            LIMIT 25";
    $sth2 = $pdo->prepare($sql2);
    $sth2->execute(['year' => $row['upload_year']]);
    $data2 = $sth2->fetchAll();
    //echo '<pre>';
    //print_r($data2);
    //echo '</pre>';
        echo '<div class="yearthumbnail">';
    foreach($data2 as $row2) {
        echo '<img class="collage" src="thumbs/' . htmlspecialchars($row2['id']) . '.webp"/>';
    }
       // echo '<img class="collage" src="thumbs/';
        echo '</div>';
        echo '<a class="titleyear" href="' . $url_escaped . '">' . htmlspecialchars($row['upload_year']) . "</a>";
    //	echo '</a>';
        echo '</div>';
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
