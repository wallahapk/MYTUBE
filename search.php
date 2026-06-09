<?php

require_once("config.php");

$conn = db();

$q = $_GET['q'] ?? '';

$stmt = $conn->prepare(
"SELECT * FROM videos WHERE title LIKE ? ORDER BY id DESC"
);

$search = "%$q%";

$stmt->bind_param("s",$search);

$stmt->execute();

$res = $stmt->get_result();

include("includes/header.php");

?>

<form class="p-4">

<input
name="q"
value="<?=$q?>"
placeholder="Search videos"
class="w-full bg-[#111]
rounded-2xl px-5 py-4 outline-none">

</form>

<div class="px-4 space-y-5 mb-28">

<?php while($v = $res->fetch_assoc()){ ?>

<a href="/video/<?=$v['slug']?>">

<div class="bg-[#111]
rounded-2xl p-4">

<?=$v['title']?>

</div>

</a>

<?php } ?>

</div>

<?php include("includes/footer.php"); ?>