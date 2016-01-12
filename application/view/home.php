<!DOCTYPE HTML>
<html>
    <head>
        <title>LibraryExpress</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="<?php echo URL; ?>js/jquery-1.11.2.min.js"></script>
        <script src="<?php echo URL; ?>js/bootstrap.min.js"></script>
        <script src="<?php echo URL; ?>js/jquery.noty.packaged.min.js"></script>
        <script>
            $(function () {
                if (<?php echo $fail; ?>) {
                    showNotification("Login failed")
                }
            });
            function showNotification(message) {
                noty({text: message,
                    type: 'error',
                    timeout: true,
                    animation: {
                        open: {height: 'toggle'},
                        close: {height: 'toggle'},
                        easing: 'swing',
                        speed: 1000
                    }});
            }
        </script>
        <link rel="stylesheet" href="<?php echo URL; ?>css/bootstrap.min.css">
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="">LMS</a>
                </div>
                <div>
                    <ul class="nav navbar-nav navbar-right">
                    </ul>
                </div>
            </div>
        </nav>
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <form role="form" action="<?php echo URL; ?>home/login" method="post">
                    <div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="login_pwd">Password:</label>
                            <input type="password" class="form-control" id="login_pwd" name="password" required>
                        </div>
                        <div>
                            <label for="login_pwd">Type:</label>
                            <ul class="list-group">
                                <li class="list-group-item"><input checked type="radio" name="type" value="0"/> Admin</li> 
                                <li class="list-group-item"><input type="radio" name="type" value="1" /> Counseller</li>
                            </ul>
                        </div>

                        <button type="submit"  class="btn btn-default btn-block"> Login</button>
                    </div>
                </form>
            </div>
        </div>


    </body>
</html>