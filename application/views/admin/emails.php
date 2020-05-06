<?php $this->load->view('inc/common_header') ?>
<body>
  <?php $this->load->view("inc/header_nav");?>
<div class="container">    
    <div class="page-header">
        <h1>Manage Emails</h1>
    </div> 
      <div id="myDIV" style="display: block;">
             <form name="save_seller_form" id="save_seller_form" method="POST" enctype="multipart/form-data">
                <div class="col-sm-6 form-group">
                    <label for="username">Email:</label>
                    <input type="email" class="form-control" id="email" onblur="code_check(this.value)" name="email" placeholder="Enter Emails" required="required">
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
                <th class="priority-5" style="width:30%;">E-mail Id</th> 
                <th class="priority-7" style="width:30%;">Status</th> 
            </tr>
        </thead> 
        <tbody>
            <?php if(count($emails)>0){
                $i=1;
                foreach($emails as $user){ ?>
                    <tr>
                        <td class="priority-1" style="width:30%;"><?php echo $i++; ?></td> 
                        <td class="priority-4" style="width:30%;"><?php echo $user->email; ?></td> 
                        <td class="priority-7"  style="width:30%;vertical-align:middle;"><button type="button" id="b1<?php echo $user->id; ?>" class="btn <?php echo $user->active?'btn-info':'btn-danger'; ?>" onclick="change_state(<?php echo $user->id; ?>)"><span id="stateus_sp_<?php echo $user->id; ?>"><?php echo $user->active?'Active':'Inactive';?></span></button></td> 
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
            url: "<?php echo base_url()?>admin/dashboard/check_email",
            data:{code:name},
            success:function(data){
                if(data.count){
                    alert("Duplicate Email! try again");
                    $('#email').val('');
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
            url: "<?php echo base_url()?>admin/dashboard/change_status_mail",
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
</script>
</html>