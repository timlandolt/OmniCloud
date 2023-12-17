<?php
$cores_pricelist = ["1" => 5, "2" => 10, "4" => 18, "8" => 30, "16" => 45];
$ram_pricelist = ["512" => 5, "1024" => 10, "2048" => 20, "4096" => 40, "8192" => 80, "16384" => 160, "32768" => 320];
$storage_pricelist = ["10" => 5, "20" => 10, "40" => 20, "80" => 40, "240" => 120, "500" => 250, "1000" => 500];

$income = 0;

$small_server = ["cpu" => 4, "ram" => 32768, "ssd" => 4000];
$medium_server = ["cpu" => 8, "ram" => 65536, "ssd" => 8000];
$big_server = ["cpu" => 16, "ram" => 131072, "ssd" => 16000];

einkommensBerechnung();
function einkommensBerechnung()
{
    global $income;
    global $cores_pricelist;
    global $ram_pricelist;
    global $storage_pricelist;

    $myfile = file("kunden.csv");

    foreach ($myfile as $line) {

        if (trim($line) != "") {
            $dataElements = explode(",", trim($line));

            $income += $cores_pricelist[$dataElements[2]];
            $income += $ram_pricelist[$dataElements[3]];
            $income += $storage_pricelist[$dataElements[4]];
        }
    }
}

function getServerData()
{
    global $small_server;
    global $medium_server;
    global $big_server;

    $myfile = file("kunden.csv");

    foreach ($myfile as $line) {

        $dataElements = explode(",", $line);

        if ($dataElements[1] == "small") {

            $small_server["cpu"] -= $dataElements[2];
            $small_server["ram"] -= $dataElements[3];
            $small_server["ssd"] -= $dataElements[4];

        } elseif ($dataElements[1] == "medium") {

            $medium_server["cpu"] -= $dataElements[2];
            $medium_server["ram"] -= $dataElements[3];
            $medium_server["ssd"] -= $dataElements[4];

        } elseif ($dataElements[1] == "big") {

            $big_server["cpu"] -= $dataElements[2];
            $big_server["ram"] -= $dataElements[3];
            $big_server["ssd"] -= $dataElements[4];

        }
    };
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