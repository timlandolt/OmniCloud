<?php

if (isset($_POST["delete"])) {
    delete($_POST["delete"]);
}

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
            echo "<td class='centered'><form method='post' ><button type='submit' name='delete' value='". $id ."' class='button'>Kündigen</button></form></td>";
            echo "</tr>";
        }
    }
}

function delete($id)
{
    $myfile = file("kunden.csv");
    $newfile = [];

    foreach ($myfile as $line) {
        $dataElements = explode(",", $line);
        if ($dataElements[0] != $id && trim($dataElements[0]) != '') {
            $newfile[] = $line;
        }
    }
    file_put_contents("kunden.csv", $newfile);
    echo '
            <div class="banner confirm">
                <h4>Ihr Server wurde gelöscht!</h4>
                <p>Ihr Server (#' . $id . ') wurde erfolgreich gelöscht!</p>
            </div>
        ';
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
    <div class="hero">
        <h1>Ihre Server verwalten</h1>
        <a href="order.php" class="button">Weiteren Server bestellen</a>
    </div>
    <main>
        <section>
            <table class="card">
                <tr>
                    <th><h1>Server ID</h1></th>
                    <th><h1>CPU Kern(e)</h1></th>
                    <th><h1>Arbeitsspeicher</h1></th>
                    <th><h1>Speicherplatz</h1></th>
                </tr>
                <?php anzeigen(); ?>
            </table>
        </section>
    </main>
</div>
</body>
</html>