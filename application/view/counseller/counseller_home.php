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
            function showModel(id, fn, mn, ln, ad, mob, stat) {
                lead_id = id;
                $('#m-un').val(fn + mn + ln);
                $('#m-ad').val(ad);
                $('#m-mn').val(mob);
                $('#m-stat').val(stat);

                $('#model').modal({backdrop: "static"});
            }
            $(function () {

                followUpBtnAction = function (row) {
                    var id = $(row).attr('lead-id'),
                            fn = $(row).attr('lead-fn'),
                            mn = $(row).attr('lead-mn'),
                            ln = $(row).attr('lead-ln'),
                            ad = $(row).attr('lead-ad'),
                            mob = $(row).attr('lead-mob'),
                            stat = $(row).attr('lead-stat');

                    showModel(id, fn, mn, ln, ad, mob, stat);
                }

                $('#addFollowUpBtn').on('click', function () {
                    $.post("<?php echo URL; ?>counseller/addfollowupdetail", {
                        'lead-id': lead_id,
                        'followupdesc': $('#m-followUpDesc').val(),
                        'nextfollowupdate': $('#m-nextfollowupdate').val()
                    }, function (data) {
                        if (data === "1") {
                            $('#model').modal('hide');
                            location.reload();
                        }
                    })
                });
            });
        </script>
        <script>
            $(function () {
                viewFollowups = function (row) {
                    $('#model-follow-body').html('');
                    var lead_id = $(row).attr('lead-id');
                    $.post("<?php echo URL; ?>counseller/followups", {
                        'lead-id': lead_id
                    }, function (data) {
                        $('#model-follow-body').append('<ul class="list-group">');
                        for (item in data) {
                            $('#model-follow-body').append('<li class="list-group-item">' + data[item].feedback + '</li>');
                        }
                        $('#model-follow-body').append('</ul>');
                        $('#model-follow').modal({backdrop: "static"});
                    })
                }

                changeStatus = function (row) {
                    lead_id = $(row).attr('lead-id');
                    $('#model-status').modal({backdrop: "static"});
                };
                changeStatusState = function (status) {
                    $.post("<?php echo URL; ?>counseller/changeStatus", {
                        'lead-id': lead_id,
                        'status': status
                    }, function (data) {
                        if (data === '1') {
                            $('#model-status').modal('hide');
                            location.reload();
                        }
                    });
                }
            });
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
                        <li class="active"><a href="#"> <?php echo $counsellerDetail->counseller_username; ?></a></li>
                        <li> <a href="<?php echo URL . 'counseller/leadlist' ?>">Lead list</a></li>
                        <li> <a href="<?php echo URL . 'counseller/addlead' ?>">Add Lead</a></li>
                        <li><a href="<?php echo URL . 'counseller/logout' ?>"> Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <h1>
                    Leads to Follow today
                </h1>
                <table class="table table-striped">
                    <thead>
                    <th>
                        First Name
                    </th>
                    <th>
                        Middle Name
                    </th>
                    <th>
                        Last Name
                    </th>
                    <th>
                        Address
                    </th>
                    <th>
                        Mobile No
                    </th>
                    <th>
                        Status
                    </th>
                    <th>
                        Total followups
                    </th>
                    <th>
                        Action
                    </th>
                    <thead>
                    <tbody>

                        <?php foreach ($leadlist as $lead) { ?>
                            <tr>
                                <td><?php echo $lead->lead_first_name; ?></td>
                                <td><?php echo $lead->lead_middle_name; ?></td>
                                <td><?php echo $lead->lead_last_name; ?></td>
                                <td><?php echo $lead->lead_address; ?></td>
                                <td><?php echo $lead->lead_mobile_no; ?></td>
                                <td><button class="btn btn-success" id="changeStat" onclick="changeStatus(this)" lead-id="<?php echo $lead->lead_id; ?>"><?php echo $lead->status; ?></button></td>
                                <td><button onclick="viewFollowups(this)" lead-id="<?php echo $lead->lead_id; ?>" class="btn btn-toolbar btn-block"><?php echo $lead->followupcount; ?></button></td>
                                <td><button class="btn btn-primary" lead-id="<?php echo $lead->lead_id; ?>"
                                            lead-fn="<?php echo $lead->lead_first_name; ?>"
                                            lead-mn="<?php echo $lead->lead_middle_name; ?>"
                                            lead-ln="<?php echo $lead->lead_last_name; ?>"
                                            lead-ad="<?php echo $lead->lead_address; ?>"
                                            lead-mob="<?php echo $lead->lead_mobile_no; ?>"
                                            lead-stat="<?php echo $lead->status; ?>"
                                            id="followUpBtn" onclick="followUpBtnAction(this)">Add Followup Detail</button></td>

                            </tr>
                        <?php } ?>

                    </tbody>
                </table>

            </div>

        </div>
        <div class="modal fade" role="dialog" id="model">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h4 class="modal-title">Follow up Detail</h4>
                    </div>
                    <div class="modal-body" >
                        <div class="form-group">
                            <label for="m-un">Username</label>
                            <input type="text" class="form-control" id="m-un" disabled>
                        </div>
                        <div class="form-group">
                            <label for="m-ad">Address</label>
                            <input type="text" class="form-control" id="m-ad" disabled>
                        </div>
                        <div class="form-group">
                            <label for="m-mn">Mobile No</label>
                            <input type="text" class="form-control" id="m-mn" disabled>
                        </div>
                        <div class="form-group">
                            <label for="m-stat">Status</label>
                            <input type="text" class="form-control" id="m-stat" disabled>
                        </div>
                        <div class="form-group">
                            <label  for="m-followUpDesc">Follow Description</label>
                            <textarea class="form-control" id="m-followUpDesc"></textarea>
                        </div>
                        <div class="form-group">
                            <label  for="m-nextfollowupdate">Next Followup Date</label>
                            <input type="date" class="form-control" id="m-nextfollowupdate">
                        </div>
                        <button class="btn btn-primary btn-block" id="addFollowUpBtn" lead-id="">Add Followup Description</button>
                        <!--<input id="m-id" type="text" value=""/>-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal fade" role="dialog" id="model-follow">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h4 class="modal-title">Follow up Detail</h4>
                    </div>
                    <div id="model-follow-body" class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal fade" role="dialog" id="model-status">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h4 class="modal-title">Change Status</h4>
                    </div>
                    <div id="model-body" class="modal-body">
                        <ul class=" list-group">
                            <li class="list-group-item ">
                                <button onclick="changeStatusState(0)" class="btn btn-block ">Postponed</button>
                            </li>
                            <li class="list-group-item">
                                <button onclick="changeStatusState(2)" class="btn btn-block">Not interested</button>
                            </li>
                            <li class="list-group-item">
                                <button onclick="changeStatusState(3)" class="btn btn-block">Is Student</button>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>


