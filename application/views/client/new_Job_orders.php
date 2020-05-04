<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=$title?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="<?=base_url('assets/jquery')?>/jquery.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="<?=base_url('assets/css/')?>custom.css">

  <link href='<?= base_url() ?>resources/dropzone.css' type='text/css' rel='stylesheet'>
    <script src='<?= base_url() ?>resources/dropzone.js' type='text/javascript'></script>
<style>
  .content{
    width: 50%;
    padding: 5px;
    margin: 0 auto;
  }
  .content span{
    width: 250px;
  }
  .dz-message{
    text-align: center;
    font-size: 28px;
  }
  </style>
  <script type="text/javascript">
var base_url = "<?=base_url()?>";

   Dropzone.autoDiscover = false;

   $(document).ready(function () {
        $("#images").dropzone({
            maxFiles: 2000,
            url: base_url+"/client/dashboard/new_Job_orders",
            success: function (file, response) {
                console.log(response);
            }
        });
   })

</script>
</head>

<body>

 <?php $this->load->view("inc/header_nav");?>
  
<div class="container">    
    <div class="page-header">
        <h1>New Job Order</h1>
    </div> 
      <div id="myDIV" style="display: block;">
             <form method="post" enctype="multipart/form-data" >
                <div class="col-md-6 form-group">
                    <label for="order_type">Job Type:</label>
                    <select class="form-control" id="order_type" name="order_type" required="required">
                        <option value="">Select</option>
                        <?php
                        foreach($job_order_type as $ord_type)
                        {
                          ?>
                          <option value="<?=$ord_type->id?>"><?=$ord_type->order_type?></option>
                          <?php
                        }
                        ?>

                      </select>
                </div>
                <div class="col-sm-6 form-group">
                     <?php $this->load->view("inc/dropzone");?>
                </div>                
                <div class="col-md-6 form-group">
                    <label for="city_id">City:</label>
                    <select class="form-control" id="user_type" name="city_id">
                        <option value="">Select</option>
                        <?php
                        foreach($cities as $city)
                        {
                          ?>
                          <option value="<?=$city->id?>"><?=$city->city_name?></option>
                          <?php
                        }
                        ?>

                      </select>
                </div>

                <button type="submit" id="add_user" class="btn btn-success btn-block" >Submit</button>
            </form>
      </div>
    </div>
    <br><br>
    <div class="container">
     
</div>

</body> 
</html>