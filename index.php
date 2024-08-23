<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div id="container">
    <div id="title">
        <h1>Advanced replies</h1>
        <p>This page shows functionality for advanced replies on comments for posts, allowing for nested replies and further indenting. The below codeblock shows the functionality I refer to, which essentially just increments an int variable as the SQL query loops, and should there be multiple replies they will increment each time.</p>
        <pre id="codeblock"><code>while ($replyRow = $replyResult->fetch_assoc()) {
    $current_count++;
    echo "&lt;div class='reply' style='margin-left: " . $current_count . "rem;'&gt;&lt;p&gt;" . $replyRow["reply_content"] . "&lt;/p&gt;&lt;p&gt;By: &lt;strong&gt;" . $replyRow["user_name"] . "&lt;/strong&gt;&lt;/p&gt;&lt;/div&gt;";
}
</code></pre>
    </div>

    <?php
    include 'view_data.php';
    ?>
</div>

</body>
</html>
