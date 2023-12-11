<?php
$virtual_machines = [];

$small_server = ["cpu" => 4, "ram" => 32, "ssd" => 4000];
$medium_server = ["cpu" => 8, "ram" => 64, "ssd" => 8000];
$big_server = ["cpu" => 16, "ram" => 128, "ssd" => 16000];

$kunde = "";

function testOrder($cores, $ram, $storage) {

    global $kunde;
    global $small_server;
    global $medium_server;
    global $big_server;
    if ($cores < $small_server["cpu"] && $ram < $small_server["ram"] && $storage < $small_server["ssd"]) {
        pushOrder($kunde, "small", $cores, $ram, $storage);
    } elseif ($cores < $medium_server["cpu"] && $ram < $medium_server["ram"] && $storage < $medium_server["ssd"]) {
        pushOrder($kunde, "medium", $cores, $ram, $storage);
    } elseif ($cores < $big_server["cpu"] && $ram < $big_server["ram"] && $storage < $big_server["ssd"]) {
        pushOrder($kunde, "big", $cores, $ram, $storage);
    } else {
        //popup: "Zu grosse Angaben!"
    }

}

function pushOrder($kunde, $server, $cores, $ram, $storage){

    $myfile = fopen("kunden.txt", "a") or die("Unable to open file!");
    $input = $kunde." ".$server." ".$cores." ".$ram." ".$storage;
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
    <title>OmniCloud-Serverbestellen</title>
</head>
<body>

</body>
</html>
