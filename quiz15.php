<?php
// Load the XML file
$xml = simplexml_load_file('quiz15.xml');

// Convert XML object to array
$questions = [];
foreach ($xml->question as $question) {
    $questions[] = $question;
}

// Process the submitted form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score15 = 0;
    $answeredAll = true;

    foreach ($questions as $index => $question) {
        $userAnswer = isset($_POST['answer_' . $index]) ? $_POST['answer_' . $index] : null;
        $correctAnswer = (string)$question->answer;

        if ($userAnswer === $correctAnswer) {
            $score15++;
        } elseif ($userAnswer === null) {
            $answeredAll = false;
        }
    }

    if ($answeredAll) {
        // Store the score in a session variable
        session_start();
        $_SESSION['score15'] = $score15;

        // Redirect to the index.php file
        header('Location: index.php');
        exit;
    } else {
        $errorMessage = "Please answer all questions before submitting.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>QUIZMANIA QUIZ 15</title>
  <link rel="stylesheet" type="text/css" href="css/quiz.css">
  
</head>
<body onload="startTimer()">
    <div class="container">
        <h1>QUIZMANIA QUIZ 15</h1>
        <div id="timer" class="timer"></div>
        <form method="post" action="" onsubmit="return validateForm();">
            <?php if (isset($errorMessage)): ?>
                <p style="color: red;"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
            <?php foreach ($questions as $index => $question): ?>
                <h3 style="color: black;"><?php echo $question->text; ?></h3>
                <?php foreach ($question->options->option as $option): ?>
                    <label style="color: black;">
                        <input type="radio" name="answer_<?php echo $index; ?>" value="<?php echo $option; ?>">
                        <?php echo $option; ?>
                    </label><br>
                <?php endforeach; ?>
                <br>
            <?php endforeach; ?>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>