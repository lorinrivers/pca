<?php
$filename = htmlentities(trim($_GET['calendar']));
header('Content-disposition: attachment; filename=event.ics');
header('Content-type: text/calendar');
readfile($filename);
?>