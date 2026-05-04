
CREATE DATABASE IF NOT EXISTS library_db;
USE library_db;

CREATE TABLE books (
  book_id INT PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  author VARCHAR(255) NOT NULL,
  year INT NOT NULL,
  genre VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE students (
  student_id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE borrow_records (
  record_id INT PRIMARY KEY AUTO_INCREMENT,
  student_id INT NOT NULL,
  book_id INT NOT NULL,
  borrow_date DATE NOT NULL,
  due_date DATE NOT NULL,
  return_date DATE NULL,
  fine_amount DECIMAL(10,2) DEFAULT 0.00,
  status VARCHAR(20) DEFAULT 'borrowed',
  FOREIGN KEY (student_id) REFERENCES students(student_id),
  FOREIGN KEY (book_id) REFERENCES books(book_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO students (name) VALUES ('John Doe'), ('Jane Smith');
INSERT INTO books (title, author, year, genre) VALUES 
  ('PHP OOP', 'Author1', 2026, 'Technical'),
  ('Library Management', 'Author2', 2025, 'Education');
