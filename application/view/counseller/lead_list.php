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
                viewFollowups = function (row) {
                    $('#model-body').html('');
                    var lead_id = $(row).attr('lead-id');
                    $.post("<?php echo URL; ?>counseller/followups", {
                        'lead-id': lead_id
                    }, function (data) {
                        $('#model-body').append('<div class="list-group">');
                        for (item in data) {
                            $('#model-body').append('<a href="#" class="list-group-item"><h4 class="list-group-item-heading">'
                                    + data[item].followup_date + '</h4><p class="list-group-item-text">' + data[item].feedback + '</p></a>');
                        }
                        $('#model-body').append('</div>');
                        $('#model').modal({backdrop: "static"});
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
                        <li><a href="#"> <?php echo $counsellerDetail->counseller_username; ?></a></li>
                        <li class="active"> <a href="<?php echo URL . 'counseller/leadlist' ?>">Lead list</a></li>
                        <li> <a href="<?php echo URL . 'counseller/addlead' ?>">Add Lead</a></li>
                        <li><a href="<?php echo URL . 'counseller/logout' ?>"> Logout</a></li>

                    </ul>
                </div>
            </div>
        </nav>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
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
                        Next followup date
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
                                <td><button <?php
                                    if (!($lead->status == 'active') || $lead->isStudent) {
                                        echo 'disabled';
                                    }
                                    ?> onclick="changeStatus(this)" lead-id="<?php echo $lead->lead_id; ?>" class="btn btn-success btn-block"><?php echo boolval($lead->isStudent) ? "Student" : $lead->status; ?></button></td>
                                <td><?php if ($lead->status == 'active' && !$lead->isStudent) { ?>
                                        <?php if (is_null($lead->next_followup_date) || empty($lead->next_followup_date) || !isset($lead->next_followup_date)) { ?>
                                            <form method="post" action="<?php echo URL; ?>counseller/addfollowupaction/<?php echo htmlspecialchars($lead->lead_id, ENT_QUOTES, 'UTF-8'); ?>">
                                                <input type="date" name="followup_date" /> <input type="submit" value="Set" />
                                            </form>
                                            <?php
                                        } else {
                                            if (strtotime($lead->next_followup_date) > strtotime(date("Y/m/d"))) {
                                                ?>
                                                <label> <?php echo $lead->next_followup_date; ?></label>
                                            <?php } else { ?>
                                                <form method="post" action="<?php echo URL; ?>counseller/addfollowupaction/<?php echo htmlspecialchars($lead->lead_id, ENT_QUOTES, 'UTF-8'); ?>">
                                                    <div class="form-group-sm form-inline">
                                                        <input class="form-control" type="date" name="followup_date" /> 
                                                        <input class="btn btn-danger" type="submit" value="Set" />
                                                    </div>
                                                </form>
                                                <?php
                                            }
                                        }
                                    }
                                    ?></td>
                                <td><button onclick="viewFollowups(this)" lead-id="<?php echo $lead->lead_id; ?>" class="btn btn-toolbar btn-block"><?php echo $lead->followupcount; ?></button></td>
                                <td><a href="<?php echo URL . 'counseller/editlead/' . htmlspecialchars($lead->lead_id, ENT_QUOTES, 'UTF-8'); ?>"><button class="btn btn-info btn-block">Edit</button></a></td>
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
                    <div id="model-body" class="modal-body">
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
