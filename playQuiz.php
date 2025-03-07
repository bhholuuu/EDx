<?php
session_start();
include './assets/php/_connectionDb.php'; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['userId'])) {
    header("Location: signupLogin.php");
    exit;
}

$userId = $_SESSION['userId'];
$courseId = isset($_GET['courseId']) ? $_GET['courseId'] : null;

if (!$courseId) {
    echo "Invalid Course ID.";
    exit;
}

$score = null; // Default score
$questions = [];

// If the form is submitted, evaluate the quiz
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
    $userAnswers = $_POST['answer'];
    $score = 0;
    $totalQuestions = count($userAnswers);

    // Fetch correct answers for the given questions
    $queryCorrect = "SELECT queId, ans FROM que WHERE queId IN (" . implode(',', array_keys($userAnswers)) . ")";
    $stmtCorrect = $conn->prepare($queryCorrect);
    $stmtCorrect->execute();
    $correctAnswers = $stmtCorrect->fetchAll(PDO::FETCH_ASSOC);

    // Compare user answers with correct answers
    foreach ($correctAnswers as $row) {
        $queId = $row['queId'];
        $correctAns = $row['ans']; // This contains 'option1', 'option2', etc.

        if (isset($userAnswers[$queId]) && $userAnswers[$queId] === $correctAns) {
            $score++;
        }
    }
}

// Fetch 10 random questions for the quiz (only if quiz not submitted)
if ($score === null) {
    $queryQuiz = "SELECT queId, que, ans1, ans2, ans3, ans4 FROM que WHERE courseId = :courseId ORDER BY RAND() LIMIT 10";
    $stmtQuiz = $conn->prepare($queryQuiz);
    $stmtQuiz->bindParam(':courseId', $courseId, PDO::PARAM_INT);
    $stmtQuiz->execute();
    $questions = $stmtQuiz->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play Quiz</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 20px;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    th,
    td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background: #007bff;
        color: white;
        text-align: center;
    }

    .option-label {
        display: block;
        margin: 5px 0;
        cursor: pointer;
    }

    .submit-btn {
        background: #28a745;
        color: white;
        padding: 12px 18px;
        text-decoration: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        display: block;
        width: 200px;
        text-align: center;
        margin: 20px auto;
        cursor: pointer;
        border: none;
    }

    .submit-btn:hover {
        background: #218838;
    }

    .scoreboard {
        text-align: center;
        margin-top: 20px;
        font-size: 20px;
        font-weight: bold;
        padding: 15px;
        background: #ffc107;
        border-radius: 10px;
    }
    </style>
</head>

<body>

    <h2>Play Quiz</h2>

    <?php if ($score !== null): ?>
    <!-- Scoreboard -->
    <div class="scoreboard">
        🎯 You scored <strong><?php echo $score; ?></strong> out of <strong><?php echo $totalQuestions; ?></strong>!
    </div>
    <?php endif; ?>

    <?php if ($score === null): ?>
    <form action="playQuiz.php?courseId=<?php echo $courseId; ?>" method="POST">
        <table>
            <tr>
                <th>Question</th>
                <th>Options</th>
            </tr>

            <?php if (!empty($questions)): ?>
            <?php foreach ($questions as $index => $question): ?>
            <tr>
                <td><?php echo ($index + 1) . ". " . htmlspecialchars($question['que']); ?></td>
                <td>
                    <label class="option-label">
                        <input type="radio" name="answer[<?php echo $question['queId']; ?>]" value="option1" required>
                        <?php echo htmlspecialchars($question['ans1']); ?>
                    </label>
                    <label class="option-label">
                        <input type="radio" name="answer[<?php echo $question['queId']; ?>]" value="option2">
                        <?php echo htmlspecialchars($question['ans2']); ?>
                    </label>
                    <label class="option-label">
                        <input type="radio" name="answer[<?php echo $question['queId']; ?>]" value="option3">
                        <?php echo htmlspecialchars($question['ans3']); ?>
                    </label>
                    <label class="option-label">
                        <input type="radio" name="answer[<?php echo $question['queId']; ?>]" value="option4">
                        <?php echo htmlspecialchars($question['ans4']); ?>
                    </label>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="2" style="text-align: center;">No quiz questions available for this course.</td>
            </tr>
            <?php endif; ?>
        </table>

        <?php if (!empty($questions)): ?>
        <button type="submit" class="submit-btn">Submit Quiz</button>
        <?php endif; ?>
    </form>
    <?php endif; ?>

</body>

</html>

<?php
$conn = null;
?>