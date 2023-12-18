<?php
$cores_pricelist = ["1" => 5, "2" => 10, "4" => 18, "8" => 30, "16" => 45];
$ram_pricelist = ["512" => 5, "1024" => 10, "2048" => 20, "4096" => 40, "8192" => 80, "16384" => 160, "32768" => 320];
$storage_pricelist = ["10" => 5, "20" => 10, "40" => 20, "80" => 40, "240" => 120, "500" => 250, "1000" => 500];

$income = 0;

$small_server_used = ["cpu" => 0, "ram" => 0, "ssd" => 0];
$medium_server_used = ["cpu" => 0, "ram" => 0, "ssd" => 0];
$big_server_used = ["cpu" => 0, "ram" => 0, "ssd" => 0];

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

function einzelBerechnung($id)
{
    $localIncome = 0;
    global $cores_pricelist;
    global $ram_pricelist;
    global $storage_pricelist;

    $myfile = file("kunden.csv");

    foreach ($myfile as $line) {

        if (trim($line) != "") {
            $dataElements = explode(",", trim($line));

            if (trim($dataElements[0]) == $id) {
                $localIncome += $cores_pricelist[$dataElements[2]];
                $localIncome += $ram_pricelist[$dataElements[3]];
                $localIncome += $storage_pricelist[$dataElements[4]];

                return $localIncome;
            }
        }
    }
}

function getServerData()
{

    global $small_server_used;
    global $medium_server_used;
    global $big_server_used;

    $myfile = file("kunden.csv");

    foreach ($myfile as $line) {

        if (trim($line) != '') {
            $dataElements = explode(",", trim($line));

            if ($dataElements[1] == "small") {

                $small_server_used["cpu"] += $dataElements[2];
                $small_server_used["ram"] += $dataElements[3];
                $small_server_used["ssd"] += $dataElements[4];

            } elseif ($dataElements[1] == "medium") {

                $medium_server_used["cpu"] += $dataElements[2];
                $medium_server_used["ram"] += $dataElements[3];
                $medium_server_used["ssd"] += $dataElements[4];

            } elseif ($dataElements[1] == "big") {

                $big_server_used["cpu"] += $dataElements[2];
                $big_server_used["ram"] += $dataElements[3];
                $big_server_used["ssd"] += $dataElements[4];

            }
        }
    }
}

getServerData();

function anzeigen()
{
    $myfile = file("kunden.csv");

    foreach ($myfile as $line) {
        if (trim($line) != '') {
            $new_line = explode(',', $line);
            $id = $new_line[0];
            $physical_server = $new_line[1];
            $cores = $new_line[2];
            $ram = $new_line[3];
            $storage = $new_line[4];
            echo "<tr>";
            echo "<td class='block-right'>" . $id . "</td>";
            echo "<td class='block-right'>" . $cores . "</td>";
            echo "<td class='block-right'>" . $ram . " MB</td>";
            echo "<td class='block-right'>" . $storage . " GB</td>";
            echo "<td class='block-right'>" . $physical_server . "</td>";
            echo "<td class='block-right'>CHF " . einzelBerechnung($id) .".-</td>";
            echo "</tr>";
        }
    }
}

?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OmniCloud | Admin</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="shortcut icon" href="/img/logo.png" type="image/png">
</head>
<body>
<script>
    function drawBarChart(value, maxValue, canvasId, width = 100, height = 300) {
        console.log(value + " " + maxValue + " " + canvasId)
        let canvas = document.getElementById(canvasId);
        let context = canvas.getContext('2d');

        // Bar
        context.fillStyle = '#339ff4';
        context.fillRect(0, 0, width, height);

        // BG
        context.fillStyle = '#eaeaea';
        let barHeight = (value / maxValue) * (height);
        context.fillRect(0, 0, width, height - barHeight);
    }
