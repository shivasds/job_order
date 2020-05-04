

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=base_url('assets/')?>/css/bootstrap.min.css" >
    <link rel="stylesheet" href="<?=base_url('assets/')?>/style.css">
    <title>Login</title>
</head>
<body>
    <div id="logreg-forms">
        <form class="form-signin">
            <h1 class="h3 mb-3 font-weight-normal" style="color:white;text-align: center"> Sign in</h1>
          
            <p style="text-align:center"></p>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
            
            <button class="btn btn-success btn-block" type="submit"><i class="fas fa-sign-in-alt"></i> Sign in</button>
            <a href="#" id="forgot_pswd">Forgot password?</a>
          
            </form>

            
    </div>

    <script src="<?=base_url('assets/')?>/jquery/jquery.min.js"></script>
    <script src="<?=base_url('assets/')?>/js/bootstrap.min.js" ></script>
   
</body>
</html>