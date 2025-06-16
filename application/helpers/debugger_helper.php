<?php
if (!function_exists('console_log')) {
    function console_log($data)
    {
        echo "<script>console.log(" . json_encode($data) . ");</script>";
    }
}
