<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>

<?php
    if(isset($_POST["Submit"])){
        $Title = mysqli_real_escape_string($Connection, $_POST["Title"]);
        $Post = mysqli_real_escape_string($Connection, $_POST["Post"]);
        $Category = mysqli_real_escape_string($Connection, $_POST["Category"]);

        date_default_timezone_set("Asia/Kolkata");
        $CurrentTime = time();
        $DateTime    = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
        echo $DateTime;

        $Admin  = "Abdullah saleh";
        $Image  = $_FILES["Image"]["name"];
        $Target = "Upload/".basename($_FILES["Image"] ["name"]);

        if(empty($Title)){
            $_SESSION["ErrorMessage"] = "Title Can Not Be Empty";
            Redierct_to("addNewPost.php");

        }elseif(strlen($Title) < 3){
            $_SESSION["ErrorMessage"] = "Title Can Not Be Less Than 3 Letters";
            Redierct_to("addNewPost.php");           
        }elseif(empty($Post)){
            $_SESSION["ErrorMessage"] = "Post Can Not Be Empty";
            Redierct_to("addNewPost.php");  
        }else{       
                global $ConnectingDB;
                $Query = "Insert Into admin_panel (datetime, title, category, author, image, post)
                 VALUES ('$DateTime' , '$Title' , '$Category' , '$Admin' , '$Image' , '$Post')";
                $Execute = mysqli_query($Connection, $Query);

                move_uploaded_file($_FILES["Image"] ['tmp_name'],$Target);
                if(($Execute)){ 
                   
                    $_SESSION["SuccessMessage"] = "Post Added Successfuly";
                    Redierct_to("addNewPost.php"); 

                }else{
                    
                    $_SESSION["ErrorMessage"] = "Something Went Wrong Please Try Again";
                    Redierct_to("addNewPost.php");

                }

        }

    }
     session_destroy(); // Finally, destroy the session.


?>


<!DOCTYPE html>
<html>
    <head>
        <title>Add New Post</title>
        <link rel="stylesheet" href="css/bootstrap.min.css"> 
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css">
        <link rel="stylesheet" href="css/adminstyles.css">

    </head>
    <body>
    <div class="container-fluid">
    <div class="row">

        <div class="col-sm-2"> <!-- Start Of Side Area-->
            <h1>Blog</h1>
            <ul id="side-menu" class="nav nav-pills nav-stacked">
                <li><a href="dashboard.php">
                <span class="glyphicon glyphicon-th"></span> &nbsp;Dashboard</a></li>
                <li class="active"><a href="addNewPost.php">
                <span class="glyphicon glyphicon-list-alt"> </span> &nbsp;Add Post</a></li>
                <li><a href="categories.php">
                <span class="glyphicon glyphicon-tags"></span> &nbsp;Category</a></li>
                <li><a href="#">
                <span class="glyphicon glyphicon-user"></span> &nbsp;Manage Admin</a></li>
                <li><a href="#">
                <span class="glyphicon glyphicon-comment"></span> &nbsp;Comments</a></li>
                <li><a href="#">
                <span class="glyphicon glyphicon-equalizer"></span> &nbsp;Live Blog</a></li>
                <li><a href="#">
                <span class="glyphicon glyphicon-log-out"></span> &nbsp;Logout</a></li>
            </ul>

        </div> <!--Ending Of Side Area--> 

        <div class="col-sm-10"> <!-- Start Of Main Area-->
            <h1>Add New Post</h1>
            <?php 
                echo errorMessage();
                echo successMessage();
            ?>
            <div>
                <form action="addNewPost.php" method="POST" enctype="multipart/form-data">
                    <fieldset>
                        <div class="form-group">
                            <label for="title">Title </label>
                            <input class="form-control" type="title" name="Title" id="title" placeholder="Title">
                        </div>
                        <div class="form-group">
                            <label for="categoryselect">Category: </label>
                            <select class="form-control" id="categoryselect" name="Category">

                              <?php
                                    global $ConnectingDB;
                                    $viewQuery = "SELECT * FROM category  ORDER BY datetime desc";
                                    $Execute = mysqli_query($Connection, $viewQuery);
                                    while($DataRows = mysqli_fetch_array($Execute)){
                                        $Id = $DataRows["id"];
                                        $CategoryName = $DataRows["name"];
                                ?>
                                <option> <?php echo $CategoryName; ?></option>

                                    <?php } // End Of While Loop ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="imageselect">Select Image: </label>
                            <input type="File" class="form-control" name="Image" id="imageselect">
                        </div>
                        <div class="form-group">
                            <label for="postarea">Post: </label>
                            <textarea class="form-control" name="Post" id="postarea"></textarea>
                        <br>
                        <input class="btn btn-info" type="Submit" name="Submit" value="Add New Post">
                    </fieldset>
                    <br>
                </form>
            </div>

        </div> <!-- Ending Of Main Area-->

    </div> <!-- End Of Row -->
    </div> <!-- End Of The Container -->

    <!-- Start Footer -->
			<footer id="main-footer">
					<h2>Get In Touch</h2>
					<ul class="actions">
						<li><span class="glyphicon glyphicon-earphone"></span> <a href="#">(000) 000-0000</a></li>
						<li><span class="glyphicon glyphicon-envelope"></span> <a href="#">information@untitled.tld</a></li>
						<li><span class="icon fa-map-marker"></span> 123 Somewhere Road, Nashville, TN 00000</li>
					</ul>
					&copy; Untitled. Design <a href="#">TEMPLATED</a>. Images <a href="#">Unsplash</a>
			</footer>
    <!-- End Footer-->

    <!--Scripts-->
    <script
        src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>