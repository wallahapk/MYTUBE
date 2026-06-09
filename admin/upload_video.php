<?php

require_once("../config.php");
require_once("auth.php");

$conn = db();

$msg = "";

if($_POST){

$title = trim($_POST['title']);

if(
!empty($title)
&& !empty($_FILES['video']['tmp_name'])
&& !empty($_FILES['thumbnail']['tmp_name'])
){

/* SEO SLUG */

$slug = strtolower($title);

$slug = preg_replace(
'/[^a-z0-9]+/',
'-',
$slug
);

$slug = trim($slug,'-');

/* VIDEO */

$videoTmp = $_FILES['video']['tmp_name'];

$videoPost = [
'chat_id' => $CHANNEL_ID,
'video' => new CURLFile($videoTmp),
'caption' => $title
];

$ch = curl_init();

curl_setopt(
$ch,
CURLOPT_URL,
"https://api.telegram.org/bot$BOT_TOKEN/sendVideo"
);

curl_setopt(
$ch,
CURLOPT_RETURNTRANSFER,
true
);

curl_setopt(
$ch,
CURLOPT_POSTFIELDS,
$videoPost
);

$videoRes = curl_exec($ch);

curl_close($ch);

$videoData = json_decode(
$videoRes,
true
);

/* THUMB */

$thumbTmp =
$_FILES['thumbnail']['tmp_name'];

$thumbPost = [
'chat_id' => $CHANNEL_ID,
'photo' => new CURLFile($thumbTmp)
];

$ch2 = curl_init();

curl_setopt(
$ch2,
CURLOPT_URL,
"https://api.telegram.org/bot$BOT_TOKEN/sendPhoto"
);

curl_setopt(
$ch2,
CURLOPT_RETURNTRANSFER,
true
);

curl_setopt(
$ch2,
CURLOPT_POSTFIELDS,
$thumbPost
);

$thumbRes = curl_exec($ch2);

curl_close($ch2);

$thumbData = json_decode(
$thumbRes,
true
);

/* SAVE */

if(
isset($videoData['result']['video']['file_id'])
&&
isset($thumbData['result']['photo'][0]['file_id'])
){

$file_id =
$videoData['result']['video']['file_id'];

$thumb_id =
end($thumbData['result']['photo'])['file_id'];

/* AUTO DURATION */

$sec =
$videoData['result']['video']['duration'];

if($sec < 60){

$duration =
"00:" .
str_pad($sec,2,"0",STR_PAD_LEFT);

}elseif($sec < 3600){

$min = floor($sec / 60);

$rem = $sec % 60;

$duration =
str_pad($min,2,"0",STR_PAD_LEFT)
. ":" .
str_pad($rem,2,"0",STR_PAD_LEFT);

}else{

$hour = floor($sec / 3600);

$min =
floor(($sec % 3600) / 60);

$rem = $sec % 60;

$duration =
str_pad($hour,2,"0",STR_PAD_LEFT)
. ":" .
str_pad($min,2,"0",STR_PAD_LEFT)
. ":" .
str_pad($rem,2,"0",STR_PAD_LEFT);

}

/* CODE */

$code =
substr(md5(time()),0,10);

/* INSERT */

$stmt = $conn->prepare("
INSERT INTO videos
(
title,
file_id,
thumbnail,
duration,
code,
slug,
views
)
VALUES
(
?,?,?,?,?,?,0
)
");

$stmt->bind_param(
"ssssss",
$title,
$file_id,
$thumb_id,
$duration,
$code,
$slug
);

$stmt->execute();

$msg =
"Video Uploaded Successfully";

}else{

$msg = "Upload Failed";

}

}else{

$msg = "All fields required";

}

}

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0"
/>

<title>Upload Video</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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

input{
background:#000;
border:1px solid rgba(255,255,255,.08);
outline:none;
}

</style>

</head>

<body>

<div class="p-4">

<h1 class="text-3xl font-bold">
Upload Video
</h1>

<p class="text-gray-500 mt-1">
Upload videos to MYTube
</p>

<?php if($msg){ ?>

<div class="bg-red-600/20
text-red-500 rounded-2xl
p-4 mt-5">

<?=$msg?>

</div>

<?php } ?>

<form
method="POST"
enctype="multipart/form-data"
class="space-y-5 mt-6">

<!-- TITLE -->

<div class="card rounded-2xl p-4">

<label class="text-sm text-gray-400">
Video Title
</label>

<input
type="text"
name="title"
placeholder="Enter video title"
class="w-full rounded-xl px-4 py-4 mt-3"
/>

</div>

<!-- VIDEO -->

<div class="card rounded-2xl p-4">

<label class="text-sm text-gray-400">
Select Video
</label>

<input
type="file"
name="video"
accept="video/*"
class="w-full rounded-xl px-4 py-4 mt-3"
/>

</div>

<!-- THUMB -->

<div class="card rounded-2xl p-4">

<label class="text-sm text-gray-400">
Thumbnail Image
</label>

<input
type="file"
name="thumbnail"
accept="image/*"
class="w-full rounded-xl px-4 py-4 mt-3"
/>

</div>

<!-- BUTTON -->

<button
class="w-full bg-red-600
rounded-2xl py-4
font-semibold text-lg">

Upload Video

</button>

</form>

</div>

<?php include("sidebar.php"); ?>