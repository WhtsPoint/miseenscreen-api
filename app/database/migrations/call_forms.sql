CREATE TABLE call_forms (
    id varchar(36) NOT NULL PRIMARY KEY,
    comment varchar(1000) NOT NULL,
    fullName varchar(100) NOT NULL,
    companyName varchar(100) NOT NULL,
    files jsonb NOT NULL
);
