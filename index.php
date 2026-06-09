<?php

require_once("config.php");

$conn = db();

$res = $conn->query(
"SELECT * FROM videos ORDER BY id DESC"
);

$page_title = "Viral Totalh Net";

include("includes/header.php");

?>

<div class="px-4 mt-4 mb-5">

<h2 class="text-2xl font-bold">
Latest Videos
</h2>

</div>

<div class="px-4 space-y-5 mb-28">

<?php while($v = $res->fetch_assoc()){ ?>

<?php

$thumb = "";

$t = json_decode(
file_get_contents(
"https://api.telegram.org/bot$BOT_TOKEN/getFile?file_id=".$v['thumbnail']
),true);

if(isset($t['result']['file_path'])){

$thumb =
"https://api.telegram.org/file/bot$BOT_TOKEN/".
$t['result']['file_path'];

}

?>

<a href="/video/<?=$v['slug']?>">

<div class="bg-[#0d0d0d]
rounded-2xl overflow-hidden
border border-white/5">

<div class="relative">

<img
src="<?=$thumb?>"
class="w-full h-52 object-cover">

<div class="absolute inset-0
flex items-center justify-center">

<div class="w-16 h-16 rounded-full
bg-red-600/90 flex items-center
justify-center">

<i class="fas fa-play text-white text-2xl ml-1"></i>

</div>

</div>

<div class="absolute bottom-3 right-3
bg-black/80 text-white text-xs
px-2 py-1 rounded-lg">

<?=$v['duration']?>

</div>

</div>

<div class="p-3">

<h2 class="text-[16px]
font-medium line2">

<?=$v['title']?>

</h2>

<p class="text-xs text-gray-500 mt-2">

<?=number_format($v['views'])?> views

</p>

</div>

</div>

</a>

<?php } ?>

</div>

<?php include("includes/footer.php"); ?>