<header>
    <nav class="navbar">
        <div class="logo">Movie Night</div>

        <form class="search-bar" id="search-form">
            <input type="text" placeholder="Search..." name="search" id="search-input">
            <button type="submit" aria-label="Search">
                <i class="bi bi-search"></i>
            </button>
        </form>


        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li class="dropdown">
            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" class="user bi bi-person-fill" viewBox="0 0 16 16" fill="white">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
            </svg>

                <div class="dropdown-content">
                    <a href="#">Watchlist</a>
                    <a href="#">Your Movie Rankings</a>
                    <a href="logout.php">log out</a>
                </div>
            </li>
        </ul>
    </nav>
</header>