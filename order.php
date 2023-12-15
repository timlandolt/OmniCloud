<?php
$vmCount = 0;

$small_server = ["cpu" => 4, "ram" => 32768, "ssd" => 4000];
$medium_server = ["cpu" => 8, "ram" => 65536, "ssd" => 8000];
$big_server = ["cpu" => 16, "ram" => 131072, "ssd" => 16000];

$kunde = "";

getServerData();

if (isset($_POST["cpu"]))
    testOrder($_POST["cpu"], $_POST["ram"], $_POST["ssd"]);

function getServerData()
{
    global $vmCount;
    global $small_server;
    global $medium_server;
    global $big_server;

    $myfile = file("kunden.txt");

    foreach ($myfile as $line) {
        if (trim($line) == '') {
            unset($myfile[$vmCount]);
            continue;
        }

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
    global $small_server;
    global $medium_server;
    global $big_server;
    global $alarm;
    $server = "";

    if ($cores <= $small_server["cpu"] && $ram <= $small_server["ram"] && $storage <= $small_server["ssd"]) {
        $server = "small";
    } elseif ($cores <= $medium_server["cpu"] && $ram <= $medium_server["ram"] && $storage <= $medium_server["ssd"]) {
        $server = "medium";
    } elseif ($cores <= $big_server["cpu"] && $ram < $big_server["ram"] && $storage <= $big_server["ssd"]) {
        $server = "big";
    } else {
        echo '
            <div class="banner alarm">
                <h4>Entschuldigen Sie die Unannehmlichkeiten</h4>
                <p>Unsere Server heben keine Kapazitäten für Ihre aktuelle Konfiguration. Probieren Sie es mit einer anderen, kleineren Konfiguration.</p>
            </div>
        ';
    }

    if ($server != "") {
        pushOrder(str_pad(mt_rand(0, 1000000), 6, '0', STR_PAD_LEFT), $server, $cores, $ram, $storage);
        echo '
            <div class="banner confirm">
                <h4>Ihre Bestellung war erfolgreich!</h4>
                <p>Ihr Server mit ' . $cores . ' Kern(en), ' . $ram . ' MB RAM und ' . $storage . ' GB SSD-Speicher wurde erfolgreich aufgesetzt! Sie können diesen unter <a href="/meine-dienste.php">Meine Dienste</a> verwalten.</p>
            </div>
        ';
    }
}

function pushOrder($id, $server, $cores, $ram, $storage)
{
    $myfile = fopen("kunden.txt", "a");
    $input = "\n" . $id . "," . $server . "," . $cores . "," . $ram . "," . $storage;
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
    <div class="hero">
        <h1>Server Konfigurieren</h1>
        <p>In nur wenigen Clicks!</p>
    </div>
    <main>
        <h2 style="text-align: center">Wählen Sie Ihre Spezifikationen aus</h2>
        <form action="order.php" method="post" class="centered flex-col">
            <div class="flex-section">
                <div class="card">
                    <h3>Arbeitsspeicher</h3>
                    <input type="radio" name="ram" id="ram" value="512" checked>512 MB <i>(5 CHF)</i><br>
                    <input type="radio" name="ram" id="ram" value="1024">1'024 MB <i>(10 CHF)</i><br>
                    <input type="radio" name="ram" id="ram" value="2048">2'048 MB <i>(20 CHF)</i><br>
                    <input type="radio" name="ram" id="ram" value="4096">4'096 MB <i>(40 CHF)</i><br>
                    <input type="radio" name="ram" id="ram" value="8192">8'192 MB <i>(80 CHF)</i><br>
                    <input type="radio" name="ram" id="ram" value="16384"><i>16'384 MB (160 CHF)</i><br>
                    <input type="radio" name="ram" id="ram" value="32768"><i>32'768 MB (320 CHF)</i><br>
                </div>

                <div class="card">
                    <h3>Prozessoren</h3>
                    <input type="radio" name="cpu" id="cpu" value="1" checked>1 Kern <i>(5 CHF)</i> <br>
                    <input type="radio" name="cpu" id="cpu" value="2">2 Kerne <i>(10 CHF)</i> <br>
                    <input type="radio" name="cpu" id="cpu" value="4">4 Kerne <i>(18 CHF)</i> <br>
                    <input type="radio" name="cpu" id="cpu" value="8">8 Kerne <i>(30 CHF)</i> <br>
                    <input type="radio" name="cpu" id="cpu" value="16">16 Kerne <i>(45 CHF)</i> <br>
                </div>

                <div class="card">
                    <h3>Speicherplatz</h3>
                    <input type="radio" name="ssd" id="ssd" value="10" checked>10 GB <i>(5 CHF)</i><br>
                    <input type="radio" name="ssd" id="ssd" value="20">20 GB <i>(10 CHF)</i><br>
                    <input type="radio" name="ssd" id="ssd" value="40">40 GB <i>(20 CHF)</i><br>
                    <input type="radio" name="ssd" id="ssd" value="80">80 GB <i>(40 CHF)</i><br>
                    <input type="radio" name="ssd" id="ssd" value="240">240 GB <i>(120 CHF)</i><br>
                    <input type="radio" name="ssd" id="ssd" value="500"><i>500 GB (250 CHF)</i><br>
                    <input type="radio" name="ssd" id="ssd" value="1000"><i>1'000 GB (500 CHF)</i><br>
                </div>
            </div>
            <input type="submit" value="Bestellen" id="submit" class="big-button">
        </form>
    </main>
</div>
</body>
</html>
