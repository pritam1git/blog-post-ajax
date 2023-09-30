<?php
// Include database connection and configuration
include 'db.php';

// Number of posts per page
$postsPerPage = 5;

// Get current page from AJAX request
if (isset($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1; // Default to the first page
}

// Calculate the offset for SQL query
$offset = ($currentPage - 1) * $postsPerPage;

// Query to fetch posts for the current page
$query = "SELECT * FROM all_blog LIMIT ?, ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $offset, $postsPerPage);
$stmt->execute();
$result = $stmt->get_result();

// $page_blog = array();
// Display blog posts in HTML format
while ($row = $result->fetch_assoc()) {
    // $page_blog[] = $row;
    // Display each blog post here
    echo '<div class="col-lg-8 mx-auto col-md-8 mb-4" style="width:60%;">';
    echo '<div class="card">';
    echo '<div class="bg-image hover-overlay ripple">';
    echo '<img src="' . $row['image'] . '" class="img-fluid" style="width: -webkit-fill-available;" />';
    echo '<a href="#!">';
    echo '<div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>';
    echo '</a>';
    echo '</div>';
    echo '<div class="card-body">';
    echo '<h5 class="card-title fs-5">' . $row['title'] . '</h5>';
    echo '<p class="card-text m-0 mb-3">' . $row['desc'] . '</p>';
    echo '<span>';
    if ($row['likes'] == 1) {
        echo '<i class="bi bi-hand-thumbs-up-fill dislike_icon fs-3 me-2" data-id="' . $row['id'] . '"></i>';
    } else {
        echo '<i class="bi bi-hand-thumbs-up like_icon fs-3 me-2" data-id="' . $row['id'] . '"></i>';
    }
    if ($row['fav'] == 1) {
        echo '<i class="bi bi-bookmark-heart-fill remove_fav fs-3" data-id="' . $row['id'] . '"></i>';
    } else {
        echo '<i class="bi bi-bookmark-heart fav-button fs-3" data-id="' . $row['id'] . '"></i>';
    }
    echo '</span>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

// Close the database connection and statement
$stmt->close();
$conn->close();
