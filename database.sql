-- YESEFERSEW Database Schema

CREATE DATABASE IF NOT EXISTS yesefersew_db;
USE yesefersew_db;

-- Admins Table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Critical Essays Table
CREATE TABLE IF NOT EXISTS essays (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    excerpt TEXT,
    content LONGTEXT NOT NULL,
    author VARCHAR(100),
    image VARCHAR(255),
    status ENUM('draft', 'published') DEFAULT 'draft',
    is_new BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Artist Interviews Table
CREATE TABLE IF NOT EXISTS interviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    artist_name VARCHAR(100) NOT NULL,
    excerpt TEXT,
    content LONGTEXT NOT NULL,
    image VARCHAR(255),
    status ENUM('draft', 'published') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Curatorial Notes Table
CREATE TABLE IF NOT EXISTS curatorial_notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    curator_name VARCHAR(100),
    excerpt TEXT,
    content LONGTEXT NOT NULL,
    image VARCHAR(255),
    status ENUM('draft', 'published') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- News Table (Global Art News)
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100), -- e.g. '1-54', 'Residency'
    content TEXT,
    link VARCHAR(255),
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Exhibitions Table
CREATE TABLE IF NOT EXISTS exhibitions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    venue VARCHAR(255),
    location VARCHAR(255),
    dates VARCHAR(255),
    description TEXT,
    link VARCHAR(255),
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Opportunities Table
CREATE TABLE IF NOT EXISTS opportunities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    deadline VARCHAR(255),
    link VARCHAR(255),
    status ENUM('active', 'closed') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Subscribers Table
CREATE TABLE IF NOT EXISTS subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE,
    name VARCHAR(100),
    interest VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Calls for Papers Table
CREATE TABLE IF NOT EXISTS calls_for_papers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    deadline_text VARCHAR(100),
    publication_date_text VARCHAR(100),
    topics TEXT, -- Stored as JSON or newline separated text
    guidelines TEXT, -- JSON or text
    status ENUM('active', 'closed') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Paper Submissions Table
CREATE TABLE IF NOT EXISTS paper_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    call_id INT,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    affiliation VARCHAR(255),
    paper_title VARCHAR(255),
    abstract TEXT,
    keywords VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (call_id) REFERENCES calls_for_papers(id) ON DELETE CASCADE
);

-- Members Table
CREATE TABLE IF NOT EXISTS members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('artist', 'curator', 'institution', 'diaspora', 'biennial', 'mentorship') NOT NULL,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    discipline VARCHAR(100), -- For artists
    affiliation VARCHAR(255), -- For curators/institutions
    org_name VARCHAR(255), -- For institutions
    position VARCHAR(100), -- For institutions
    country VARCHAR(100), -- For diaspora
    role VARCHAR(100), -- For diaspora
    reg_type VARCHAR(100), -- For biennial
    mentor_dir VARCHAR(50), -- For mentorship
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert a default admin (password: admin123)
-- Password hashed with BCRYPT
INSERT INTO admins (username, password, email) VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@yesefersew.org');

-- Sample Data
INSERT INTO essays (title, slug, excerpt, content, author, status, is_new) VALUES
('Modernism in Ethiopia: A Historical Perspective', 'modernism-in-ethiopia', 'Exploring the roots of modern art in Ethiopia and its evolution.', 'Full content of the essay about Ethiopian modernism...', 'Dr. Bekele Mekonnen', 'published', TRUE);

INSERT INTO interviews (title, slug, artist_name, excerpt, content, status) VALUES
('A Conversation with Julie Mehretu', 'julie-mehretu-interview', 'Julie Mehretu', 'Discussing abstraction and the power of line.', 'Full interview content with Julie Mehretu...', 'published');

INSERT INTO calls_for_papers (title, slug, description, deadline_text, publication_date_text, topics, guidelines, status) VALUES
('Systemic & Institutional Challenges in the Visual Art Sector', 'systemic-challenges-2024', 'YESEFERSEW Journal invites scholars, practitioners, curators, artists, and cultural policy experts to submit original research articles.', 'To be announced', 'To be announced', 'Institutional critique of arts funding models\nBarriers to market access\nInfrastructure gaps in art education', 'Abstract: 300-500 words\nFull Paper: 5,000-8,000 words\nLanguages: English or Amharic', 'active');

INSERT INTO exhibitions (title, venue, location, dates, description, link) VALUES
('1-54 Contemporary African Art Fair', 'Somerset House', 'London, UK', 'October 2024', 'The leading international art fair dedicated to contemporary art from Africa and its diaspora.', 'https://www.1-54.com/');

INSERT INTO opportunities (title, description, deadline, link, status) VALUES
('Addis Adwa Residency 2025', 'A 3-month residency program for emerging Ethiopian artists.', 'December 31, 2024', 'https://yesefersew.org/apply', 'active');
