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
            $(function () {
                submitintake = function () {
                    $.post("<?php echo URL; ?>admin/addintake ", {
                        'intake-name': $('#intake-name').val(),
                        'intake-start-date': $('#intake-start-date').val()
                    }, function (data) {
                        if (data === "1") {
                            $('#model').modal('hide');
                            location.reload();
                        }
                    });
                }
                addintake = function () {
                    $('#intake-model').modal({backdrop: "static"});

                }
                deleteCounseller = function (item) {
                    $.post("<?php echo URL; ?>admin/deletecounseller", {
                        'id': $(item).attr('c-id')
                    }, function (data) {
                        if (data === "1") {
                            $('#model').modal('hide');
                            location.reload();
                        }
                    });
                };
                editCounsellerForm = function (item) {
                    id = $(item).attr('c-id');
                    var username = $(item).attr('username');
                    var password = $(item).attr('password');
                    var fullname = $(item).attr('fullname');
                    var address = $(item).attr('address');
                    var email = $(item).attr('email');
                    var mobno = $(item).attr('mobileno');

                    $('#m-un').val(username);
                    $('#m-pwd').val(password);
                    $('#m-fn').val(fullname);
                    $('#m-ad').val(address);
                    $('#m-email').val(email);
                    $('#m-mn').val(mobno);

                    $('#addFollowUpBtn').html("Edit");
                    $('#model').modal({backdrop: "static"});

                }
                showCounsellerAddForm = function () {
                    $('#addFollowUpBtn').html("Add Counseller");
                    $('#model').modal({backdrop: "static"});
                }
                addcounseller = function () {
                    var username = $('#m-un').val();
                    var password = $('#m-pwd').val();
                    var fullname = $('#m-fn').val();
                    var address = $('#m-ad').val();
                    var email = $('#m-email').val();
                    var mobno = $('#m-mn').val();

                    if ($('#addFollowUpBtn').html() === "Edit") {
                        $.post("<?php echo URL; ?>admin/editcounseller", {
                            'id': id,
                            'username': username,
                            'password': password,
                            'fullname': fullname,
                            'address': address,
                            'email': email,
                            'mobno': mobno
                        }, function (data) {
                            if (data === "1") {
                                $('#model').modal('hide');
                                location.reload();
                            }
                        });
                    } else {
                        $.post("<?php echo URL; ?>admin/addcounseller", {
                            'username': username,
                            'password': password,
                            'fullname': fullname,
                            'address': address,
                            'email': email,
                            'mobno': mobno
                        }, function (data) {
                            if (data === "1") {
                                $('#model').modal('hide');
                                location.reload();
                            }
                        });
                    }

                }
            });
        </script>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="">LMS</a>
                </div>
                <div>
                    <ul class="nav navbar-nav navbar-left">
                        <li > <button class="btn navbar-btn"onclick="showCounsellerAddForm()">Add Counseller</button></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <!--<li><a href=""> <?php echo $counsellerDetail->counseller_username; ?></a></li>-->
                        <li><a onclick="addintake()">Add Intake</a></li>
                        <li><a><?php echo $intake->intake_name; ?></a></li>
                        <li class="active"> <a href="<?php echo URL . 'admin' ?>">Manage Counseller</a></li>
                        <li> <a href="<?php echo URL . 'admin/counsellerreport' ?>">Report</a></li>
                        <li><a href="<?php echo URL . 'counseller/logout' ?>"> Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <?php foreach ($counsellerlist as $counseller) { ?>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">

                            <div class="col-xs-9 text-left">
                                <div><?php echo $counseller->counseller_username; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <!--<div class="h4">Information</div>-->
                        <div class="list-group">
                            <div class="list-group-item"><?php echo $counseller->counseller_fullname; ?></div>
                            <div class="list-group-item"><?php echo $counseller->counseller_address; ?></div>
                            <div class="list-group-item"><?php echo $counseller->counseller_email; ?></div>
                            <div class="list-group-item"><?php echo $counseller->counseller_phone_no; ?></div>
                        </div>
                    </div>

                    <div class="panel-footer">
                        <span 
                            c-id="<?php echo $counseller->counseller_id; ?>"
                            username="<?php echo $counseller->counseller_username; ?>"
                            password="<?php echo $counseller->counseller_password; ?>"
                            fullname="<?php echo $counseller->counseller_fullname; ?>"
                            address="<?php echo $counseller->counseller_address; ?>"
                            email="<?php echo $counseller->counseller_email; ?>"
                            mobileno="<?php echo $counseller->counseller_phone_no; ?>"
                            onclick="editCounsellerForm(this)"
                            class="btn btn-info">Edit</span>
                        <span c-id="<?php echo $counseller->counseller_id; ?>" onclick="deleteCounseller(this)" class="btn btn-danger">Delete</span>
                    </div>

                </div>
            </div>

            <?php
        }
        ?>

        <div class="modal fade" role="dialog" id="model">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body" >
                        <div class="form-group">
                            <label for="m-un">Username</label>
                            <input type="text" class="form-control" id="m-un" >
                        </div>
                        <div class="form-group">
                            <label for="m-pwd">password</label>
                            <input type="password" class="form-control" id="m-pwd" >
                        </div>
                        <div class="form-group">
                            <label for="m-fn">FullName</label>
                            <input type="text" class="form-control" id="m-fn" >
                        </div>
                        <div class="form-group">
                            <label for="m-ad">Address</label>
                            <input type="text" class="form-control" id="m-ad" >
                        </div>
                        <div class="form-group">
                            <label for="m-email">Email Address</label>
                            <input type="text" class="form-control" id="m-email" >
                        </div>
                        <div class="form-group">
                            <label for="m-mn">Mobile No</label>
                            <input type="text" class="form-control" id="m-mn" >
                        </div>
                        <button onclick="addcounseller()" class="btn btn-primary btn-block" id="addFollowUpBtn">Add Counseller</button>

                        <!--<input id="m-id" type="text" value=""/>-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

        <div class="modal fade" role="dialog" id="intake-model">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body" >
                        <div class="form-group">
                            <label for="m-un">Intake Name</label>
                            <input type="text" class="form-control" id="intake-name" >
                        </div>
                        <div class="form-group">
                            <label for="m-pwd">Intake Start Date</label>
                            <input type="date" class="form-control" id="intake-start-date" >
                        </div>
                        <button onclick="submitintake()" class="btn btn-primary btn-block" >Add Intake</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>