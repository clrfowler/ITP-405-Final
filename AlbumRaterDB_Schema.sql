
-- SQLite database for the Album Rater application

PRAGMA foreign_keys = ON; -- Enable foreign key enforcement

-- Create Users Table
CREATE TABLE users (
    user_id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL
);

-- Create Albums Table
CREATE TABLE albums (
    album_id INTEGER PRIMARY KEY AUTOINCREMENT,
    spotify_album_id TEXT UNIQUE NOT NULL,
    album_name TEXT NOT NULL,
    artist_name TEXT NOT NULL
);

-- Create Comments Table
CREATE TABLE comments (
    comment_id INTEGER PRIMARY KEY AUTOINCREMENT,
    album_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    comment_text TEXT NOT NULL,
    comment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (album_id) REFERENCES albums(album_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Create Ratings Table
CREATE TABLE ratings (
    rating_id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    album_id INTEGER NOT NULL,
    rating INTEGER NOT NULL,
    rating_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (album_id) REFERENCES albums(album_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
