<?php
    $data = file_get_contents("info.0.json");
    $data = json_decode($data,true);
    echo $data["img"];
?>