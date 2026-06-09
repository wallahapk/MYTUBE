<?php

require_once("../config.php");
require_once("auth.php");

$conn = db();

$videos = $conn->query("
SELECT *
FROM videos
ORDER BY id DESC
");

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Videos</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>

body{
background:#000;
font-family:sans-serif;
color:white;
padding-bottom:100px;
}

.card{
background:#111;
border:1px solid rgba(255,255,255,.06);
}

</style>

</head>

<body>

<div class="p-4">

<h1 class="text-3xl font-bold">
Videos
</h1>

<div class="space-y-4 mt-6">

<?php while($v = $videos->fetch_assoc()){ ?>

<?php

$thumb = "https://placehold.co/600x400";

if($v['thumbnail']){

$t = json_decode(file_get_contents(
"https://api.telegram.org/bot$BOT_TOKEN/getFile?file_id=".$v['thumbnail']
),true);

if(isset($t['result']['file_path'])){

$thumb =
"https://api.telegram.org/file/bot$BOT_TOKEN/".
$t['result']['file_path'];

}

}

?>

<div class="card rounded-2xl overflow-hidden">

<img
src="<?=$thumb?>"
class="w-full h-44 object-cover"
/>

<div class="p-4">

<h2 class="font-semibold text-lg">

<?=$v['title']?>

</h2>

<p class="text-gray-500 text-sm mt-1">

<?=number_format($v['views'])?> views

</p>

<div class="flex gap-3 mt-4">

<a href="edit_video.php?id=<?=$v['id']?>"
class="bg-blue-600 px-4 py-2
rounded-xl text-sm">

Edit

</a>

<a href="delete_video.php?id=<?=$v['id']?>"
class="bg-red-600 px-4 py-2
rounded-xl text-sm">

Delete

</a>

</div>

</div>

</div>

<?php } ?>

</div>

</div>

<?php include("sidebar.php"); ?>