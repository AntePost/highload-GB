<?php

echo 'hello';
session_start();
$_SESSION["test"] = "this is a test";
echo $_SESSION["test"];
