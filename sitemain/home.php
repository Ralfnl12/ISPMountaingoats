<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Mountain Goats Page</title>
<link rel="stylesheet" href="style.css">
<script src="main.js" defer></script>
</head>
<body>

    <div class="topbar">
        
        <div>
            <button onclick="window.location.href='https://www.google.com'" class="button1">Mountain Goats</button>
            <button onclick="window.location.href='https://www.google.com'" class="button1">Help</button>
        </div>
        <input type="text" class="searchBox" id="searchBox" placeholder="zoeken..." onkeydown="search(event)">
    </div>
    <div class="nottopbar">
        <div>
    <button class="button2" style="margin-left: 70px; margin-top: 40px" id="button2">e-mail</button>
    <button class="button2" id="button3">e-mail</button>
    <button class="button2" id="button4">e-mail</button>

    <br>

    <button class="button2" style="margin-left: 70px;" id="button5">Google</button>
    <button class="button2" id="button6">Google</button>
    <button class="button2" id="button7">Google</button>
        </div>
        <iframe class="search-container" id="searchFrame" frameborder="0"></iframe>
    </div>
    
 

<!-- Rest van de pagina-inhoud komt hier -->

</body>
</html>
