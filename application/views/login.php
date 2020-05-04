
<!DOCTYPE html>
<html lang="en">
<?php
$this->load->view('inc/header');
?>
<body>
     
    <div id="logreg-forms">
        <form class="form-signin" method="post">
            <?php
    if ($this->session->flashdata('error')) {
        ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong style="color: #a94442;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></strong> <span
                    style="color: #a94442;"><?= $this->session->flashdata('error') ?></span>
        </div>
        <?php
    } 
    ?>
            <h1 class="h3 mb-3 font-weight-normal" style="color:white;text-align: center"> Sign in</h1>
          
            <p style="text-align:center"></p>
            <input type="text" id="username" name="username" class="form-control" placeholder="user id" required="" autofocus="">
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required="">
            
            <button class="btn btn-success btn-block" type="submit"><i class="fas fa-sign-in-alt"></i> Sign in</button>
           <!--  <a href="#" id="forgot_pswd">Forgot password?</a> -->
          
            </form>

            
    </div>

    <script src="<?=base_url('assets/')?>/jquery/jquery.min.js"></script>
    <script src="<?=base_url('assets/')?>/js/bootstrap.min.js" ></script>
   
</body>
</html>