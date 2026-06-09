<?php

require_once("config.php");

$conn = db();

$slug = $_GET['slug'] ?? '';

if(empty($slug)){
die("Video not found");
}

$stmt = $conn->prepare("
SELECT *
FROM videos
WHERE slug=?
");

$stmt->bind_param("s",$slug);

$stmt->execute();

$res = $stmt->get_result();

$v = $res->fetch_assoc();

if(!$v){
die("Video not found");
}

$conn->query("
UPDATE videos
SET views = views + 1
WHERE slug='$slug'
");

/* VIDEO */

$video = "";

if(!empty($v['file_id'])){

$tg = json_decode(
file_get_contents(
"https://api.telegram.org/bot$BOT_TOKEN/getFile?file_id=".$v['file_id']
),
true
);

if(isset($tg['result']['file_path'])){

$video =
"https://api.telegram.org/file/bot$BOT_TOKEN/".
$tg['result']['file_path'];

}

}

/* THUMB */

$thumb = "";

if(!empty($v['thumbnail'])){

$t = json_decode(
file_get_contents(
"https://api.telegram.org/bot$BOT_TOKEN/getFile?file_id=".$v['thumbnail']
),
true
);

if(isset($t['result']['file_path'])){

$thumb =
"https://api.telegram.org/file/bot$BOT_TOKEN/".
$t['result']['file_path'];

}

}

/* SEO */

$page_title =
$v['title']." - MYTube";

$page_desc =
$v['title']." watch online on MYTube";

$page_image = $thumb;

include("includes/header.php");

?>

<div class="px-3 mt-3">

<div class="relative rounded-2xl
overflow-hidden bg-black">

<video
controls
playsinline
class="w-full h-56 bg-black"
src="<?=$video?>"
poster="<?=$thumb?>">
</video>

</div>

</div>

<div class="px-4 mt-4">

<h1 class="text-lg font-semibold">

<?=$v['title']?>

</h1>

<p class="text-xs text-gray-500 mt-2">

<?=number_format($v['views'])?> views

</p>

</div>

<script type="application/ld+json">
{
"@context":"https://schema.org",
"@type":"VideoObject",
"name":"<?=$v['title']?>",
"description":"<?=$page_desc?>",
"thumbnailUrl":"<?=$page_image?>",
"uploadDate":"<?=date('c')?>",
"contentUrl":"<?=$video?>"
}
</script>

<?php include("includes/footer.php"); ?>