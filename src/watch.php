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
//    echo 'video {aspect-ratio: . }'
//	echo '</a>';
}
    ?>

    <div id="comments" class="comment_container">
    </div>
    <script>
        function fetch_comments(container, parent=null, sortby=null, sortorder=null) {
            let loading_gif = document.createElement("img");
            loading_gif.src = "loading.gif";
            container.append(loading_gif);
            const urlParams = new URLSearchParams(window.location.search);
            let url = new URL("api/comments.php", window.location);
            url.searchParams.append("video_id", urlParams.get("v"));
            if (parent !== null) {
                url.searchParams.append("parent", parent);
            }
            if (sortby !== null) {
                url.searchParams.append("sortby", sortby);
            }
            if (sortorder !== null) {
                url.searchParams.append("sortorder", sortorder)
            }
            fetch(url)
                .then((response) => response.json())
                .then((data) => {
                    loading_gif.remove();
                    for (let comment of data) {
                        let element = document.createElement("div");
                        element.classList.add("comment");

                        let img = document.createElement("img");
                        img.classList.add("comment_profile_picture")
                        img.src = comment.author_thumbnail;
                        img.alt = comment.author + "'s profile picture";
                        element.append(img);

                        let div = document.createElement("div");
                        div.classList.add("comment_text_section");

                        let p1 = document.createElement("div");
                        p1.classList.add("comment_metadata");

                        let strong = document.createElement("strong");
                        strong.append(comment.author);
                        p1.append(strong);

                        p1.append(" · " + comment._time_text);
                        p1.append(" · " + comment.like_count + " likes");

                        div.append(p1);

                        let p2 = document.createElement("p");
                        p2.classList.add("comment_text");
                        p2.append(comment.text);
                        div.append(p2);

                        if (comment.reply_count > 0) {
                            let p3 = document.createElement("div");

                            let a = document.createElement("a");

                            let reply_container = document.createElement("div");
                            reply_container.classList.add("comment_replies");

                            a.classList.add("view_comments");
                            a.append(comment.reply_count + (comment.reply_count > 1 ? " replies" : " reply"));
                            a.href = "#";
                            a.addEventListener("click", function(e) {
                                if (this.fetched) {
                                    reply_container.style.display = reply_container.style.display == "none" ? "block" : "none";
                                }
                                else {
                                    fetch_comments(reply_container, comment.id);
                                    this.fetched = true;
                                }
                                e.preventDefault();
                            });
                            p3.append(a);
                            p3.append(reply_container);
                            div.append(p3);
                        }

                        element.append(div);

                        container.append(element);
                    }
                });
        }
        fetch_comments(document.getElementById("comments"));
    </script>

    </body>
</html>
