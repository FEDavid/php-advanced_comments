<?php
include 'db_connect.php';

// Fetch Users
$userSql = "SELECT * FROM Users";
$userResult = $conn->query($userSql);

echo "<div id='users'><h1>Users</h1>";
if ($userResult->num_rows > 0) {
    while ($userRow = $userResult->fetch_assoc()) {
        echo "User ID: " . $userRow["user_id"] . " - Name: " . $userRow["user_name"] . "<br>";
    }
}
echo "</div>";

// Fetch Posts
$postSql = "SELECT Posts.*, Users.user_name FROM Posts JOIN Users ON Posts.user_id = Users.user_id";
$postResult = $conn->query($postSql);

echo "<div id='posts'><h1>Posts</h1>";
if ($postResult->num_rows > 0) {
    while ($postRow = $postResult->fetch_assoc()) {
        // Fetch Comments for specific post
        $commentSql = "SELECT Comments.*, Users.user_name, Posts.post_content 
                       FROM Comments 
                       JOIN Users ON Comments.user_id = Users.user_id 
                       JOIN Posts ON Comments.post_id = Posts.post_id
                       WHERE Comments.post_id = " . $postRow["post_id"];
        $commentResult = $conn->query($commentSql);
        $commentCount = $commentResult->num_rows;

        echo "<div class='post'><h2>Post ID: " . $postRow["post_id"] . "</h2>Content: " . $postRow["post_content"] . " - Posted by: " . $postRow["user_name"] . "";
        echo "<div class='comment-count'>Comments: " . $commentCount . "</div>";

        echo "<h3>Comments</h3><hr /><div id='comments'>";
        if ($commentResult->num_rows > 0) {
            while ($commentRow = $commentResult->fetch_assoc()) {
                // Check if this comment has any replies
                $replySql = "SELECT COUNT(*) as reply_count FROM Comment_reply WHERE comment_id = " . $commentRow["comment_id"];
                $replyResult = $conn->query($replySql);
                $replyRow = $replyResult->fetch_assoc();

                // Add 'no-replies' class if there are no replies
                $commentClass = 'comment';
                if ($replyRow['reply_count'] == 0) {
                    $commentClass .= ' no-replies';
                }

                echo "<div class='" . $commentClass . "'><p>Comment ID: " . $commentRow["comment_id"] . " - Content: " . $commentRow["comment_content"] . " - By: " . $commentRow["user_name"] . " - On Post: " . $commentRow["post_content"] . "</p></div>";

                // Fetch and display replies for the comment
                $replySql = "SELECT Comment_reply.*, Users.user_name, Comments.comment_content 
                             FROM Comment_reply 
                             JOIN Users ON Comment_reply.user_id = Users.user_id 
                             JOIN Comments ON Comment_reply.comment_id = Comments.comment_id
                             WHERE Comment_reply.comment_id = " . $commentRow["comment_id"];
                $replyResult = $conn->query($replySql);
                if ($replyResult->num_rows > 0) {
                    $current_count = 0;
                    while ($replyRow = $replyResult->fetch_assoc()) {
                        $current_count++;
                        echo "<div class='reply' style='margin-left: " . $current_count . "rem;'><p>Reply by: " . $replyRow["user_name"] . " - Reply Content: " . $replyRow["reply_content"] . " - On Comment: " . $replyRow["comment_content"] . "</p></div>";
                    }
                }
            }
        }
        echo "</div></div>";
    }
}
echo "</div>";

$conn->close();
?>
