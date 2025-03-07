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

// Fetch course details
$queryCourse = "SELECT courseName FROM course WHERE courseId = :courseId";
$stmtCourse = $conn->prepare($queryCourse);
$stmtCourse->bindParam(':courseId', $courseId, PDO::PARAM_INT);
$stmtCourse->execute();
$course = $stmtCourse->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    echo "Course not found.";
    exit;
}

// Fetch all videos and user notes
$queryVideos = "SELECT v.videoId, v.videoLink, v.videoName, n.note 
               FROM video v 
               LEFT JOIN notes n ON v.videoId = n.videoId AND n.userId = :userId 
               WHERE v.courseId = :courseId";

$stmtVideos = $conn->prepare($queryVideos);
$stmtVideos->bindParam(':courseId', $courseId, PDO::PARAM_INT);
$stmtVideos->bindParam(':userId', $userId, PDO::PARAM_INT);
$stmtVideos->execute();
$videos = $stmtVideos->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['courseName']); ?> - Course Videos</title>
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
        text-align: center;
    }

    th {
        background: #007bff;
        color: white;
    }

    iframe {
        width: 300px;
        height: 180px;
    }

    .edit-btn,
    .save-btn {
        background: #28a745;
        color: white;
        padding: 8px 12px;
        border-radius: 5px;
        cursor: pointer;
        border: none;
    }

    .edit-btn:hover,
    .save-btn:hover {
        background: #218838;
    }

    textarea {
        width: 100%;
        height: 60px;
        font-size: 14px;
        padding: 5px;
    }

    .quiz-btn {
        background: #ff9800;
        color: white;
        padding: 12px 18px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
    }

    .quiz-btn:hover {
        background: #e68900;
    }
    </style>
</head>

<body>
    <h2><?php echo htmlspecialchars($course['courseName']); ?> - Course Videos</h2>

    <table>
        <tr>
            <th>Video</th>
            <th>Note</th>
            <th>Action</th>
        </tr>
        <?php if (!empty($videos)):
            foreach ($videos as $video):
                // Extract YouTube Video ID and generate embed link
                $videoUrl = $video['videoLink'];
                $videoId = '';
                if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([\w-]+)/', $videoUrl, $matches)) {
                    $videoId = $matches[1];
                }
                $embedUrl = "https://www.youtube.com/embed/" . htmlspecialchars($videoId);
                ?>
        <tr>
            <td>
                <iframe src="<?php echo $embedUrl; ?>" frameborder="0" allowfullscreen></iframe>
                <br><?php echo htmlspecialchars($video['videoName']); ?>
            </td>
            <td>
                <div id="noteDisplay_<?php echo $video['videoId']; ?>">
                    <?php echo htmlspecialchars($video['note'] ?? 'No notes available'); ?>
                </div>
                <textarea id="noteTextarea_<?php echo $video['videoId']; ?>" style="display:none;">
                            <?php echo htmlspecialchars($video['note'] ?? ''); ?>
                        </textarea>
            </td>
            <td>
                <button class="edit-btn" onclick="editNote(<?php echo $video['videoId']; ?>)">Edit</button>
                <button class="save-btn" onclick="saveNote(<?php echo $video['videoId']; ?>)"
                    style="display:none;">Save</button>
            </td>
        </tr>
        <?php endforeach;
        else: ?>
        <tr>
            <td colspan="3">No videos available for this course.</td>
        </tr>
        <?php endif; ?>
    </table>

    <div style="text-align: center; margin-top: 20px;">
        <a href="playQuiz.php?courseId=<?php echo $courseId; ?>" class="quiz-btn">Play Quiz</a>
    </div>

    <script>
    function editNote(videoId) {
        document.getElementById("noteDisplay_" + videoId).style.display = "none";
        document.getElementById("noteTextarea_" + videoId).style.display = "block";
        document.querySelector("[onclick='editNote(" + videoId + ")']").style.display = "none";
        document.querySelector("[onclick='saveNote(" + videoId + ")']").style.display = "inline-block";
    }

    function saveNote(videoId) {
        let note = document.getElementById("noteTextarea_" + videoId).value;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "updateNote.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText === "success") {
                    document.getElementById("noteDisplay_" + videoId).innerHTML = note;
                    document.getElementById("noteDisplay_" + videoId).style.display = "block";
                    document.getElementById("noteTextarea_" + videoId).style.display = "none";
                } else {
                    alert("Error saving note.");
                }
            }
        };
        xhr.send("videoId=" + videoId + "&note=" + encodeURIComponent(note));
    }
    </script>
</body>

</html>
<?php $conn = null; ?>