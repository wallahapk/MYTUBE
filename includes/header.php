<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
<?=$page_title ?? 'MYTube'?>
</title>

<meta name="description"
content="<?=$page_desc ?? 'Watch videos online on MYTube'?>">

<meta name="robots"
content="index, follow">

<meta property="og:title"
content="<?=$page_title ?? 'MYTube'?>">

<meta property="og:description"
content="<?=$page_desc ?? ''?>">

<meta property="og:image"
content="<?=$page_image ?? ''?>">

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

body{
background:#000;
color:white;
font-family:sans-serif;
overflow-x:hidden;
}

::-webkit-scrollbar{
display:none;
}

.line2{
display:-webkit-box;
-webkit-line-clamp:2;
-webkit-box-orient:vertical;
overflow:hidden;
}

</style>

</head>

<body>

<div class="sticky top-0 z-50
bg-black/90 backdrop-blur-xl
border-b border-white/5">

<div class="flex items-center
justify-between px-4 py-3">

<h1 class="text-2xl font-black text-red-600">
MYTube
</h1>

<a href="search.php">
<i class="fas fa-search text-xl"></i>
</a>

</div>

</div>