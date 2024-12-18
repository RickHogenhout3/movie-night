<?php
$host = "localhost";
$username = "bit_academy";
$password = "";
$dbname = "movies";
$charset = "utf8mb4";

// API Key and URL
$apiKey = '0a489ed528533b2350c3cae9ea4419d9';
$apiUrl = 'https://api.themoviedb.org/3/discover/movie';

try {
    // PDO Connection
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $conn = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Function to fetch movies from the API
function fetchMoviesFromAPI($page = 1, $apiKey, $apiUrl) {
    $url = "$apiUrl?api_key=$apiKey&page=$page";
    $response = file_get_contents($url);

    if ($response === false) {
        die("Error fetching data from API.");
    }

    return json_decode($response, true)['results'];
}

// Function to store movies in the database
function storeMoviesInDatabase($movies, $conn) {
    $stmt = $conn->prepare("
        INSERT INTO movies (id, title, release_date, poster_url, overview) 
        VALUES (:id, :title, :release_date, :poster_url, :overview)
        ON DUPLICATE KEY UPDATE 
            title = VALUES(title), 
            release_date = VALUES(release_date), 
            poster_url = VALUES(poster_url), 
            overview = VALUES(overview)
    ");

    foreach ($movies as $movie) {
        $stmt->execute([
            ':id' => $movie['id'],
            ':title' => $movie['title'],
            ':release_date' => $movie['release_date'],
            ':poster_url' => $movie['poster_path'],
            ':overview' => $movie['overview'],
        ]);
    }
}

// Sync movies from API to database
function syncMovies($conn, $apiKey, $apiUrl, $pages = 1) {
    for ($page = 1; $page <= $pages; $page++) {
        $movies = fetchMoviesFromAPI($page, $apiKey, $apiUrl);
        storeMoviesInDatabase($movies, $conn);
    }
}
