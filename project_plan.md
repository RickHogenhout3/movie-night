# Movie Night: The future of movie ranking

## 🎯 purpose
Mission: Transform how people interact with movies by building a web application where users can
rank, share, and explore film ratings. The concept is simple: everyone has their own
opinions about movies, and it's time to give people a space to express them. 

## 📝 User Stories and Tasks:
**Core Features:**

1. User Accounts:
    - Create accounts: Register with an email and secure password.
    - Login/logout: Implement authentication to ensure secure access.
    - Edit account settings: Update usernames, avatars, and bios on their personal account page. 

2. Movie Rankings:

    - Allow users to search for any movie from the database. 
    - Enable users to submit a score (from 0.0 to 10.0) and optionally add a review. 
    - Display a personalized list of movies with their ratings on each user's profile.

3. Explore Movies and Rankings:

    - Browse all ranked movies, aggregated across users.
    - Click on a movie to view detailed statistics and user reviews.

**Advanced Features:**

1.  Interactive User Profiles:

- A username and avatar  
- A list of their ranked movies, sorted by their rating.

2. Genre Filter:

    - Filter movies by genre, release date, or average user rating.


## 💻 Technologies:
**Development:**
 - Frontend: Use HTML, CSS (Bootstrap or Tailwind for styling), and JavaScript (preferably React or Vanilla JS).
  Create reusable components for the navbar, movie cards, and user profiles. Ensure responsive design for mobile and desktop users.

 - Backend: Use Node.js with Express.js. Making a Database to store user data, movies and rankings in MySQL.

 - API:  Movie Database Integration: Integrate with an external API (e.g., TMDB) for fetching movie details. 