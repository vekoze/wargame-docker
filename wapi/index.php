<?php

function random_ip() : string
{
    $ip = [];
    for ($i = 0; $i < 4; $i++) {
        $ip[] = rand(0, 255);
    }
    return implode(".", $ip);
}

function random_city() : string
{
    $citys = ["France", "Germany", "United States", "China", "Russia", "Japan"];
    return $citys[array_rand($citys)];
}

$key = $_SERVER['HTTP_WARGAME_API_KEY'] ?? "";

// Check if API key is present
if (empty($key))
{
    header('HTTP/1.0 403 Forbidden');
    exit();
}

$data = array(
    "online-visitor" => rand(1, 100),
    "last-visitors" => [
        [ random_ip(), random_city() ],
        [ random_ip(), random_city() ],
        [ random_ip(), random_city() ],
        [ random_ip(), random_city() ],
        [ random_ip(), random_city() ]
    ]
);

header("Content-Type: application/json");
echo json_encode($data);

?>