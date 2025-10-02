<?php
// converter.php

if ($argc != 2) {
    echo "Usage: php converter.php <file.json>\n";
    exit(1);
}

$filePath = $argv[1];

// Check if file exists
if (!file_exists($filePath)) {
    echo "Error: File '$filePath' not found.\n";
    exit(1);
}

// Read JSON
$jsonData = file_get_contents($filePath);
$data = json_decode($jsonData, true);

if ($data === null) {
    echo "Error: Invalid JSON in file '$filePath'.\n";
    exit(1);
}

// Convert to YAML
function arrayToYaml($array, $indent = 0) {
    $yaml = '';
    foreach ($array as $key => $value) {
        $yaml .= str_repeat('  ', $indent) . $key . ':';
        if (is_array($value)) {
            $yaml .= "\n" . arrayToYaml($value, $indent + 1);
        } else {
            $yaml .= ' ' . $value . "\n";
        }
    }
    return $yaml;
}

$yamlOutput = arrayToYaml($data);
echo $yamlOutput;
?>
