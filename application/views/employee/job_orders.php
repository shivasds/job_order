<?php $this->load->view('inc/common_header') ?>

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
                            <th class="priority-9" style="width:30%;">More</th>  
                        </tr>
                    </thead> 
                    <tbody>
                        <?php if(count($new)>0){
                            $i=1;
                            foreach($new as $new){ ?>
                                <tr>
                                    <td class="priority-1" style="width:30%;"><?php echo $i++; ?></td>
                                    <td class="priority-2" style="width:30%;"><?php echo $new->title; ?></td>  
                                    <td class="priority-8" style="width:30%;vertical-align:middle;"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal_edit" onclick="edit('<?php echo $new->id; ?>')">More</button></td> 
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
    $('#mhid').val(v); 

        $.ajax({
            type:"POST",
            url: "<?php echo base_url()?>employee/dashboard/get_job_order_details",
            data:{id:v},
            success:function(data){
               $("#m_down").attr("href", "download_files?id="+v);
              // $("#m_down").attr('target','_blank')
             // box.val();
               var box = $("#m_pre_data");
                box.val(data);
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
        <input type="hidden" name="m_emp" id="m_emp" value="<?=$this->session->userdata('id')?>">
                <div class="col-md-6 form-group">        
                <label for="p_note">Previous Note:</label>
                <textarea class="form-control" rows="5" id="m_pre_data" name="m_pre_data" readonly=""></textarea>
                </div>
                <div class="col-md-6 form-group">        
                <label for="note">Note:</label>
                <textarea class="form-control" rows="5" id="m_notes" name="m_notes"></textarea>
                </div>
                <div class="col-md-6 form-group">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status" required="required">
                        <option value="">Select</option>
                        <option value="1">review</option>

                      </select>
                </div>
                <div class="col-md-12 form-group">         
                  <!-- <input type="button" onclick="download_files();" name="" value="Download All Files"> -->
                  <a href="" id="m_down"><button>Download Files</button></a>
                </div>
      <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="update_jo();" class="btn btn-primary">Update</button>
      </div>
    </div>
  </div>
</div>
<script>
 function update_jo()
  {
    if($("#status").val()=='')
    {
      $("#status").focus();
      alert("Please Select Status Of the Job Order");
      return false;
    }
    if($("#m_notes").val()=='')
    {
      $("#m_notes").focus();
      alert("Please Enter Notes!");
      return false;
    }
    var data = {
            'id':$('#mhid').val(),
            'emp_id':$('#m_emp').val(),
            'notes':$('#m_notes').val(),
            'status':$('#status').val()
          }
          $.ajax({
            type:"POST",
            url: "<?php echo base_url()?>employee/dashboard/edit_job_order_deatails",
            data:data,
            success:function(data){
                location.reload();
            }
        });
  }
  function download_files() {
    var data = {
            'id':$('#mhid').val(), 
          }
          //alert($('#mhid').val());
          $.ajax({
            type:"POST",
            url: "<?php echo base_url()?>employee/dashboard/get_job_order_details",
            data:data,
            success:function(response){
               if(response.zip) {
            location.href = response.zip;
        }
            }
        });
  }
</script>
</body> 
</html>