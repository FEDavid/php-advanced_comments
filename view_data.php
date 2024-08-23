<?php
include 'db_connect.php';

$postSql = "SELECT Posts.*, Users.user_name FROM Posts JOIN Users ON Posts.user_id = Users.user_id";
$postResult = $conn->query($postSql);

echo "<div id='posts'>";
if ($postResult->num_rows > 0) {
    while ($postRow = $postResult->fetch_assoc()) {
        $commentSql = "SELECT Comments.*, Users.user_name, Posts.post_content 
                       FROM Comments 
                       JOIN Users ON Comments.user_id = Users.user_id 
                       JOIN Posts ON Comments.post_id = Posts.post_id
                       WHERE Comments.post_id = " . $postRow["post_id"];
        $commentResult = $conn->query($commentSql);
        $commentCount = $commentResult->num_rows;

        echo "<div class='post'><div class='post_details'><h2 class='post_title'>Post ID: " . $postRow["post_id"] . "</h2><p class='post_content'>" . $postRow["post_content"] . "</p><p class='post_author'>" . $postRow["user_name"] . "</p></div>";
        
        echo "<div class='comment_title'><h3>Comments</h3><div class='comment-count'>Comments: " . $commentCount . "</div><hr /></div><div id='comments'>";

        if ($commentResult->num_rows > 0) {
            while ($commentRow = $commentResult->fetch_assoc()) {
                $replySql = "SELECT COUNT(*) as reply_count FROM Comment_reply WHERE comment_id = " . $commentRow["comment_id"];
                $replyResult = $conn->query($replySql);
                $replyRow = $replyResult->fetch_assoc();

                echo "<div class='comment'><p>" . $commentRow["comment_content"] . "</p><p>By: <strong>" . $commentRow["user_name"] . "</strong></p></div>";

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
                        echo "<div class='reply' style='margin-left: " . $current_count . "rem;'><p>" . $replyRow["reply_content"] . "</p><p>By: <strong>" . $replyRow["user_name"] . "</strong></p></div>";
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
