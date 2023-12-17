<?php

function anzeigen()
{
    $myfile = file("kunden.txt");

    foreach ($myfile as $line) {
        echo "<div> <p>$line</p> </div>";
    }
}

function delete($id)
{
    $myfile = file("kunden.txt");

    foreach ($myfile as $line) {

        $dataElements = explode(",", $line);

        if ($dataElements[0] == $id) {
            $line = "";
        }
    }

    str_replace("\r\n\r\n", "\r\n");
}
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OmniCloud | Meine Dienste</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="shortcut icon" href="/img/logo.png" type="image/png">
</head>
<body>
<div id="wrapper">
    <?php include('header.html'); ?>
</div>
</body>
</html>