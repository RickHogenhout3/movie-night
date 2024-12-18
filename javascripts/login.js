function renderUserAccount() {
    if (isLoggedIn) {
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

// Render user account section
renderUserAccount();