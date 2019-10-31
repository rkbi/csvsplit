<?php
define('LIMIT_PER_FILE', 50000);

# Get the full list of mobile numbers
$fo = file_get_contents('full.csv');
$fo = preg_replace('~\R~u', PHP_EOL, $fo); // replace different type of line breaks
$full = array_filter(explode(PHP_EOL, $fo)); // convert string to array, ommit empty strings
$fullcount = count($full);

# Get the list of already done mobile numbers
$fo = file_get_contents('done.csv');
$fo = preg_replace('~\R~u', PHP_EOL, $fo);
$done = array_filter(explode(PHP_EOL, $fo));
$donecount = count($done);

# Get the remaining list of mobiel numbers
$remaining = array_diff($full, $done);
$remainingcount = count($remaining);

# Split the remaining list into smaller chunks
$chunks = array_chunk($remaining, LIMIT_PER_FILE);

# Generate smaller CSV files
$i = 1; // Initialize the counter
foreach ($chunks as $chunk) {
	$output = implode(PHP_EOL, $chunk); // Convert the whole array to a single string
	file_put_contents('remaining' . $i . '.csv', $output); // Writting to the file
	$i++; // Increment the counter
}

# Print some statistics
echo '<span align= "center">';
echo '<h1 style="color: green">Total Data: ' . number_format($fullcount) . '<h1>';
echo '<h1 style="color: red">Done Data: ' . number_format($donecount) . '<h1>';
echo '<h1 style="color: blue">Remaining Data: ' . number_format($remainingcount) . '<h1>';
echo '</span>';