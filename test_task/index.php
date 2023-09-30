<?php
include_once('db.php');

$page_blog = array();
$sql = "SELECT * FROM all_blog";
$res = mysqli_query($conn, $sql);
$blogs = array();
while ($row = mysqli_fetch_assoc($res)) {
    $blogs[] = $row;
}



$fav_sql = "SELECT * FROM all_blog where fav = 1";
$fav_res = mysqli_query($conn, $fav_sql);
$fav_blogs = array();
while ($row = mysqli_fetch_assoc($fav_res)) {
    $fav_blogs[] = $row;
}



$like_sql = "SELECT * FROM all_blog where likes = 1";
$like_res = mysqli_query($conn, $like_sql);

$Likes = array();

while ($row = mysqli_fetch_assoc($like_res)) {
    $likes[] = $row;
}





if (isset($_POST['action']) && $_POST['action'] == 'like_blog') {
    $sql = "UPDATE all_blog SET likes = 1 where id =" . $_POST['blog_id'];
    $res = mysqli_query($conn, $sql);
    if ($res) {
        echo json_encode(array('message' => 'Liked Successfully', 'status' => 'liked'));
    } else {
        echo json_encode(array('message' => 'Something went wrong. Try again later.', 'status' => 'not_liked'));
    }
    die;
}
if (isset($_POST['action']) && $_POST['action'] == 'dislike_blog') {
    $sql = "UPDATE all_blog SET likes = 0 where id =" . $_POST['blog_id'];
    $res = mysqli_query($conn, $sql);
    if ($res) {
        echo json_encode(array('message' => 'Disliked Successfully', 'status' => 'dislike'));
    } else {
        echo json_encode(array('message' => 'Something went wrong. Try again later.', 'status' => 'not_liked'));
    }
    die;
}
if (isset($_POST['action']) && $_POST['action'] == 'fav_blog') {
    $sql = "UPDATE all_blog SET fav = 1 where id =" . $_POST['blog_id'];
    $res = mysqli_query($conn, $sql);
    if ($res) {
        echo json_encode(array('message' => 'Add to favourite Successfully', 'status' => 'fav'));
    } else {
        echo json_encode(array('message' => 'Something went wrong. Try again later.', 'status' => 'not_liked'));
    }
    die;
}

if (isset($_POST['action']) && $_POST['action'] == 'remove_fav_blog') {

    $sql = "UPDATE all_blog SET fav = 0 where id=" . $_POST['blog_id'];
    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo json_encode(array('message' => 'remove a fav', 'status' => 'remove_fav'));
    } else {
        echo json_encode(array('message' => 'not remove a fav', 'status' => 'not_remove'));
    }
    die;
}



