<?php

require_once("../config.php");
require_once("auth.php");

$conn = db();

$id = $_GET['id'] ?? 0;

/* DELETE */

$conn->query("
DELETE FROM videos
WHERE id='$id'
");

/* REDIRECT */

header("Location: videos.php");
exit;

?>