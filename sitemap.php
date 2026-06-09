<?php

require_once("config.php");

header("Content-Type: application/xml");

$conn = db();

$res = $conn->query("SELECT slug FROM videos");

echo '<?xml version="1.0" encoding="UTF-8"?>';

?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

<?php while($v = $res->fetch_assoc()){ ?>

<url>
<loc>
https://viral.totalh.net/video/<?=$v['slug']?>
</loc>
</url>

<?php } ?>

</urlset>