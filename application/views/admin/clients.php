<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=$title?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="<?=base_url('assets/css')?>/custom.css">
</head>
<body>
  <?php $this->load->view("inc/header_nav");?>
<div class="container">    
    <div class="page-header">
        <h1>Manage Clients</h1>
    </div> 
      <div id="myDIV" style="display: block;">
             <form name="save_seller_form" id="save_seller_form" method="POST" enctype="multipart/form-data">
                <div class="col-sm-6 form-group">
                    <label for="username">Client Code:</label>
                    <input type="text" class="form-control" id="username" onblur="code_check(this.value)" name="username" placeholder="Client Username" required="required">
                </div>
                <div class="col-sm-6 form-group">
                    <label for="name">Client name:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Client Name" required="required">
                </div> 
                <div class="col-sm-6 form-group">
                    <label for="email">Email Id:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Client Enter email" required="required">
                </div> 
                <div class="col-sm-6 form-group">
                    <label for="mobile">Mobile Number:</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Client Mobile Number" required="required">
                </div>   
                
                <div class="col-md-6 form-group">
                    <label for="city_id">City:</label>
                    <select class="form-control" id="user_type" name="city_id" required="required">
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

                <button type="submit" id="add_user" class="btn btn-success btn-block" disabled="">Submit</button>
            </form>
      </div>
    </div>
    <br><br>
    <div class="container">
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="priority-1" style="width:30%;">No</th>
                <th class="priority-2" style="width:30%;">Client Code</th>
                <th class="priority-3" style="width:30%;">Client name</th> 
                <th class="priority-5" style="width:30%;">E-mail Id</th> 
                <th class="priority-7" style="width:30%;">Status</th>
                <th class="priority-8" style="width:30%;">Edit</th>
                <th class="priority-9" style="width:30%;">Change Password</th>  
            </tr>
        </thead> 
        <tbody>
            <?php if(isset($all_user)){
                $i=1;
                foreach($all_user as $user){ ?>
                    <tr>
                        <td class="priority-1" style="width:30%;"><?php echo $i++; ?></td>
                        <td class="priority-2" style="width:30%;"><?php echo $user->username; ?></td>
                        <td class="priority-3" style="width:30%;"><?php echo $user->name; ?></td>
                        <td class="priority-4" style="width:30%;"><?php echo $user->email; ?></td> 
                        <td class="priority-7"  style="width:30%;vertical-align:middle;"><button type="button" id="b1<?php echo $user->id; ?>" class="btn <?php echo $user->active?'btn-info':'btn-danger'; ?>" onclick="change_state(<?php echo $user->id; ?>)"><span id="stateus_sp_<?php echo $user->id; ?>"><?php echo $user->active?'Active':'Inactive';?></span></button></td>
                        <td class="priority-8" style="width:30%;vertical-align:middle;"><button type="button" class="btn btn-info" onclick="edit_user(<?php echo $user->id; ?>)" data-toggle="modal" data-target="#modal_edit">Edit</button></td>
                        <td class="priority-9" style="width:30%;vertical-align:middle;"><button type="button" class="btn btn-info" onclick="reset_password(<?php echo $user->id; ?>)">Reset Password</button></td>
                    </tr>
                <?php } 
            } ?>

        </tbody>
    </table>
</div>

</body>
<script>
  function code_check(name){ 
        $(".se-pre-con").show();
        $.ajax({
            type:"POST",
            url: "<?php echo base_url()?>admin/dashboard/check_user",
            data:{code:name},
            success:function(data){
                if(data.count){
                    alert("Duplicate Code! try again");
                    $('#username').val('');
                }
                else
                    $('#add_user').prop('disabled', false);
                $(".se-pre-con").hide("slow");
            }
        });
    }
    function change_state(id){
        $(".se-pre-con").show();
        $.ajax({
            type:"POST",
            url: "<?php echo base_url()?>admin/dashboard/change_status_user",
            data:{id:id},
            success:function(data) {
                if(data.active){
                    $('#stateus_sp_'+id).text('Active');
                    $('#b1'+id).removeClass("btn-danger");
                    $('#b1'+id).addClass("btn-info");
                }else{
                    $('#stateus_sp_'+id).text('Inactive');
                    $('#b1'+id).removeClass("btn-info");
                    $('#b1'+id).addClass("btn-danger");
                }
                $(".se-pre-con").hide("slow");
            }
        });
    }
    function reset_password(id){
        $(".se-pre-con").show();
        $.get("<?php echo base_url()?>admin/dashboard/reset_password/"+id,function(response){
            $(".se-pre-con").hide("slow");
            if(response.status)
                alert("Success");
        })
    }
</script>
</html>