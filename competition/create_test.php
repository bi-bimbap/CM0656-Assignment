<!DOCTYPE html>
<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<title>Your Website</title>
<link rel="stylesheet" href="" type="text/css" />
<script type="text/javascript"></script>
</head>

<body>
  <div class ="container">
    <div class ="jumbotron">
      <h1>Create Your Competition</h1>
    </div>
  </div>

  <div class ="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class ="panel panel-primary">
          <div class="panel-heading">Enter Your Test Details</div>
        <div class="panel-body">

          <form>
            <table class="table table-hover">
              <tr>
                <td>Test Name:</td>
                <td><input type="text" class="form-control" name="t_name" placeholder="Test Name"></td>
              </tr>
              <tr>
                <td>Template ID:</td>
                <td><button class= "btn btn-primary dropdown-toggle" name="templateID" type="button" data-toggle="dropdown">Choose your template
                  <span class="caret"></span></button>
                  <ul class= "dropdown-menu">
                    <li></li>
                  </ul>
              </tr>
              <tr>
                <td>Start Date:</td>
                <td><input type="date" class="form-control" name="startDate" placeholder="Start"></td>
              </tr>
              <tr>
                <td>End Date:</td>
                <td><input type="date" class="form-control" name="endDate" placeholder=" End"></td>
              </tr>
              <tr>
                <td>Prize:</td>
                <td><input type="text" class="form-control" name="prize" placeholder="Prize"></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><input type="submit" class="btn btn-primary" name="submit" value="Save"></td>
              </tr>
            </table>
          </form>








</body>
</html>
