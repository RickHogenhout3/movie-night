<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Movie Night</title>
</head>
<body>
<?php include_once "header.php" ?>

<main>
        <div class="movie-container" id="movies"></div>
        <div class="pagination" id="pagination"></div>
    </main>

    <script>
        const apiKey = '0a489ed528533b2350c3cae9ea4419d9';
const discoverUrl = 'https://api.themoviedb.org/3/discover/movie';
const searchUrl = 'https://api.themoviedb.org/3/search/movie';
const moviesContainer = document.getElementById('movies');
const paginationContainer = document.getElementById('pagination');
const searchForm = document.getElementById('search-form');
const searchInput = document.getElementById('search-input');
let currentPage = 1;
let currentQuery = ''; // To store the current search query

// Fetch movies (Discover or Search)
async function fetchMovies(page = 1, query = '') {
    try {
        const url = query
            ? `${searchUrl}?api_key=${apiKey}&query=${encodeURIComponent(query)}&page=${page}`
            : `${discoverUrl}?api_key=${apiKey}&page=${page}`;
        const response = await fetch(url);
        const data = await response.json();
        renderMovies(data.results);
        renderPagination(data.page, data.total_pages);
    } catch (error) {
        console.error('Error fetching movie data:', error);
    }
}

// Render Movies
function renderMovies(movies) {
    moviesContainer.innerHTML = '';
    if (movies.length === 0) {
        moviesContainer.innerHTML = `<p class="text-center">No movies found.</p>`;
        return;
    }
    movies.forEach(movie => {
        const movieCard = document.createElement('div');
        movieCard.classList.add('movie-card');
        movieCard.innerHTML = `
            <img src="https://image.tmdb.org/t/p/w500${movie.poster_path}" 
                 alt="${movie.title}" 
                 class="movie-poster">
            <h3>${movie.title}</h3>
            <p><strong>Release Date:</strong> ${movie.release_date || 'N/A'}</p>
            <p>${movie.overview || 'No description available.'}</p>
        `;
        moviesContainer.appendChild(movieCard);
    });
}

// Render Pagination
function renderPagination(current, total) {
    paginationContainer.innerHTML = ''; // Clear existing pagination
    const prevButton = document.createElement('button');
    prevButton.textContent = 'Previous';
    prevButton.disabled = current === 1;
    prevButton.onclick = () => changePage(current - 1);
    paginationContainer.appendChild(prevButton);

    for (let i = 1; i <= total; i++) {
        if (i > current - 10 && i < current + 10) { // Show nearby pages
            const pageButton = document.createElement('button');
            pageButton.textContent = i;
            pageButton.disabled = i === current;
            pageButton.onclick = () => changePage(i);
            paginationContainer.appendChild(pageButton);
        }
    }

    const nextButton = document.createElement('button');
    nextButton.textContent = 'Next';
    nextButton.disabled = current === total;
    nextButton.onclick = () => changePage(current + 1);
    paginationContainer.appendChild(nextButton);
}

// Change Page
function changePage(page) {
    currentPage = page;
    fetchMovies(page, currentQuery);
}

// Handle Search Form Submission
searchForm.addEventListener('submit', event => {
    event.preventDefault(); // Prevent page reload
    currentQuery = searchInput.value.trim(); // Get search query
    currentPage = 1; // Reset to first page
    fetchMovies(currentPage, currentQuery); // Fetch search results
});

// Fetch initial data
fetchMovies(currentPage);

    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
