<?php
require_once 'database.php';
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>media</title>
        <link rel="icon" type="image/png" href="/favicon.png">
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
        <img src="bgpony.png" alt="bgpony" class="bgpony" />
<div class="titre maintitre">
    <h1 class="titretexte shadow">YTPMV/音MAD archive</h1>
    <h1 class="titretexte R" >YTPMV/音MAD archive</h1>
    <h1 class="titretexte G">YTPMV/音MAD archive</h1>
    <h1 class="titretexte B">YTPMV/音MAD archive</h1>
</div>
<p class="toabout"><a href="about.php">about</a></p>
<?php
    $stmt = $pdo->query("SELECT id FROM video ORDER BY RANDOM() LIMIT 1");
    $randomRow = $stmt->fetch(PDO::FETCH_ASSOC);
    $randomId = $randomRow['id'];
?>
<div class="menu">
    <div class="menuhead">
        <a href="browse.php">browse</a>
        <a href="browseyear.php">by year</a>
        <a href="browsechannel.php">channels</a>
        <a href="watchrandom.php?v=<?php echo htmlspecialchars($randomId);?>">random</a>
    </div>
    <form action="search.php" method="get">
        <div class="mainsearch">
            <input type="search" id="search" name="q"/>
            <button class="boutonmignon">search</button>
        </div>
        <button type="button" class="cascade">advanced search</button>
        <div class="advanced">
            <h1 class="advancedtitle">search through</h1>
            <div class="checkboxes">
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
                <!--
                <div>
                    <input type="checkbox" id="comments" name="comments" />
                    <label for="comments">comments</label>
                </div>
                <div>
                    <input type="checkbox" id="date" name="date" />
                    <label for="date">date (yyyy/mm/dd)</label>
                </div>
                -->
            </div>
            <h1 class="advancedtitle">sort by</h1>
            <div class="checkboxes">
                <div>
                    <input type="radio" id="sortrelevance" name="sortby" value="relevance" checked />
                    <label for="sortrelevance">relevance</label>
                </div>
                <div>
                    <input type="radio" id="sortdate" name="sortby" value="date" />
                    <label for="sortdate">date</label>
                </div>
                <div>
                    <input type="radio" id="viewcount" name="sortby" value="viewcount" />
                    <label for="viewcount">view count</label>
                </div>
                <div>
                    <input type="radio" id="commentscount" name="sortby" value="commentscount" />
                    <label for="commentscount">comment count</label>
                </div>
            </div>
            <label for="order"><h1 class="advancedtitle">order</h1></label>
            <select class="boutonmignon" name="order" id="order">
                <option value="ascending">ascending</option>
                <option value="descending" selected>descending</option>
            </select>
        </div>
    </form>
</div>
<script type="text/javascript">
var coll = document.getElementsByClassName("cascade");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    }
  });
}
</script>
    </body>
</html>
