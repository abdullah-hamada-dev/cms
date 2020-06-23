<?php 
    session_start();

    function errorMessage(){  // This Function to show error message in div
        if(isset($_SESSION["ErrorMessage"])){
            $Output = "<div class = \" alert alert-danger \" >";
            $Output.= htmlentities($_SESSION["ErrorMessage"]);
            $Output.= "</div>";

            $_SESSION["ErrorMessage"] = null;
            return $Output;
        }
    }


    function successMessage(){ // This Message To Show success message in div
        if(isset($_SESSION["SuccessMessage"])){
            $Output = "<div class = \" alert alert-success \">";
            $Output.= htmlentities($_SESSION["SuccessMessage"]);
            $Output.= "</div>";

            $_SESSION["SuccessMessage"];
            return $Output;
        }
    }







?> 