</script>
<div id="wrapper">
    <?php include('header.html'); ?>
    <div class="hero">
        <h1>Ressourcen verwalten</h1>
        <a href="meine-dienste.php" class="button">VServer verwalten</a>
    </div>
    <main>
        <section>
            <div class="card">
                <h1 class="centered">Ressourcen</h1>
                <div class="flex-section">
                    <div class="flex-section">
                        <div class="stats">
                            <h3 class="centered">Small</h3>
                            <div class="stat-row">
                                <div>
                                    <canvas id="small-ram" width="100" height="300"></canvas>
                                    <?php
                                    echo "<script>drawBarChart(" . $small_server_used['ram'] . ", " . $small_server['ram'] . ", 'small-ram')</script>";
                                    ?>
                                    <p>RAM</p>
                                </div>
                                <div>
                                    <canvas id="small-cpu" width="100" height="300"></canvas>
                                    <?php
                                    echo "<script>drawBarChart(" . $small_server_used['cpu'] . ", " . $small_server['cpu'] . ", 'small-cpu')</script>";
                                    ?>
                                    <p>CPU</p>
                                </div>
                                <div>
                                    <canvas id="small-ssd" width="100" height="300"></canvas>
                                    <?php
                                    echo "<script>drawBarChart(" . $small_server_used['ssd'] . ", " . $small_server['ssd'] . ", 'small-ssd')</script>";
                                    ?>
                                    <p>SSD</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-section">
                        <div class="stats">
                            <h3 class="centered">Medium</h3>
                            <div class="stat-row">
                                <div>
                                    <canvas id="medium-ram" width="100" height="300"></canvas>
                                    <?php
                                    echo "<script>drawBarChart(" . $medium_server_used['ram'] . ", " . $medium_server['ram'] . ", 'medium-ram')</script>";
                                    ?>
                                    <p>RAM</p>
                                </div>
                                <div>
                                    <canvas id="medium-cpu" width="100" height="300"></canvas>
                                    <?php
                                    echo "<script>drawBarChart(" . $medium_server_used['cpu'] . ", " . $medium_server['cpu'] . ", 'medium-cpu')</script>";
                                    ?>
                                    <p>CPU</p>
                                </div>
                                <div>
                                    <canvas id="medium-ssd" width="100" height="300"></canvas>
                                    <?php
                                    echo "<script>drawBarChart(" . $medium_server_used['ssd'] . ", " . $medium_server['ssd'] . ", 'medium-ssd')</script>";
                                    ?>
                                    <p>SSD</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-section">
                        <div class="stats">
                            <h3 class="centered">Big</h3>
                            <div class="stat-row">
                                <div>
                                    <canvas id="big-ram" width="100" height="300"></canvas>
                                    <?php
                                    echo "<script>drawBarChart(" . $big_server_used['ram'] . ", " . $big_server['ram'] . ", 'big-ram')</script>";
                                    ?>
                                    <p>RAM</p>
                                </div>
                                <div>
                                    <canvas id="big-cpu" width="100" height="300"></canvas>
                                    <?php
                                    echo "<script>drawBarChart(" . $big_server_used['cpu'] . ", " . $big_server['cpu'] . ", 'big-cpu')</script>";
                                    ?>
                                    <p>CPU</p>
                                </div>
                                <div>
                                    <canvas id="big-ssd" width="100" height="300"></canvas>
                                    <?php
                                    echo "<script>drawBarChart(" . $big_server_used['ssd'] . ", " . $big_server['ssd'] . ", 'big-ssd')</script>";
                                    ?>
                                    <p>SSD</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="card">
                <h1 class="centered">Monatlicher Umsatz</h1>
                <?php echo "<p><b>Gesammt: </b>CHF " . $income . ".-</p>"; ?>

                <table class="">
                    <tr>
                        <th><h1>Server ID</h1></th>
                        <th><h1>CPU Kern(e)</h1></th>
                        <th><h1>Arbeitsspeicher</h1></th>
                        <th><h1>Speicherplatz</h1></th>
                        <th><h1>Physischer Server</h1></th>
                        <th><h1>Umsatz</h1></th>
                    </tr>
                    <?php anzeigen(); ?>
                </table>
            </div>
        </section>
    </main>
</div>
</body>
</html>