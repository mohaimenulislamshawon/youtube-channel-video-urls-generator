<!DOCTYPE html>
<html>
<head>
    <title>YouTube Video ID Extractor</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<h1>YouTube Video ID Extractor</h1>

<form method="post" action="">
    Channel Name: <input type="text" name="channelName" required>
    <input type="submit" value="Fetch Video IDs">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $channelName = htmlspecialchars($_POST["channelName"]);

    // Construct the URL using the channel name
    $url = "https://www.youtube.com/@$channelName/videos";

    // Initialize a cURL session
    $ch = curl_init();

    // Set the URL and options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Execute the cURL session and get the response
    $response = curl_exec($ch);

    // Close the cURL session
    curl_close($ch);

    // Define the regex pattern to search for "videoRenderer":{"videoId":"SEARCH_TERM"
    $pattern = '/"videoRenderer":\{"videoId":"(.*?)"/';

    // Find all matches in the response text
    preg_match_all($pattern, $response, $matches);

    // Prepare the list of URLs
    $urls = "";
    $totalUrls = count($matches[1]);
    foreach ($matches[1] as $term) {
        $urls .= "https://www.youtube.com/watch?v=$term\n";
    }

    // Print the URLs in a text area
    echo "<h2>Video URLs for channel '$channelName':</h2>";
    echo "<textarea id='urlBox' readonly>$urls</textarea>";
    echo "<button id='copyButton' onclick='copyToClipboard()'>Copy to Clipboard</button>";
    echo "<div id='urlCount'>Total URLs: $totalUrls</div>";
}
?>

<script src="script.js"></script>

<footer class="footer">
    <p class="footer-text">
        © Created by <a href="https://about.me/mohaimenulislamshawon/" target="_blank" class="footer-link">Shawon</a>
    </p>
</footer>

</body>
</html>
