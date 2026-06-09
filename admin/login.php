<?php
session_start();

require_once("../config.php");

if(isset($_SESSION['admin'])){
header("Location: dashboard.php");
exit;
}

$error = "";

if($_POST){

$user = $_POST['username'];
$pass = $_POST['password'];

if($user=="admin" && $pass=="admin123"){

$_SESSION['admin'] = true;

header("Location: dashboard.php");
exit;

}else{
$error = "Invalid Login";
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

<title>MY Tube Admin</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

body{
background:#000;
font-family:sans-serif;
color:white;
display:flex;
align-items:center;
justify-content:center;
height:100vh;
overflow:hidden;
}

.glass{
background:#111;
border:1px solid rgba(255,255,255,.06);
backdrop-filter:blur(20px);
}

</style>

</head>

<body>

<div class="glass w-[95%] max-w-sm
rounded-3xl p-6">

<div class="text-center mb-8">

<div class="w-20 h-20 rounded-full
bg-red-600 mx-auto flex items-center
justify-center">

<i class="fas fa-play text-3xl"></i>

</div>

<h1 class="text-3xl font-bold mt-4">
MY Tube Admin
</h1>

<p class="text-gray-500 text-sm mt-1">
Secure Admin Panel
</p>

</div>

<?php if($error){ ?>

<div class="bg-red-600/20 text-red-500
p-3 rounded-xl text-sm mb-4">

<?=$error?>

</div>

<?php } ?>

<form method="POST" class="space-y-4">

<input
type="text"
name="username"
placeholder="Username"
class="w-full bg-black border border-white/10
rounded-2xl px-4 py-4 outline-none"
/>

<input
type="password"
name="password"
placeholder="Password"
class="w-full bg-black border border-white/10
rounded-2xl px-4 py-4 outline-none"
/>

<button
class="w-full bg-red-600
py-4 rounded-2xl font-semibold">

Login

</button>

</form>

</div>

</body>
</html>