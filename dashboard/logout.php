<?php
session_start();
session_destroy();
header("Location: /ABI_Foundation");
exit();
?>