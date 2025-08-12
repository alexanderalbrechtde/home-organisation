<?php
require __DIR__ . '/../../partials/header.php';

echo'
<body>
<h1>Dashboard</h1>
<form action="" method="post">
    <input type="hidden" name =destroySession value="1">
    <input type="submit" value="logout">
</form>
<br>
<br>
<br>
<h2></h2>
</body>';

require __DIR__ . '/../../partials/footer.php';




#Session beenden
$destroySessionFlag = filter_input(INPUT_POST, 'destroySession');
if ($destroySessionFlag == 1) {
    session_destroy();
    header('Location: /login');
}