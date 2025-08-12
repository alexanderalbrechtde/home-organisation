<?php
echo'
<body>
<form action="" method="post">
    <input type="hidden" name =destroySession value="1">
    <input type="submit" value="logout">
</form>

</body>';





#Session beenden
$destroySessionFlag = filter_input(INPUT_POST, 'destroySession');
if ($destroySessionFlag == 1) {
    session_destroy();
    header('Location: /login');
}