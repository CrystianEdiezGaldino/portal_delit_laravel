<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Check if data is passed correctly
if (isset($relatorios) && !empty($relatorios)) {
    // Display the reports
    foreach ($relatorios as $relatorio) {
        echo "<div>{$relatorio['title']}</div>";
    }
} else {
    // Handle case where data is null or incorrect
    echo "<div>No data available</div>";
}
?>