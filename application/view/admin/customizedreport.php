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
        <script src="<?php echo URL; ?>js/Chart.js"></script>

    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?php echo URL . 'admin' ?>">LMS</a>
                </div>
                <div>
                    <ul class="nav navbar-nav navbar-left">
                        <li> <a href="<?php echo URL; ?>admin/counsellerreport" >Counseller</a></li>
                        <li > <a  href="<?php echo URL; ?>admin/activeleadreport">Active Lead</a></li>
                        <li> <a href="<?php echo URL; ?>admin/statusreport" >Status</a></li>
                        <li class="active"> <a href="<?php echo URL; ?>admin/customizedreport" >Customized</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <!--<li><a href=""> <?php echo $counsellerDetail->counseller_username; ?></a></li>-->
                        <li> <a href="<?php echo URL . 'admin' ?>">Manage Counseller</a></li>
                        <li><a href="<?php echo URL . 'counseller/logout' ?>"> Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="row">
            <div class="col-sm-4 col-sm-offset-2">
                <div class="form-group">
                    <label>Semester Wise</label>
                    <select class="form-control" id="semester-select" onchange="semesterwisereport(this)">
                        <?php foreach ($intakes as $intake) {
                            ?>
                            <option value="<?php echo $intake->intake_id; ?>">
                                <?php echo $intake->intake_name; ?> (<?php echo $intake->intake_start_date; ?>)
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Counseller Wise</label>
                    <select class="form-control" id="counseller-select" onchange="counsellerwisereport(this)">
                        <?php foreach ($counsellers as $counseller) {
                            ?>
                            <option value="<?php echo $counseller->counseller_id; ?>">
                                <?php echo $counseller->counseller_username; ?> 
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <canvas id="canvas" height="360" width="600"></canvas>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <label id="reporttype"></label>
                </div>
            </div>

            <script>
                $(function () {
                    statuslist = ['Active', 'Expired', 'Not interested', 'Postponed'];
                    semesterwisereport = function (item) {
                        $('#reporttype').html("Report By Semester");
                        $.post("<?php echo URL; ?>admin/customizedreportdata", {
                            "type": 1,
                            "intake_id": $(item).val()
                        }, function (data) {
                            console.log(data);
//                            var statuslist = data.map(function (a) {
//                                return a.status;
//                            });
                            var leadlist = data.map(function (a) {
                                return a.no_of_leads;
                            });

                            var barChartData = {
                                labels: statuslist,
                                datasets: [{
                                        fillColor: "rgba(220,220,220,0.5)",
                                        strokeColor: "rgba(220,220,220,0.8)",
                                        highlightFill: "rgba(220,220,220,0.75)",
                                        highlightStroke: "rgba(220,220,220,1)",
                                        data: leadlist
                                    }]



                            }
                            var ctx = document.getElementById("canvas").getContext("2d");
                            window.myBar = new Chart(ctx).Bar(barChartData, {
                                responsive: true
                            });

                        });
                    }

                    counsellerwisereport = function (item) {
                        $('#reporttype').html("Report By Counseller");
                        $.post("<?php echo URL; ?>admin/customizedreportdata", {
                            "type": 0,
                            "counseller_id": $(item).val()
                        }, function (data) {
                            console.log(data);
//                            var statuslist = data.map(function (a) {
//                                return a.status;
//                            });
                            var leadlist = data.map(function (a) {
                                return a.no_of_leads;
                            });

                            var barChartData = {
                                labels: statuslist,
                                datasets: [{
                                        fillColor: "rgba(220,220,220,0.5)",
                                        strokeColor: "rgba(220,220,220,0.8)",
                                        highlightFill: "rgba(220,220,220,0.75)",
                                        highlightStroke: "rgba(220,220,220,1)",
                                        data: leadlist
                                    }]



                            }
                            var ctx = document.getElementById("canvas").getContext("2d");
                            window.myBar = new Chart(ctx).Bar(barChartData, {
                                responsive: true
                            });

                        });
                    }
                    semesterwisereport($('#counseller-select'));
                });
            </script>
    </body>
</html>