<?php require_once("include/DB.php"); ?>
<?php require_once("include/Sessions.php"); ?>
<?php require_once("include/Functions.php"); ?>

<?php
    if(isset($_POST["Submit"])){
        $Category = mysqli_real_escape_string($Connection, $_POST["Category"]);
        date_default_timezone_set("Asia/Kolkata");
        $CurrentTime = time();
        $DateTime    = strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
        echo $DateTime;

        $Admin = "Abdullah saleh";
        if(empty($Category)){
            $_SESSION["ErrorMessage"] = "All Fields Must Be Filled Out";
            Redierct_to("categories.php");

        }elseif(strlen($Category) > 99){
            $_SESSION["ErrorMessage"] = "The Name Is Too Long For Category";
            Redierct_to("categories.php");           
        }else{
                
                global $ConnectingDB;
                $Query = "Insert Into category (datetime, name, creatorname)
                 VALUES ('".$DateTime."','".($_POST['Category'])."','".$Admin."')";
                $Execute = mysqli_query($Connection, $Query);
                if(($Execute)){ 
                   
                    $_SESSION["SuccessMessage"] = "Category Added Successfuly";
                    Redierct_to("categories.php"); 

                }else{
                    
                    $_SESSION["ErrorMessage"] = "Failed To Add Category";
                    Redierct_to("categories.php");

                }

        }

    }
     session_destroy(); // Finally, destroy the session.


?>


<!DOCTYPE html>
<html>
    <head>
        <title>Category</title>
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
                <li><a href="addNewPost.php">
                <span class="glyphicon glyphicon-list-alt"> </span> &nbsp;Add Post</a></li>
                <li class="active"><a href="categories.php">
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
            <h1>Manage categories</h1>
            <?php 
                echo errorMessage();
                echo successMessage();
            ?>
            <div>
                <form action="categories.php" method="POST">
                    <fieldset>
                        <div class="form-group">
                            <label for="categoryname">Name </label>
                            <input class="form-control" type="text" name="Category" id="categoryname" placeholder="Name">
                        </div>
                        <br>
                        <input class="btn btn-info" type="Submit" name="Submit" value="Add New Category">
                    </fieldset>
                    <br>
                </form>
            </div>

            <div class="table-responsive"> <!-- This Div For Table -->
                <table  class="table table-striped table-hover">
                    <tr>
                        <th>Sr No.</th>
                        <th>Date & Time</th>
                        <th>Category Name</th>
                        <th>Author Name</th>
                    </tr>

                    <?php
                        global $ConnectingDB;
                        $viewQuery = "SELECT * FROM category  ORDER BY datetime desc";
                        $Execute = mysqli_query($Connection, $viewQuery);
                        $srNo = 0 ;
                        while($DataRows = mysqli_fetch_array($Execute)){
                            $Id = $DataRows["id"];
                            $DateTime = $DataRows["datetime"];
                            $CategoryName = $DataRows["name"];
                            $CreatorName = $DataRows["creatorname"];
                            $srNo ++ ;
                    ?>
                    <tr>
                        <td><?php echo $srNo ;?></td>
                        <td><?php echo $DateTime ;?></td>
                        <td><?php echo $CategoryName ;?></td>
                        <td><?php echo $CategoryName ;?></td>
                    </tr>
                    <?php  } // end of while loop ?> 
                </table>
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