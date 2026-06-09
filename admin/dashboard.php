<?php

require_once("../config.php");
require_once("auth.php");

$conn = db();

$totalVideos = $conn->query("
SELECT id FROM videos
")->num_rows;

$totalViews = $conn->query("
SELECT SUM(views) as v
FROM videos
")->fetch_assoc()['v'];

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Dashboard</title>

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
Dashboard
</h1>

<p class="text-gray-500 mt-1">
MY Tube Admin Panel
</p>

<!-- STATS -->

<div class="grid grid-cols-2 gap-4 mt-6">

<div class="card rounded-3xl p-5">

<p class="text-gray-500 text-sm">
Total Videos
</p>

<h2 class="text-3xl font-bold mt-2">
<?=$totalVideos?>
</h2>

</div>

<div class="card rounded-3xl p-5">

<p class="text-gray-500 text-sm">
Total Views
</p>

<h2 class="text-3xl font-bold mt-2">
<?=number_format($totalViews)?>
</h2>

</div>

</div>

<!-- BUTTONS -->

<div class="space-y-4 mt-8">

<a href="upload_video.php"
class="block bg-red-600
rounded-2xl p-5 text-center font-semibold">

Upload New Video

</a>

<a href="videos.php"
class="block bg-[#111]
border border-white/5
rounded-2xl p-5 text-center font-semibold">

Manage Videos

</a>

</div>

</div>

<?php include("sidebar.php"); ?>