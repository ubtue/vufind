CREATE TABLE tuefind_redirect (
    url VARCHAR(1000) NOT NULL,
    group_name VARCHAR(1000) DEFAULT NULL,
    timestamp TIMESTAMP DEFAULT NOW() NOT NULL
) DEFAULT CHARSET=utf8;
