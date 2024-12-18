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
            <li id="user-account">
                <!-- User account section will be dynamically updated -->
            </li>
        </ul>
    </nav>
</header>

<script>
    // Check login state from the server (Simulated with PHP logic)
    const isLoggedIn = <?php echo isset($_SESSION['loggedin']) && $_SESSION['loggedin'] ? 'true' : 'false'; ?>;

    // DOM element for the user account section
    const userAccount = document.getElementById('user-account');

    // Function to render the user account dropdown or login button
    function renderUserAccount() {
        if (isLoggedIn) {
            // Show dropdown menu for logged-in users
            userAccount.innerHTML = `
                <div class="dropdown">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" class="user bi bi-person-fill" viewBox="0 0 16 16" fill="white">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                    </svg>
                    <div class="dropdown-content">
                        <a href="#">Watchlist</a>
                        <a href="#">Your Movie Rankings</a>
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            `;
        } else {
            // Show login button for non-logged-in users
            userAccount.innerHTML = `
                <button class="btn btn-primary" id="login-button">Login</button>
            `;
            // Attach event listener for login button
            const loginButton = document.getElementById('login-button');
            loginButton.addEventListener('click', () => {
                window.location.href = 'login.php'; // Redirect to login page
            });
        }
    }

    // Render the user account section based on login state
    renderUserAccount();
</script>
