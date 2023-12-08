CREATE TABLE IF NOT EXISTS subscription (
    id varchar(36) NOT NULL PRIMARY KEY,
    email varchar NOT NULL UNIQUE
);
