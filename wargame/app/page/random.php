<?php

require_once MODEL . "destination.php";

if(session_status() !== PHP_SESSION_ACTIVE) session_start();

// Get the index of the last destination page consulted, -1 if there is none.
$last_dst_idx = $_SESSION['last_destination_idx'] ?? -1;
$dst = Destination::get_destinations();
$dst_count = count($dst);

// Generate a random index different from the last one.
do {
    $dst_idx = rand(1, $dst_count);
} while ($dst_idx == $last_dst_idx);

// Redirect to the destination page.
header("Location: /destination/" . $dst_idx);
exit();

?>