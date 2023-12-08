CREATE TABLE IF NOT EXISTS subscriptions (
    id varchar(36) NOT NULL PRIMARY KEY,
    email varchar NOT NULL UNIQUE
);
