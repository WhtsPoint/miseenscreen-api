CREATE TABLE IF NOT EXISTS users (
    id varchar(36) NOT NULL PRIMARY KEY,
    username varchar NOT NULL UNIQUE,
    password varchar NOT NULL
);
