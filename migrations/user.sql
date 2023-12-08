CREATE TABLE IF NOT EXISTS users (
    id varchar(36) NOT NULL PRIMARY KEY,
    username varchar UNIQUE NOT NULL,
    password varchar NOT NULL
);
