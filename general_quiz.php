<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth_functions.php';

// Вопросы для викторины
$generalQuestions = [
    [
        'question' => 'Кто написал "Войну и мир"?',
        'options' => ['Достоевский', 'Толстой', 'Чехов', 'Тургенев'],
        'answer' => 1
    ],
    [
        'question' => 'Сколько цветов в радуге?',
        'options' => ['5', '6', '7', '8'],
        'answer' => 2
    ],
    [
        'question' => 'Какое животное самое крупное на Земле?',
        'options' => ['Слон', 'Синий кит', 'Жираф', 'Белый медведь'],
        'answer' => 1
    ],
    [
        'question' => 'В каком году человек впервые полетел в космос?',
        'options' => ['1957', '1961', '1969', '1975'],
        'answer' => 1
    ],
    [
        'question' => 'Как называется столица Японии?',
        'options' => ['Пекин', 'Сеул', 'Токио', 'Бангкок'],
        'answer' => 2
    ],
    [
        'question' => 'Кто нарисовал "Мону Лизу"?',
        'options' => ['Микеланджело', 'Рафаэль', 'Леонардо да Винчи', 'Ван Гог'],
        'answer' => 2
    ],
    [
        'question' => 'Какой язык самый распространенный в мире?',
        'options' => ['Английский', 'Китайский', 'Испанский', 'Хинди'],
        'answer' => 1
    ],
    [
        'question' => 'Сколько континентов на Земле?',
        'options' => ['5', '6', '7', '8'],
        'answer' => 1
    ],
    [
        'question' => 'Какое самое глубокое озеро в мире?',
        'options' => ['Каспийское море', 'Байкал', 'Танганьика', 'Верхнее'],
        'answer' => 1
    ],
    [
        'question' => 'Кто был первым президентом США?',
        'options' => ['Джон Адамс', 'Томас Джефферсон', 'Джордж Вашингтон', 'Авраам Линкольн'],
        'answer' => 2
    ]
];

// Перемешиваем вопросы
shuffle($generalQuestions);
$totalQuestions = count($generalQuestions);

// Обработка начала новой игры
if (isset($_GET['restart'])) {
    unset($_SESSION['general_quiz']);
}

// Инициализация викторины
if (!isset($_SESSION['general_quiz'])) {
    $_SESSION['general_quiz'] = [
        'questions' => $generalQuestions,
        'current' => 0,
        'score' => 0,
        'answers' => []
    ];
}

// Получаем текущий вопрос
$currentQuestion = $_SESSION['general_quiz']['questions'][$_SESSION['general_quiz']['current']];
$currentQuestionNumber = $_SESSION['general_quiz']['current'] + 1;

// Обработка ответа
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
    $userAnswer = (int)$_POST['answer'];
    $correctAnswer = $currentQuestion['answer'];
    
    $_SESSION['general_quiz']['answers'][] = $userAnswer === $correctAnswer;
    
    if ($userAnswer === $correctAnswer) {
        $_SESSION['general_quiz']['score']++;
    }
    
    // Переход к следующему вопросу или завершение
    if ($_SESSION['general_quiz']['current'] < $totalQuestions - 1) {
        $_SESSION['general_quiz']['current']++;
        // Получаем новый текущий вопрос
        $currentQuestion = $_SESSION['general_quiz']['questions'][$_SESSION['general_quiz']['current']];
        $currentQuestionNumber = $_SESSION['general_quiz']['current'] + 1;
    } else {
        // Сохраняем результат
        if (isLoggedIn()) {
            saveScore('general', $_SESSION['general_quiz']['score']);
        }
        $quizFinished = true;
    }
}

$pageTitle = "Викторина: Общие Знания";
require_once __DIR__ . '/../includes/header.php';
?>

<section class="game-container">
    <h1>Викторина: Общие Знания</h1>
    
    <?php if (!isset($quizFinished)): ?>
        <div class="quiz-progress">
            Вопрос <?= $currentQuestionNumber ?> из <?= $totalQuestions ?>
            <div class="score">Счет: <?= $_SESSION['general_quiz']['score'] ?></div>
        </div>
        
        <div class="quiz-question">
            <h2><?= html($currentQuestion['question']) ?></h2>
            
            <form method="post">
                <div class="quiz-options">
                    <?php foreach ($currentQuestion['options'] as $index => $option): ?>
                        <div class="option">
                            <input 
                                type="radio" 
                                name="answer" 
                                id="option-<?= $index ?>" 
                                value="<?= $index ?>" 
                                required
                            >
                            <label for="option-<?= $index ?>">
                                <?= html($option) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <button type="submit" class="game-button">
                    <?= ($currentQuestionNumber < $totalQuestions) ? 'Следующий вопрос' : 'Завершить викторину' ?>
                </button>
            </form>
        </div>
    <?php else: ?>
        <div class="quiz-results">
            <h2>Викторина завершена!</h2>
            <div class="final-score">
                Ваш результат: <?= $_SESSION['general_quiz']['score'] ?> из <?= $totalQuestions ?>
            </div>
            
            <div class="score-message">
                <?php
                $percentage = ($_SESSION['general_quiz']['score'] / $totalQuestions) * 100;
                if ($percentage >= 80) {
                    echo '<p class="excellent">Отличный результат! Вы настоящий эрудит!</p>';
                } elseif ($percentage >= 50) {
                    echo '<p class="good">Хороший результат! Вы хорошо разбираетесь в разных темах!</p>';
                } else {
                    echo '<p class="average">Попробуйте еще раз, чтобы улучшить результат!</p>';
                }
                ?>
            </div>
            
            <div class="quiz-actions">
                <a href="/gameteka/games/general_quiz.php?restart=1" class="game-button primary">Играть снова</a>
                <a href="/gameteka/" class="game-button secondary">На главную</a>
            </div>
        </div>
        
        <?php unset($_SESSION['general_quiz']); ?>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>