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
<div class="titre">
    <h1 class="titretexte shadow">YTPMV/音MAD archive</h1>
    <h1 class="titretexte R" >YTPMV/音MAD archive</h1>
    <h1 class="titretexte G">YTPMV/音MAD archive</h1>
    <h1 class="titretexte B">YTPMV/音MAD archive</h1>
</div>
<div class="menu">
    <input type="search" id="search" name="q"/>
    <button class="boutonmignon">search</button>
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
            <div>
                <input type="checkbox" id="comments" name="comments" />
                <label for="comments">comments</label>
            </div>
            <div>
                <input type="checkbox" id="date" name="date" />
                <label for="date">date (yyyy/mm/dd)</label>
            </div>
        </div>
    </div>
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
