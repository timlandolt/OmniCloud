<?php
$vmCount = 0;

$small_server = ["cpu" => 4, "ram" => 32, "ssd" => 4000];
$medium_server = ["cpu" => 8, "ram" => 64, "ssd" => 8000];
$big_server = ["cpu" => 16, "ram" => 128, "ssd" => 16000];

$kunde = "";

getServerData();

if (isset($_POST[""]))                                                  //Tim
    testOrder($_POST[""], $_POST[""], $_POST[""]);                          //Tim
function getServerData()
{

    global $vmCount;
    global $small_server;
    global $medium_server;
    global $big_server;

    $myfile = file("kunden.txt");

    foreach ($myfile as $line) {

        $vmCount++;

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

function testOrder($cores, $ram, $storage)
{

    global $vmCount;
    global $small_server;
    global $medium_server;
    global $big_server;
    $server = "";

    if ($cores <= $small_server["cpu"] && $ram <= $small_server["ram"] && $storage <= $small_server["ssd"]) {
        $server = "small";
    } elseif ($cores <= $medium_server["cpu"] && $ram <= $medium_server["ram"] && $storage <= $medium_server["ssd"]) {
        $server = "medium";
    } elseif ($cores <= $big_server["cpu"] && $ram < $big_server["ram"] && $storage <= $big_server["ssd"]) {
        $server = "big";
    } else {
        //Tim
    }

    if ($server != "") {
        pushOrder($vmCount, $server, $cores, $ram, $storage);
    }
}

function pushOrder($vmCount, $server, $cores, $ram, $storage)
{
    $vmCount += 1;
    $myfile = fopen("kunden.txt", "a");
    $input = "\n" . $vmCount . "," . $server . "," . $cores . "," . $ram . "," . $storage;
    fwrite($myfile, $input);
}

?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OmniCloud | Server bestellen</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="shortcut icon" href="/img/logo.png" type="image/png">
</head>
<body>
<div id="wrapper">
    <?php include('header.html'); ?>
    <main>
        <section>

        </section>
    </main>
</div>
</body>
</html>
