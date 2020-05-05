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
  <link rel="stylesheet" href="<?=base_url('assets/css')?>/custom.css">
</head>

<body>

 <?php $this->load->view("inc/header_nav");?>
  
<div class="container">    
    <div class="page-header">
        <h1>Welcome To The New!</h1>
    </div>  
</div>
<div class="container">
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="priority-1" style="width:30%;">No</th>
                            <th class="priority-2" style="width:30%;">Title</th> 
                            <th class="priority-9" style="width:30%;">Pending</th>  
                        </tr>
                    </thead> 
                    <tbody>
                        <?php if(count($new)>0){
                            $i=1;
                            foreach($new as $new){ ?>
                                <tr>
                                    <td class="priority-1" style="width:30%;"><?php echo $i++; ?></td> 
                                    <td class="priority-2" style="width:30%;"><?php echo $new->title; ?></td>  
                                    <td class="priority-8" style="width:30%;vertical-align:middle;"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_edit" onclick="edit('<?php echo $new->id; ?>')">Assign</button></td> 
                                </tr>
                           <?php } 
                        } 
                        else
                          {
                            ?>
                              <tr>
                                    <td class="priority-1" colspan="3" style="text-align: center;">No Data Found</td> 
                                </tr>
                          <?php
                           } ?>

                    </tbody>
                </table>
</div>
<script type="text/javascript">
  function edit(v){
    var j_id = $('#mhid').val(v); 
        $.ajax({
            type:"POST",
            url: "<?php echo base_url()?>admin/dashboard/edit_job_order_deatails",
            data:{id:v},
            success:function(data){
                //$('#mhid').val(v); 
                //alert(j_id);
            }
        });
    }
</script>
</body> 


</html>
<div class="modal fade" id="modal_edit"  role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">Assigning Job Order</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="mhid" id="mhid">
        <div class="col-md-6 form-group">
                    <label for="order_type">Select Employee:</label>
                    <select class="form-control" id="m_emp" name="m_emp" required="required">
                        <option value="">Select</option>
                        <?php
                        foreach($emp as $emp)
                        {
                          ?>
                          <option value="<?=$emp->id?>"><?=$emp->name?></option>
                          <?php
                        }
                        ?>

                      </select>
                </div>
      <div class="col-md-6 form-group">        
                <label for="note">Note:</label>
                <textarea class="form-control" rows="5" id="m_notes" name="m_notes"></textarea>
                </div>
      <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="update_jo();" class="btn btn-primary">Assign</button>
      </div>
    </div>
  </div>
</div>
<script>
 function update_jo()
  {
    var data = {
            'id':$('#mhid').val(),
            'emp_id':$('#m_emp').val(),
            'notes':$('#m_notes').val()
          }
          $.ajax({
            type:"POST",
            url: "<?php echo base_url()?>admin/dashboard/edit_job_order_deatails",
            data:data,
            success:function(data){
                location.reload();
            }
        });
  }
</script>