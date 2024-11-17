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
$sql = 'SELECT id, title, channel, timestamp, channel_id
        FROM video;';
$sth = $pdo->prepare($sql);
$sth->execute();
$data = $sth->fetchAll();

foreach($data as $row) {
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
    echo '<span class="date">' . htmlspecialchars(date("Y/m/d", $row['timestamp'])) . '</span>';
//	echo '</a>';
    echo '</section></div>';
}
?>

</div>
<nav class="navigator">
    <form action="search.php" method="get">
        <div class="mainsearch">
            <input type="search" id="search" name="q"/>
            <button class="boutonmignon">search</button>
        </div>
            <h1 class="advancedtitle">search through</h1>
            <div class="checkboxes navigo">
                <div>
                    <input type="checkbox" id="title" name="title" checked />
                    <label for="title">title</label>
                </div>
                <div>
                    <input type="checkbox" id="channel" name="channel" checked />
                    <label for="channel">channel</label>
                </div>
                <div>
                    <input type="checkbox" id="tags" name="tags" checked />
                    <label for="tags">tags</label>
                </div>
                <div>
                    <input type="checkbox" id="description" name="description" />
                    <label for="description">description</label>
                </div>
                <div>
                    <input type="checkbox" id="comments" name="comments" />
                    <label for="comments">comments</label>
                </div>
                <div>
                    <input type="checkbox" id="date" name="date" />
                    <label for="date">date (yyyy/mm/dd)</label>
                </div>
</div>
            <h1 class="advancedtitle">sort by</h1>
            <div class="checkboxes navigo">
                <div>
                    <input type="radio" id="sortdate" name="sortby" value="sortdate" />
                    <label for="sortdate">date</label>
                </div>
                <div>
                    <input type="radio" id="viewcount" name="sortby" value="viewcount" />
                    <label for="viewcount">view count</label>
                </div>
                <div>
                    <input type="radio" id="commentscount" name="sortby" value="commentscount" />
                    <label for="commentscount">comments count</label>
                </div>
</div>
            <label for="order"><h1 class="advancedtitle">order</h1></label>
            <select name="order" id="order">
                <option value="ascending">ascending</option>
                <option value="descending">descending</option>
            </select>
            </form>
</nav>
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
