<?php
// Includes  submission
require("./submission.php");

// Get Target content from URl
$content = isset($_GET["c"]) ? $_GET["c"] : "dashboard";

// Navigator
require("./navigator/navigator.php");

$connection->close();