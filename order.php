<?php
$vmCount = 0;

$small_server = ["cpu" => 4, "ram" => 32768, "ssd" => 4000];
$medium_server = ["cpu" => 8, "ram" => 65536, "ssd" => 8000];
$big_server = ["cpu" => 16, "ram" => 131072, "ssd" => 16000];

$cores_cost = ["1" => 5, "2" => 10, "4" => 18, "8" => 30, "16" => 45];
$ram_cost = ["512" => 5, "1024" => 10, "2048" => 20, "4096" => 40, "8192" => 80, "16384" => 160, "32768" => 320];
$storage_cost = ["10" => 5, "20" => 10, "40" => 20, "80" => 40, "240" => 120, "500" => 250, "1000" => 500];

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

    $myfile = file("kunden.csv");

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
    $myfile = fopen("kunden.csv", "a");
    $input = "\n" . $id . "," . $server . "," . $cores . "," . $ram . "," . $storage;
    fwrite($myfile, $input);

}

function delete($id)
{
    $myfile = file("kunden.csv");

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
                    <input type="radio" name="ram" id="ram" value="512" onchange="ramUpdate(5)" checked>512 MB <i>(5
                        CHF)</i><br>
                    <input type="radio" name="ram" id="ram" value="1024" onchange="ramUpdate(10)">1'024 MB <i>(10
                        CHF)</i><br>
                    <input type="radio" name="ram" id="ram" value="2048" onchange="ramUpdate(20)">2'048 MB <i>(20
                        CHF)</i><br>
                    <input type="radio" name="ram" id="ram" value="4096" onchange="ramUpdate(40)">4'096 MB <i>(40
                        CHF)</i><br>
                    <input type="radio" name="ram" id="ram" value="8192" onchange="ramUpdate(80)">8'192 MB <i>(80
                        CHF)</i><br>
                    <input type="radio" name="ram" id="ram" value="16384" onchange="ramUpdate(160)"><i>16'384 MB (160
                        CHF)</i><br>
                    <input type="radio" name="ram" id="ram" value="32768" onchange="ramUpdate(320)"><i>32'768 MB (320
                        CHF)</i><br>
                </div>

                <div class="card">
                    <h3>Prozessoren</h3>
                    <input type="radio" name="cpu" id="cpu" value="1" onchange="coresUpdate(5)" checked>1 Kern <i>(5
                        CHF)</i> <br>
                    <input type="radio" name="cpu" id="cpu" value="2" onchange="coresUpdate(10)">2 Kerne <i>(10 CHF)</i>
                    <br>
                    <input type="radio" name="cpu" id="cpu" value="4" onchange="coresUpdate(18)">4 Kerne <i>(18 CHF)</i>
                    <br>
                    <input type="radio" name="cpu" id="cpu" value="8" onchange="coresUpdate(30)">8 Kerne <i>(30 CHF)</i>
                    <br>
                    <input type="radio" name="cpu" id="cpu" value="16" onchange="coresUpdate(45)">16 Kerne <i>(45
                        CHF)</i> <br>
                </div>

                <div class="card">
                    <h3>Speicherplatz</h3>
                    <input type="radio" name="ssd" id="ssd" value="10" onchange="storageUpdate(5)" checked>10 GB <i>(5
                        CHF)</i><br>
                    <input type="radio" name="ssd" id="ssd" value="20" onchange="storageUpdate(10)">20 GB <i>(10
                        CHF)</i><br>
                    <input type="radio" name="ssd" id="ssd" value="40" onchange="storageUpdate(20)">40 GB <i>(20
                        CHF)</i><br>
                    <input type="radio" name="ssd" id="ssd" value="80" onchange="storageUpdate(40)">80 GB <i>(40
                        CHF)</i><br>
                    <input type="radio" name="ssd" id="ssd" value="240" onchange="storageUpdate(120)">240 GB <i>(120
                        CHF)</i><br>
                    <input type="radio" name="ssd" id="ssd" value="500" onchange="storageUpdate(250)"><i>500 GB (250
                        CHF)</i><br>
                    <input type="radio" name="ssd" id="ssd" value="1000" onchange="storageUpdate(500)"><i>1'000 GB (500
                        CHF)</i><br>
                </div>
            </div>
            <button type="submit" id="submit" class="big-button">Bestellen CHF <span id="price"></span> / Monat</button>
        </form>
    </main>
</div>
</body>
</html>

<script>
    let cores_cost = 5
    let ram_cost = 5
    let storage_cost = 5

    function coresUpdate(cores) {
        cores_cost = cores
        document.getElementById('price').innerHTML = (cores_cost + ram_cost + storage_cost) + ""
    }

    function ramUpdate(ram) {
        ram_cost = ram
        document.getElementById('price').innerHTML = (cores_cost + ram_cost + storage_cost) + ""
    }

    function storageUpdate(storage) {
        storage_cost = storage
        document.getElementById('price').innerHTML = (cores_cost + ram_cost + storage_cost) + ""
    }


    document.getElementById('price').innerHTML = (cores_cost + ram_cost + storage_cost) + ""
</script>