?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blogs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        $(document).on('click', '.like_icon', function() {
            var blog_id = $(this).attr('data-id');
            var current = $(this);
            $.ajax({
                url: 'index.php',
                method: 'POST',
                data: {
                    'action': 'like_blog',
                    blog_id: blog_id
                },
                success: function(res) {
                    console.log(res);
                    var data = JSON.parse(res);
                    if (data['status'] == 'liked') {

                        current.removeClass('bi-hand-thumbs-up like_icon');
                        current.addClass('bi-hand-thumbs-up-fill dislike_icon');
                    }
                }
            })
        });
        $(document).on('click', '.dislike_icon', function() {
            var blog_id = $(this).attr('data-id');
            var current = $(this);
            $.ajax({
                url: 'index.php',
                method: 'POST',
                data: {
                    'action': 'dislike_blog',
                    blog_id: blog_id
                },
                success: function(res) {
                    var data = JSON.parse(res);
                    if (data['status'] == 'dislike') {

                        current.addClass('bi-hand-thumbs-up like_icon');
                        current.removeClass('bi-hand-thumbs-up-fill dislike_icon');
                    }
                }
            })
        });
        // Favoriting a blog post
        $(document).on('click', '.fav-button', function() {
            var blog_id = $(this).data('id');
            var current = $(this);

            $.ajax({
                url: 'index.php',
                method: 'POST',
                data: {
                    'action': 'fav_blog',
                    'blog_id': blog_id
                },
                success: function(res) {

                    var data = JSON.parse(res);
                    if (data['status'] == 'fav') {
                        current.toggleClass('bi-bookmark-heart bi-bookmark-heart-fill');
                        current.toggleClass('fav-button remove_fav');
                    }
                }
            });
        });
        $(document).on('click', '.dislike_icon', function() {
            var blog_id = $(this).attr('data-id');
            var current = $(this);
            $.ajax({
                url: 'index.php',
                method: 'POST',
                data: {
                    'action': 'dislike_blog',
                    blog_id: blog_id
                },
                success: function(res) {
                    var data = JSON.parse(res);
                    if (data['status'] == 'dislike') {

                        current.addClass('bi-hand-thumbs-up like_icon');
                        current.removeClass('bi-hand-thumbs-up-fill dislike_icon');
                    }
                }
            })
        });
        // Favoriting a blog post

        $(document).on('click', '.remove_fav', function() {
            var blog_id = $(this).attr('data-id');
            var current = $(this);
            $.ajax({
                url: 'index.php',
                method: 'POST',
                data: {
                    'action': 'remove_fav_blog',
                    blog_id: blog_id
                },
                success: function(res) {
                    var data = JSON.parse(res);
                    if (data['status'] == 'remove_fav') {

                        current.removeClass('bi-bookmark-heart-fill remove_fav');
                        current.addClass('bi-bookmark-heart fav-button');
                    }
                }
            })
        });




        $(document).ready(function() {
            // Initial page load
            loadPage(1);

            // Function to load blog posts via AJAX
            function loadPage(page) {
                $.ajax({
                    url: 'fatch.php', // Replace with your PHP script to fetch posts
                    type: 'GET',
                    data: {
                        page: page
                    },
                    success: function(data){
                        $('#Home').hide();
                        $('#News').hide();
                        $('#Likes').hide();
                        $('#blog-posts').html(data);   
                    },
                    error: function() {
                        alert('Error loading blog posts.');
                    }
                });   
            }

            // Handle pagination link clicks
            $(document).on('click', '.pagination-link', function() {
                var page = $(this).data('page');
                loadPage(page);
            });
        });







        // Removing a favorite from a blog post


        function openPage(pageName, elmnt, color) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");

            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].style.backgroundColor = "";
            }
            document.getElementById(pageName).style.display = "block";
            elmnt.style.backgroundColor = color;
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
    </script>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white">

        <div class="container-fluid">
            <!-- Navbar brand -->
            <div class="container mt-4">
                <div id="blog-posts">

                </div>
                <div class="row">
                    <div class="col-12 bg-dark">
                        <div class="top-nav" style="position: fixed;top: 20px;left: 20px;">
                            <button class="tablink btn btn-warning all-blog mb-4" onclick="openPage('Home', this, 'red')">Blog</button>
                            <button class="tablink btn btn-success fav-button mb-4" onclick="openPage('News', this, 'green')" id="defaultOpen">My Fav</button>
                            <button class="tablink btn btn-info fav-button mb-4" onclick="openPage('Likes', this, 'laal')" id="defaultOpen">My Likes</button>

                        </div>
                    </div>
                </div>

                <div id="Home" class="tabcontent">
                    <div class="container">
                        <div class="row">
                            <h5 class="d-flex justify-content-center mt-3"> BLOGS</h5>
                            <?php foreach ($blogs as $key => $val) { ?>
                                <div class="col-lg-8 mx-auto col-md-8 mb-4" style="width:60%;">
                                    <div class="card">
                                        <div class="bg-image hover-overlay ripple">
                                            <img src="<?php echo $val['image']; ?>" class="img-fluid" style="width: -webkit-fill-available;" />
                                            <a href="#!">
                                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title fs-5"><?php echo $val['title']; ?></h5>
                                            <p class="card-text m-0 mb-3">
                                                <?php echo $val['desc']; ?>
                                            </p>
                                            <span>
                                                <i class="bi <?php if ($val['likes'] == 1) {
                                                                    echo 'bi-hand-thumbs-up-fill dislike_icon fs-3 me-2';
                                                                } else {
                                                                    echo 'bi-hand-thumbs-up like_icon fs-3 me-2';
                                                                } ?>" data-id='<?php echo $val['id']; ?>'></i>
                                                <i class="bi <?php if ($val['fav'] == 1) {
                                                                    echo 'bi-bookmark-heart-fill remove_fav fs-3';
                                                                } else {
                                                                    echo 'bi-bookmark-heart fav-button fs-3';
                                                                } ?>" data-id='<?php echo $val['id']; ?>'></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div id="News" class="tabcontent">
                    <div class="container">
                        <h5 class="d-flex justify-content-center mt-3 mb-4">MY <i class="bi-bookmark-heart-fill " style="font-size: larger;"></i></h5>
                        <div class="row">
                            <?php foreach ($fav_blogs as $key => $val) { ?>
                                <div class="col-lg-8 mx-auto col-md-6 mb-4">
                                    <div class="card">
                                        <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                            <img src="<?php echo $val['image']; ?>" class="img-fluid" />
                                            <a href="#!">
                                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $val['title']; ?></h5>
                                            <p class="card-text">
                                                <?php echo $val['desc']; ?>
                                            </p>
                                            <span>
                                                <i class="bi <?php if ($val['likes'] == 1) {
                                                                    echo 'bi-hand-thumbs-up-fill dislike_icon fs-3';
                                                                } else {
                                                                    echo 'bi-hand-thumbs-up like_icon fs-3';
                                                                } ?>" data-id='<?php echo $val['id']; ?>'></i>
                                                <i class="bi <?php if ($val['fav'] == 1) {
                                                                    echo 'bi-bookmark-heart-fill remove_fav fs-3';
                                                                } else {
                                                                    echo 'bi-bookmark-heart fav-button fs-3';
                                                                } ?>" data-id='<?php echo $val['id']; ?>'></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div id="Likes" class="tabcontent">
                    <div class="container">
                        <h5 class="d-flex justify-content-center mt-3 mb-4">MY Likes </h5>
                        <div class="row">
                            <?php foreach ($likes as $key => $val) { ?>
                                <div class="col-lg-8 mx-auto col-md-6 mb-4">
                                    <div class="card">
                                        <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                            <img src="<?php echo $val['image']; ?>" class="img-fluid" />
                                            <a href="#!">
                                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $val['title']; ?></h5>
                                            <p class="card-text">
                                                <?php echo $val['desc']; ?>
                                            </p>
                                            <span>
                                                <i class="bi <?php if ($val['likes'] == 1) {
                                                                    echo 'bi-hand-thumbs-up-fill dislike_icon fs-3';
                                                                } else {
                                                                    echo 'bi-hand-thumbs-up like_icon fs-3';
                                                                } ?>" data-id='<?php echo $val['id']; ?>'></i>
                                                <i class="bi <?php if ($val['fav'] == 1) {
                                                                    echo 'bi-bookmark-heart-fill remove_fav fs-3';
                                                                } else {
                                                                    echo 'bi-bookmark-heart fav-button fs-3';
                                                                } ?>" data-id='<?php echo $val['id']; ?>'></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>


                <div id="blog-post" class="blog-post">

                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 bg-light" style="position: fixed;bottom: 0;left: 0;">
                            <ul class="pagination mt-4" style="justify-content: center;">
                                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                <button class="page-item page-link pagination-link" data-page="1">1</button>
                                <button class="page-item page-link pagination-link" data-page="2">2</button>
                                <button class="page-item page-link pagination-link" data-page="3">3</button>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                            <div id="pagination-result">
                                <input type="hidden" name="rowcount" id="rowcount" />
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </nav>



</body>

</html>