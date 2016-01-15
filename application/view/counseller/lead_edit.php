
<!DOCTYPE HTML>
<html>
    <head>
        <title>LibraryExpress</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="<?php echo URL; ?>js/jquery-1.11.2.min.js"></script>
        <script src="<?php echo URL; ?>js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="<?php echo URL; ?>css/bootstrap.min.css">
        <script src="<?php echo URL; ?>js/jquery.validate.min.js"></script>


        <script>
            $(document).ready(function () {


                $("#signupForm").validate({
                    rules: {
                        firstname: {
                            required: true,
                            minlength: 3,
                            alphanumeric: true
                        },
                        lastname: {
                            required: true,
                            minlength: 3,
                            alphanumeric: true
                        },
                        phnno: {
                            required: true,
                            minlength: 10,
                            maxlength: 10
                        }, address: {
                            required: true, minlength: 3
                        }

                    },
                    messages: {
                        firstname: {
                            required: "Please enter first name.",
                            minlength: "Firstname must be at least 3 characters long."
                        },
                        lastname: {
                            required: "Please enter last name.",
                            minlength: "Lastname must be at least 3 characters long."
                        },
                        address: {
                            required: "Please enter Address.",
                            minlength: "Address must be at least 3 characters long."
                        }

                    }

                });
            });
        </script>

        <style>

            .error{
                color:red;
            }
            .form-signin
            {
                max-width: 330px;
                padding: 10px;
                margin: 0 auto;
            }
            .form-signin .form-signin-heading, .form-signin .checkbox
            {
                margin-bottom: 10px;
            }

            .form-signin .checkbox
            {
                font-weight: normal;
                padding-left:20px !important;
            }
            .form-signin .form-control
            {
                font-size: 13px;
                height: 25px;
                padding: 4px;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            .form-signin .form-control:focus
            {
                z-index: 2;
            }
            .form-signin input[type="text"]
            {	
                margin-bottom:2px;
                border-bottom-left-radius: 0;
                border-bottom-right-radius: 0;
            }
            .form-signin input[type="password"]
            {
                margin-bottom: 10px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
            .account-wall
            {	
                margin-top: 20px;
                padding: 20px 0px 20px 0px;
                background-color: #f7f7f7;
                -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);

            }
            .foot-link
            {
                margin-top: 10px;
            }
            .new-account
            {
                display: block;
                margin-top: 10px;
            }

            body{
                font-family: calibri,arial;
                font-size: 16;
                background-color:white;
            }
            #signupDiv{
                padding:15px;
            }

            #signupDiv label{
                margin-right:10px;
                font-weight:normal;
            }
            p{
                margin: 0px 0 5px !important;
            }
        </style>
        <script>



        </script>

    </head>

    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo URL . 'counseller' ?>">LMS</a>
                </div>
                <div>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"> <?php echo $counsellerDetail->counseller_username; ?></a></li>
                        <li> <a href="<?php echo URL . 'counseller/leadlist' ?>">Lead list</a></li>
                        <li> <a href="<?php echo URL . 'counseller/addlead' ?>">Add List</a></li>
                        <li><a href="<?php echo URL . 'counseller/logout' ?>"> Logout</a></li>

                    </ul>
                </div>
            </div>
        </nav>

        <div class="container" >
            <div class="row">
                <div class="col-sm-4  col-sm-offset-4">

                    <div class="account-wall" id="signupDiv">

                        <h2 class="text-center" style="margin-top:5px;">Edit Lead</h2>
                        <div id ="error" style="height:auto;"></div>
                        <form id="signupForm" class="form-signin" method="post" action="<?php echo URL; ?>counseller/editleadaction/<?php echo htmlspecialchars($lead->lead_id, ENT_QUOTES, 'UTF-8'); ?>" >

                            <p><label for="first_name">Firstname *</label><input value="<?php echo $lead->lead_first_name; ?>" type="text" class="form-control"  name="first_name"  autofocus ></p>
                            <p><label for="middle_name">Middlename *</label><input value="<?php echo $lead->lead_middle_name; ?>" type="text" class="form-control"  name="middle_name"  ></p>
                            <p><label for="last_name">Lastname *</label><input  value="<?php echo $lead->lead_last_name; ?>" type="text" class="form-control"  name="last_name"  ></p>

                            <p><label for="address">Address *</label><input value="<?php echo $lead->lead_address; ?>" type="text" class="form-control" name="address"  ></p>

                            <p><label for="contactNumber">Contact Number *</label>(+977)<input value="<?php echo $lead->lead_mobile_no; ?>" type="number" class="form-control"  name="mobile_no"  ></p>
                            <br/>
                            <input class="btn  btn-primary btn-block" type="submit" id="submit" value="Edit">
                            <br/>
                        </form>

<!--                        <form action="<?php echo URL; ?>counseller/editleadaction/<?php echo htmlspecialchars($lead->lead_id, ENT_QUOTES, 'UTF-8'); ?>" method="POST">
                            First Name:<input type="text" name="first_name" value="<?php echo $lead->lead_first_name; ?>"/><br>
                            Middle Name:<input type="text" name="middle_name" value="<?php echo $lead->lead_middle_name; ?>"/><br>
                            Last Name:<input type="text" name="last_name" value="<?php echo $lead->lead_last_name; ?>"/><br>
                            Address:<input type="text" name="address" value="<?php echo $lead->lead_address; ?>"/><br>
                            Mobile No:<input type="text" name="mobile_no" value="<?php echo $lead->lead_mobile_no; ?>" /><br>
                            <input  type="submit" value="Edit Lead"  />
                        </form>-->
                    </div>  
                </div>
            </div>
        </div>
    </body>


</html>