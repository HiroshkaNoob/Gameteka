USE gameteka;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    game_type ENUM('clicker', 'guess_number', 'geography', 'science', 'general') NOT NULL,
    score INT NOT NULL,
    played_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Вставка вопросов для викторин
CREATE TABLE quiz_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_type ENUM('geography', 'science', 'general') NOT NULL,
    question TEXT NOT NULL,
    option1 VARCHAR(255) NOT NULL,
    option2 VARCHAR(255) NOT NULL,
    option3 VARCHAR(255) NOT NULL,
    option4 VARCHAR(255) NOT NULL,
    correct_answer TINYINT NOT NULL
);

-- Примеры вопросов для викторины по географии
INSERT INTO quiz_questions (quiz_type, question, option1, option2, option3, option4, correct_answer) VALUES
('geography', 'Самая длинная река в мире?', 'Нил', 'Амазонка', 'Янцзы', 'Миссисипи', 2),
('geography', 'Столица Канады?', 'Торонто', 'Оттава', 'Ванкувер', 'Монреаль', 2);

-- Примеры вопросов для научной викторины
INSERT INTO quiz_questions (quiz_type, question, option1, option2, option3, option4, correct_answer) VALUES
('science', 'Что притягивает предметы к поверхности Земли?', 'Магнетизм', 'Центробежная сила', 'Гравитация', 'Электричество', 3),
('science', 'Какой газ растения поглощают из атмосферы?', 'Кислород', 'Азот', 'Углекислый газ', 'Водород', 3);

-- Примеры вопросов для общей викторины
INSERT INTO quiz_questions (quiz_type, question, option1, option2, option3, option4, correct_answer) VALUES
('general', 'Столица Франции?', 'Лондон', 'Берлин', 'Париж', 'Мадрид', 3),
('general', 'Кто написал "Войну и мир"?', 'Достоевский', 'Толстой', 'Чехов', 'Тургенев', 2);