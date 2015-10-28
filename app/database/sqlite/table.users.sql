CREATE TABLE users (
    id VARCHAR(50) PRIMARY KEY,

    email VARCHAR(92) UNIQUE,
    password VARCHAR(64),
    hierarchy VARCHAR(32) DEFAULT 'admin',

    active BOOLEAN DEFAULT TRUE,

    hash_password_expired VARCHAR(124) UNIQUE,
    hash_password_forgot VARCHAR(124) UNIQUE,
    hash_confirm_account VARCHAR(124) UNIQUE,
    hash_unlock_account VARCHAR(124) UNIQUE,

    login_count INTEGER DEFAULT 0,
    login_attempts DECIMAL(2) DEFAULT 0, 
    last_login TIMESTAMP,

    -- dados de cadastro
    name VARCHAR(92),
    documentation VARCHAR(24),
    address VARCHAR(512),
    phone VARCHAR(16),

    created_at DATE,
    update_at DATE
)