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
                    <a class="navbar-brand" href="">LMS</a>
                </div>
                <div>
                    <ul class="nav navbar-nav navbar-left">
                        <li> <a href="<?php echo URL; ?>admin/counsellerreport" >Counseller</a></li>
                        <li > <a  href="<?php echo URL; ?>admin/activeleadreport">Active Lead</a></li>
                        <li class="active"> <a href="<?php echo URL; ?>admin/statusreport" >Status</a></li>
                        <li> <a href="<?php echo URL; ?>admin/customizedreport" >Customized</a></li>
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
            <div class="col-sm-8 col-sm-offset-2">
                <canvas id="canvas" height="360" width="600"></canvas>
            </div>

        </div>
        <script>
            $(function () {
                $.post("<?php echo URL; ?>admin/statusreportdata", function (data) {
                    console.log(data);
                    var statuslist = data.map(function (a) {
                        return a.status;
                    });
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
            });
        </script>


    </body>
</html>