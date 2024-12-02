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
$columns = [];
if (isset($_REQUEST['title'])) {
    array_push($columns, 'title');
}
if (isset($_REQUEST['channel'])) {
    array_push($columns, 'channel');
}
if (isset($_REQUEST['tags'])) {
    array_push($columns, 'tags');
}
if (isset($_REQUEST['description'])) {
    array_push($columns, 'description');
}
// TODO comments, date
if (sizeof($columns) != 0) {
    $columns = array_map(fn($col) => "to_tsvector('english', video.$col)", $columns);
    $document = join(' || ', $columns);
    $sortby = "rank";
    $sortorder = "DESC";
    if (isset($_REQUEST["sortby"]) && $_REQUEST["sortby"] == "relevance") {
        $sortby = "rank";
    } elseif (isset($_REQUEST["sortby"]) && $_REQUEST["sortby"] == "date") {
        $sortby = "upload_date";
    } elseif (isset($_REQUEST["sortby"]) && $_REQUEST["sortby"] == "viewcount") {
        $sortby = "view_count";
    } elseif (isset($_REQUEST["sortby"]) && $_REQUEST["sortby"] == "commentscount") {
        $sortby = "comment_count";
    }
    if (isset($_REQUEST["order"]) && $_REQUEST["order"] == "ascending") {
        $sortorder = "ASC";
    } elseif (isset($_REQUEST["order"]) && $_REQUEST["order"] == "descending") {
        $sortorder = "DESC";
    }
    $query = "websearch_to_tsquery('english', :query)";
    $sql = "SELECT id, title, channel, upload_date, channel_id, view_count, comment_count, isonline
            FROM
                video,
                ts_rank($document, $query) rank
            WHERE ($document) @@ $query
            ORDER BY $sortby $sortorder";
    $sth = $pdo->prepare($sql);
    $sth->execute(['query' => $_REQUEST['q']]);
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
        echo '<div class="video_link' . ($row['isonline']?'':' offline') . '">';
        echo '<a href="' . $url_escaped . '">';
        echo '<img class="thumbnail" src="content/'
            . htmlspecialchars($row['id']) . '.webp"/>';
        echo '</a>';
    //	echo '<b class="video_link_meta" href="' . $url_escaped . '">';
        echo '<section class="video_link_meta">';
        echo '<a class="title" href="' . $url_escaped . '"><strong>' . htmlspecialchars($row['title']) . "</strong></a>";
        echo '<a class="channellist" href="' . $url_channel_escaped . '">' . htmlspecialchars($row['channel']) . "<hr class='channelbar'/></a>";
        echo '<span class="date browsedate">' . htmlspecialchars($date) . '</span>';
        echo '<span class="counts">' . $row['view_count'] . ' views, ' . $row['comment_count'] . ' comments</span>';
    //	echo '</a>';
        echo '</section></div>';
    }

}
$q = $_GET['q'] ?? '';
$q = htmlspecialchars($q);
?>

</div>
</div>
<nav class="navigator">
    <form action="search.php" method="get">
        <div class="mainsearch">
        <input type="search" id="search" name="q" value="<?php echo $q; ?>">
            <button class="boutonmignon">search</button>
        </div>
            <h1 class="advancedtitle">search through</h1>
            <div class="checkboxes navigo">
                <div>
                    <input type="checkbox" id="title" name="title"
                        <?php
                            if (isset($_GET['title'])) {echo 'checked';}
                        ?> 
                    />
                    <label for="title">title</label>
                </div>
                <div>
                    <input type="checkbox" id="channel" name="channel"
                        <?php
                            if (isset($_GET['channel'])) {echo 'checked';}
                        ?> 
                    />
                    <label for="channel">channel</label>
                </div>
                <div>
                    <input type="checkbox" id="tags" name="tags" 
                        <?php
                            if (isset($_GET['tags'])) {echo 'checked';}
                        ?> 
                    />
                    <label for="tags">tags</label>
                </div>
                <div>
                    <input type="checkbox" id="description" name="description"
                        <?php
                            if (isset($_GET['description'])) {echo 'checked';}
                        ?> 
                    />
                    <label for="description">description</label>
                </div>
                <!--
                <div>
                    <input type="checkbox" id="comments" name="comments"
                        <?php
                            if (isset($_GET['comments'])) {echo 'checked';}
                        ?> 
                    />
                    <label for="comments">comments</label>
                </div>
                <div>
                    <input type="checkbox" id="date" name="date" 
                        <?php
                            if (isset($_GET['date'])) {echo 'checked';}
                        ?> 
                    />
                    <label for="date">date (yyyy/mm/dd)</label>
                </div>
                -->
            </div>
            <h1 class="advancedtitle">sort by</h1>
            <div class="checkboxes navigo">
                <div>
                    <input type="radio" id="sortrelevance" name="sortby" value="relevance"
                        <?php
                            echo ($_REQUEST['sortby'] == 'relevance') ? 'checked' : '';
                        ?>
                    />
                    <label for="sortrelevance">relevance</label>
                </div>
                <div>
                    <input type="radio" id="sortdate" name="sortby" value="date"
                        <?php
                            echo ($_REQUEST['sortby'] == 'date') ? 'checked' : '';
                        ?>
                    />
                    <label for="sortdate">date</label>
                </div>
                <div>
                    <input type="radio" id="viewcount" name="sortby" value="viewcount"
                        <?php
                            echo ($_REQUEST['sortby'] == 'viewcount') ? 'checked' : '';
                        ?>
                    />
                    <label for="viewcount">view count</label>
                </div>
                <div>
                    <input type="radio" id="commentscount" name="sortby" value="commentscount"
                        <?php
                            echo ($_REQUEST['sortby'] == 'commentscount') ? 'checked' : '';
                        ?>
                    />
                    <label for="commentscount">comment count</label>
                </div>
            </div>
            <label for="order"><h1 class="advancedtitle">order</h1></label>
            <select name="order" id="order">
                <option value="ascending">ascending</option>
                <option value="descending" 
<?php 
                            echo ($_REQUEST['order'] == 'descending') ? 'selected' : '';
?>
                >descending</option>
            </select>
            </form>
<hr>
<div class="highlighter">
<input type="checkbox" id="showoffline"/>
<label for="showoffline">highlight deleted videos</label>
</div>
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

// deleted videos toggle

const checkbox = document.getElementById('showoffline');
const offlineElements = document.querySelectorAll('.offline');
checkbox.addEventListener('change', function() {
  // Toggle the 'show' class on all elements with class 'offline' based on checkbox state
  offlineElements.forEach(element => {
    if (checkbox.checked) {
      element.classList.add('show'); // Show elements if checkbox is checked
    } else {
      element.classList.remove('show'); // Hide elements if checkbox is unchecked
    }
  });
});
        </script>
    </body>
</html>
