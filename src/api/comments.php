<?php
require_once '../database.php';

if (isset($_REQUEST['parent'])) {
    $parent_clause = 'parent = :parent';
    $sortby = 'timestamp';
    $sortorder = 'ASC';
} else {
    $parent_clause = 'parent IS NULL';
    $sortby = 'like_count';
    $sortorder = 'DESC';
}
if (isset($_REQUEST['sortby'])
    && in_array($_REQUEST['sortby'], [
        'like_count',
        'timestamp',
        'reply_count'
    ])) {
        $sortby = $_REQUEST['sortby'];
    }
if (isset($_REQUEST['sortorder'])) {
    if ($_REQUEST['sortorder'] == 'asc') {
        $sortorder = "ASC";
    } else if ($_REQUEST["sortorder"] == "desc") {
        $sortorder = "DESC";
    }
}
$sql = "
SELECT
    *,
    (SELECT COUNT(*) FROM comment c WHERE c.parent = p.id) AS reply_count
FROM comment p
WHERE video_id = :video_id
AND $parent_clause
ORDER BY $sortby $sortorder;
";
//echo $sql; exit(0);
$sth = $pdo->prepare($sql);
if (isset($_REQUEST['parent'])) {
    $sth->execute([
        'video_id' => $_REQUEST['video_id'],
        'parent' => $_REQUEST['parent']
    ]);
} else {
    $sth->execute([
        'video_id' => $_REQUEST['video_id']
    ]);
}
$data = $sth->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($data);
header('Content-Type: application/json; charset=utf-8');
echo $json;
?>
