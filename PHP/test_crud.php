<?php
require_once __DIR__ . '/db_connect.php';

// Load all *_functions.php files in this directory
foreach (glob(__DIR__ . '/*_functions.php') as $file) {
    require_once $file;
}

// Utility prompt function
function prompt(string $text): string {
    echo $text;
    return trim(fgets(STDIN));
}

// Gather all available user-defined functions after loading modules
$functions = array_filter(get_defined_functions()['user'], function ($fn) {
    return $fn !== 'prompt';
});
$functions = array_values($functions); // reindex

echo "Interactive function tester\n";
echo "Type 'list' to see functions or 'exit' to quit.\n";

while (true) {
    $input = prompt("\nEnter function name or number: ");
    if ($input === 'exit') {
        break;
    }
    if ($input === 'list') {
        foreach ($functions as $idx => $name) {
            echo "[$idx] $name\n";
        }
        continue;
    }
    if (is_numeric($input) && isset($functions[(int) $input])) {
        $fn = $functions[(int) $input];
    } else {
        $fn = $input;
    }
    if (!function_exists($fn)) {
        echo "Function '$fn' not found. Use 'list' to view available functions.\n";
        continue;
    }

    $ref = new ReflectionFunction($fn);
    $args = [];
    foreach ($ref->getParameters() as $param) {
        if ($param->getName() === 'pdo') {
            $args[] = $pdo;
            continue;
        }
        $val = prompt("Enter value for \${" . $param->getName() . "}: ");
        if (is_numeric($val)) {
            $val = $val + 0; // cast numeric strings to int/float
        }
        $args[] = $val;
    }

    try {
        $result = $ref->invokeArgs($args);
        echo "Result:\n";
        var_dump($result);
    } catch (Throwable $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

echo "Exiting tester.\n";
?>
