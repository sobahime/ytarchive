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
<?php
    $stmt = $pdo->query("SELECT id FROM video ORDER BY RANDOM() LIMIT 1");
    $randomRow = $stmt->fetch(PDO::FETCH_ASSOC);
    $randomId = $randomRow['id'];
?>
        <p class="back"><a href="index.php">Back</a></p>
        <p class="back morerandom"><a href="watchrandom.php?v=<?php echo htmlspecialchars($randomId);?>">another random video</a></p>
<?php
$sql = 'SELECT id, view_count, channel_id, title, epoch, isonline, channel, upload_date, channel_id, ext, like_count,
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
    $epoch = $row['epoch'];
    $snapdate = new DateTime("@$epoch");
    echo '<h1 class="snapdate">snapshot date : ' . htmlspecialchars($snapdate->format('Y/m/d H:i:s')) . '</h1>';
    echo '<h2 class="available">status : ' . ($row['isonline']?'still available on <a class="ytlink" target="_blank" href="https://youtube.com/watch?v=' . htmlspecialchars($row['id']) . '">youtube</a>':'deleted from <a class="ytlink" target="_blank" href="https://youtube.com/watch?v=' . htmlspecialchars($row['id']) . '">youtube</a>') . '</h2>';
    echo '<video controls poster="content/'
        . htmlspecialchars($row['id']) . '.webp">';
    echo '<source src="content/'
        . htmlspecialchars($row['id']) . '.'
        . htmlspecialchars($row['ext']) .'" type="video/'
        . htmlspecialchars($row['ext']) .'" />';
    echo '</video>';
    echo '<div class="video_metadata">';
    echo '<strong class="video_title">' . htmlspecialchars($row['title']) . '</strong>';
    echo '<hr class="videobar">';
    echo '<p class="view_count">' . htmlspecialchars($row['view_count']) . ' views, ' . htmlspecialchars($row['like_count']) . ' likes</p>';
    echo '<div class="channelinfo">';
    echo '<img class="channelpp" src="content/' . htmlspecialchars($row['channel_id']) . '.webp" alt="' . htmlspecialchars($row['channel']) . '"/>';
    echo '<div><span class="watch_date"><a class="channel" href="' . $url_channel_escaped . '">' . htmlspecialchars($row['channel']) . '</a>, ' . htmlspecialchars($date) . '</span><hr class="channelbar"></div>';
    echo '</div>';
    echo '';
    echo '<p class="text_description">original description :</p>';
    echo '<p class="description">' . nl2br(htmlspecialchars($row['description'])) . '</p>';
    echo '</div>';
//    echo 'video {aspect-ratio: . }'
//	echo '</a>';
}

$sql2 = 'SELECT COUNT(*)
        FROM comment
        WHERE video_id = :id;';
$sth2 = $pdo->prepare($sql2);
$sth2->execute(['id' => $_REQUEST['v']]);
$data2 = $sth2->fetchAll();


    ?>

    <div class="comment_container">
        <div class="comment_header">
            <?php echo $data2[0][0]; ?> comments ·
            <select class="comment_option" id="comments_sortby">
                <option default value="like_count">Sort by likes</option>
                <option value="timestamp">Sort by date</option>
            </select>
            <select class="comment_option" id="comments_sortorder">
                <option default value="desc">Descending</option>
                <option value="asc">Ascending</option>
            </select>
            <hr class="commentbar"/>
        </div>
        <div id="comments"></div>
    </div>
    <script>
        function fetch_comments(container, parent=null, sortby=null, sortorder=null, page=0, clear=true) {
            let loading_gif = document.createElement("img");
            loading_gif.classList.add("loading_gif");
            loading_gif.src = "loading.gif";
            if (clear) {
                container.insertBefore(loading_gif, container.firstChild);
            } else {
                container.append(loading_gif);
            }
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
                url.searchParams.append("sortorder", sortorder);
            }
            if (page !== null) {
                url.searchParams.append("page", page);
            }
            fetch(url)
                .then((response) => response.json())
                .then((data) => {
                    if (clear) {
                        container.textContent = "";
                    } else {
                        loading_gif.remove();
                    }
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

                        let hr = document.createElement("hr");
                        hr.classList.add("commenttextbar");

                        let strong = document.createElement("strong");
                        strong.append(comment.author);
                        p1.append(hr);
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

                    if (data.length > 0) {
                        let load_more = document.createElement("a");
                        load_more.classList.add("view_comments");
                        load_more.append("Load more...");
                        load_more.href = "#";
                        load_more.addEventListener("click", function(e) {
                            fetch_comments(container, parent, sortby, sortorder, page + 1, false);
                            e.preventDefault();
                            this.remove();
                        });

                        container.append(load_more);
                    }
                });
        }

        function refresh_comments() {
            let comments = document.getElementById("comments");
            //comments.textContent = "";
            fetch_comments(comments, null,
                document.getElementById("comments_sortby").value,
                document.getElementById("comments_sortorder").value);
        }

        for (let element of document.getElementsByClassName("comment_option")) {
            element.addEventListener("change", function(e) {
                refresh_comments();
            });
        }
        refresh_comments();
    </script>

    </body>
</html>
