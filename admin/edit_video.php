<?php

require_once("../config.php");
require_once("auth.php");

$conn = db();

$id = $_GET['id'] ?? 0;

$video = $conn->query("
SELECT *
FROM videos
WHERE id='$id'
")->fetch_assoc();

if(!$video){
die("Video not found");
}

$msg = "";

/* UPDATE */

if($_POST){

$title = trim($_POST['title']);

if(!empty($title)){

$stmt = $conn->prepare("
UPDATE videos
SET title=?
WHERE id=?
");

$stmt->bind_param("si",$title,$id);

$stmt->execute();

$msg = "Video Updated Successfully";

/* REFRESH */

$video = $conn->query("
SELECT *
FROM videos
WHERE id='$id'
")->fetch_assoc();

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

<title>Edit Video</title>

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
Edit Video
</h1>

<p class="text-gray-500 mt-1">
Update video details
</p>

<?php if($msg){ ?>

<div class="bg-green-600/20
text-green-500 rounded-2xl
p-4 mt-5">

<?=$msg?>

</div>

<?php } ?>

<form
method="POST"
class="space-y-5 mt-6">

<div class="card rounded-2xl p-4">

<label class="text-sm text-gray-400">
Video Title
</label>

<input
type="text"
name="title"
value="<?=$video['title']?>"
class="w-full rounded-xl
px-4 py-4 mt-3"
/>

</div>

<button
class="w-full bg-blue-600
rounded-2xl py-4
font-semibold text-lg">

Save Changes

</button>

</form>

</div>

<?php include("sidebar.php"); ?>