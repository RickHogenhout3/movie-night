<?php
session_start();
$host = "localhost";
$username = "bit_academy";
$password = "";
$dbname = "movies";
$charset = "utf8mb4";

// API Key and URL
$apiKey = '0a489ed528533b2350c3cae9ea4419d9';
$apiUrl = 'https://api.themoviedb.org/3/discover/movie';

// Function to connect to the database
function connectDatabase($host, $dbname, $username, $password) {
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Function to fetch movies from the API
function fetchMoviesFromAPI($page = 1, $apiKey, $apiUrl) {
    $url = "$apiUrl?api_key=$apiKey&page=$page";
    $response = file_get_contents($url);

    if ($response === FALSE) {
        die("Error fetching data from API.");
    }

    return json_decode($response, true)['results'];
}

// Function to store movies in the database
function storeMoviesInDatabase($movies, $conn) {
    $stmt = $conn->prepare("
        INSERT INTO movies (id, title, release_date, poster_url, overview) 
        VALUES (?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE 
            title = VALUES(title), 
            release_date = VALUES(release_date), 
            poster_url = VALUES(poster_url), 
            overview = VALUES(overview)
    ");

    foreach ($movies as $movie) {
        $id = $movie['id'];
        $title = $movie['title'];
        $releaseDate = $movie['release_date'];
        $posterUrl = $movie['poster_path'];
        $overview = $movie['overview'];

        $stmt->bind_param("issss", $id, $title, $releaseDate, $posterUrl, $overview);

        if (!$stmt->execute()) {
            echo "Error storing movie: " . $stmt->error . "<br>";
        }
    }

    $stmt->close();
}

function syncMovies($host, $dbname, $username, $password, $apiKey, $apiUrl, $pages = 1) {
    $conn = connectDatabase($host, $dbname, $username, $password);

    for ($page = 1; $page <= $pages; $page++) {
        $movies = fetchMoviesFromAPI($page, $apiKey, $apiUrl);
        storeMoviesInDatabase($movies, $conn);
    }

    $conn->close();
}

syncMovies($host, $dbname, $username, $password, $apiKey, $apiUrl);