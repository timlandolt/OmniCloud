<?php
$virtual_machines = [];

$small_server = ["cpu" => 4, "ram" => 32, "ssd" => 4000];
$medium_server = ["cpu" => 8, "ram" => 64, "ssd" => 8000];
$big_server = ["cpu" => 16, "ram" => 128, "ssd" => 16000];

function order() {

    global $small_server;
    global $medium_server;
    global $big_server;
    if ($_POST["cpu"] < $small_server["cpu"] && $_POST["ram"] < $small_server["ram"] && $_POST["ssd"] < $small_server["ssd"]) {
        $small_server["cpu"] -= $_POST["cpu"];
        $small_server["ram"] -= $_POST["ram"];
        $small_server["ssd"] -= $_POST["ssd"];
    } elseif ($_POST["cpu"] < $medium_server["cpu"] && $_POST["ram"] < $medium_server["ram"] && $_POST["ssd"] < $medium_server["ssd"]) {
        $medium_server["cpu"] -= $_POST["cpu"];
        $medium_server["ram"] -= $_POST["ram"];
        $medium_server["ssd"] -= $_POST["ssd"];
    } elseif ($_POST["cpu"] < $big_server["cpu"] && $_POST["ram"] < $big_server["ram"] && $_POST["ssd"] < $big_server["ssd"]) {
        $big_server["cpu"] -= $_POST["cpu"];
        $big_server["ram"] -= $_POST["ram"];
        $big_server["ssd"] -= $_POST["ssd"];
    } else {
        //popup: "Zu grosse Angaben!"
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
    <title>OmniCloud-Serverbestellen</title>
</head>
<body>

</body>
</html>
