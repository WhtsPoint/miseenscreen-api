CREATE TABLE IF NOT EXISTS call_forms (
    id varchar(36) NOT NULL PRIMARY KEY,
    comment varchar NOT NULL,
    full_name varchar NOT NULL,
    company_name varchar NOT NULL,
    employee_number int NOT NULL,
    phone varchar NOT NULL,
    email varchar NOT NULL,
    files jsonb NOT NULL
);
