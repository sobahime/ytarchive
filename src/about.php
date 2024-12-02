<?php
require_once 'database.php';
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>about</title>
        <link rel="icon" type="image/png" href="/favicon.png">
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
<div class="titre titreabout">
    <h1 class="titretexte shadow">YTPMV/音MAD archive</h1>
    <h1 class="titretexte R" >YTPMV/音MAD archive</h1>
    <h1 class="titretexte G">YTPMV/音MAD archive</h1>
    <h1 class="titretexte B">YTPMV/音MAD archive</h1>
    <a href="index.php" class="titretexte indexlink">YTPMV/音MAD archive</a>
</div>
<?php

    $sth = $pdo->prepare("SELECT COUNT(*) FROM video");
    $sth->execute();
    $rowCount = $sth->fetchColumn();

?>
<div class="about">
        <img src="bgpony.png" alt="bgpony" class="fgpony" />
        <h1>media.desirintoplaisir.net</h1>
        <h2 class="licence">© <a class="github" href="https://www.gnu.org/licenses/gpl-3.0.html">GNU GPL version 3</a></h2>
        <h3>dev: lmi & plts</h3>
        <h3>contact : ytpmvaddictATATATdesirintoplaisir.net (replace ATATAT with @)</h3>
        <h3>source code available on <a class="github" href="https://github.com/sobahime/ytarchive">github</a></h3>
        <p class="agauche">
        this archive currently hosts <?php echo htmlspecialchars($rowCount); ?> videos that i personally selected. it is designed in a way that allows precise search, easy sorting, and visualization of videos and metadatas. hopefully, this will make research about YTPMV/音MAD easier
        </p>
        <p class="adroite">
        all videos were ripped in highest quality using yt-dlp. i’m looking for more deleted videos, if you happen to have youtube rips of channels or videos that are now unavailable, with thumbnail and video metadata including comments, please contact us
        </p>
        <h3>have a good time watchin :)</h3>
        <br class="brabout" />
        <h2>quelques mots…</h2>
        <p class="mots">
Ce site est une archive personnelle de YTPMV/音MAD ayant été postées sur YouTube. Bien que fichiers numériques théoriquement impérissables, ces vidéos ont tendance à disparaître, comme tout ce qui est posté sur internet. Les raisons les plus courantes sont les problèmes de droits d’auteur, les violations des conditions d’utilisation de YouTube (qui ont historiquement évolué pour favoriser au maximum les annonceurs au détriment des utilisateurices) et la volonté propre des créateurices. De plus, l’algorithme de recherches et de suggestions de YouTube a évolué d’une façon qui, personnellement, me ferait presque croire à la dead internet theory. Par ailleurs, il existe de nombreuses archives de YTPMV supprimées sur archive.org, mais une fois de plus, l’interface rend l’expérience similaire à celle de chercher une aiguille dans une botte de foin. Il appairait clairement nécessaire d’archiver le mieux possible ces vidéos, mais aussi de les rendre accessibles.<br class="brabout" />
Afin de répondre à ce double problème à mon échelle, j’ai créé ce site. <br class="brabout" />
Vous trouverez ici des vidéos que j’ai personnellement sélectionnées comme étant représentatives de la culture YTPMV/音MAD, des vidéos historiquement importantes, et des vidéos qui ont été supprimées de YouTube. Un des meilleurs moyens d’en apprendre plus est d’en regarder quelques centaines, afin de visualiser comment les différent-es créateurices exploitent les règles du format, joue des différences/ressemblances, s’inspirent les uns des autres et se répondent. Je vous invite à explorer librement l’archive, à constater les différents styles et à être curieuxse de ce que vous pourrez trouver. <br class="brabout" />
Sur la page d’accueil, vous trouverez plusieurs boutons : « browse » qui permet de naviguer dans l’intégralité de l’archive, « by year » qui permet de trier les vidéos par année d’upload sur YouTube, et « channels » qui permet de trier les vidéos par auteurice. Une barre de recherche configurable est également présente et permet de rechercher dans plusieurs champs au choix. Sur la page d’une vidéo, vous trouverez la vidéo dans la plus haute qualité possible, ainsi que la date d’archivage, son statut, et toutes les métadonnées qui en font une vidéo YouTube : titre, description, nombre de vues, de likes, et les commentaires. <br class="brabout" />
Le site est conçu de façon à faciliter toute démarche de recherche qui aurait pour objet les YTPMV/音MAD. Cette archive est une vidéothèque et un outil, créé avec une volonté d’historiser les vidéos, leur contexte, et une partie des interactions de leur communauté. L’archivage exhaustif permet d’identifier clairement les vidéos, leurs auteurices, leurs dates de création, la description donne également souvent des informations utiles. On peut également consulter les dynamiques communautaires à travers les commentaires devenus statiques et pouvant maintenant servir de matériau brut. La recherche et le système de tri sont pensés pour être le plus transparent possibles, afin de permettre de trouver le plus facilement possible ce que l’on cherche. Tout le contenu du site est téléchargeable directement. Une case à cocher dans la navigation permet d’afficher directement les vidéos qui ont été supprimées de YouTube. L’objectif est de pouvoir replacer au maximum les vidéos dans leurs contextes, car une vidéo YouTube est souvent un fichier mp4, mais toujours aussi un évènement et un lieu social virtuel.
        </p>
</div>
    </body>
</html>
