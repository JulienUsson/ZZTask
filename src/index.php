<?php include('classes/authentification.php');
      session_start();
      $auth=new Authentification();?>

<?php if(!$auth->is_connected()) header('Location: ./login.php'); else { ?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZZTask</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">ZZTask</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="./deconnexion.php">Déconnexion</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-danger">
            <div class="panel-heading">A faire</div>
              <table class="table">
                <tr>
                  <td>test</td>
                  <td>test</td>
                  <td>test</td>
                </tr>
              </table>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-warning">
            <div class="panel-heading">En cours</div>
              <table class="table">
                <tr>
                  <td>test</td>
                  <td>test</td>
                  <td>test</td>
                </tr>
              </table>
          </div>
        </div>
        <div class="col-md-4">
          <div class="panel panel-success">
            <div class="panel-heading">Terminée</div>
            <table class="table">
              <tr>
                <td>test</td>
                <td>test</td>
                <td>test</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>

<<?php } ?>
