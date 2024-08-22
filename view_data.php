<?php
include 'db_connect.php';

// Fetch Users
$userSql = "SELECT * FROM Users";
$userResult = $conn->query($userSql);

echo "<h1>Users</h1>";
if ($userResult->num_rows > 0) {
    while($userRow = $userResult->fetch_assoc()) {
        echo "User ID: " . $userRow["user_id"] . " - Name: " . $userRow["user_name"] . "<br>";
    }
} else {
    echo "0 Users";
}

// Fetch Posts
$postSql = "SELECT Posts.*, Users.user_name FROM Posts JOIN Users ON Posts.user_id = Users.user_id";
$postResult = $conn->query($postSql);

echo "<h1>Posts</h1>";
if ($postResult->num_rows > 0) {
    while($postRow = $postResult->fetch_assoc()) {
        echo "Post ID: " . $postRow["post_id"] . " - Content: " . $postRow["post_content"] . " - Posted by: " . $postRow["user_name"] . "<br>";
    }
} else {
    echo "0 Posts";
}

// Fetch Comments
$commentSql = "SELECT Comments.*, Users.user_name, Posts.post_content 
               FROM Comments 
               JOIN Users ON Comments.user_id = Users.user_id 
               JOIN Posts ON Comments.post_id = Posts.post_id";
$commentResult = $conn->query($commentSql);

echo "<h1>Comments</h1>";
if ($commentResult->num_rows > 0) {
    while($commentRow = $commentResult->fetch_assoc()) {
        echo "Comment ID: " . $commentRow["comment_id"] . " - Content: " . $commentRow["comment_content"] . " - By: " . $commentRow["user_name"] . " - On Post: " . $commentRow["post_content"] . "<br>";
    }
} else {
    echo "0 Comments";
}

// Fetch Comment Replies
$replySql = "SELECT Comment_reply.*, Users.user_name, Comments.comment_content 
             FROM Comment_reply 
             JOIN Users ON Comment_reply.user_id = Users.user_id 
             JOIN Comments ON Comment_reply.comment_id = Comments.comment_id";
$replyResult = $conn->query($replySql);

echo "<h1>Comment Replies</h1>";
if ($replyResult->num_rows > 0) {
    while($replyRow = $replyResult->fetch_assoc()) {
        echo "Reply by: " . $replyRow["user_name"] . " - Reply Content: " . $replyRow["reply_content"] . " - On Comment: " . $replyRow["comment_content"] . "<br>";
    }
} else {
    echo "0 Replies";
}

$conn->close();
?>
