
<?php
    /* //require 'vendor/autoload.php';
    use Spatie\Browsershot\Browsershot;
    $urlToCapture = "https://www.w3schools.com/";
    $pathToImage = "screenshot.jpeg";
    Browsershot::url($urlToCapture)->setNodeBinary('/usr/bin/node') ->setNpmBinary('/usr/bin/npm')->save($pathToImage); */

    // Open the file in read mode.
    $file = fopen("file_site/data.txt", "r");

    // Create an empty array to store the data.
    $data = [];

    // Read each line from the file and add it to the array.
    while (!feof($file)) {
        $line = fgets($file);
        $data[] = $line;
    }

    // Close the file.
    fclose($file);

    // Create a table to display the data.
    echo "<table>";
    foreach ($data as $line) {
        echo "<tr>";
        echo "<td>" . $line . "</td>";
        echo "</tr>";
    }
    echo "</table>";

?>
