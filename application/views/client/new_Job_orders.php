<?php $this->load->view('inc/common_header') ?>

<body>

 <?php $this->load->view("inc/header_nav");?>
  
<div class="container">  
        <?php
    if ($this->session->flashdata('success')) {
        ?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong style="color: #3c763d;"><i class="fa fa-save" aria-hidden="true"></i></strong> <span
                    style="color: #3c763d;"><?= $this->session->flashdata('success') ?></span>
        </div>
        <?php
    }
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
    <div class="page-header">
        <h1>New Job Order</h1>
    </div> 
      <div id="myDIV" style="display: block;">
             <form name="save_job_order" id="save_job_order" method="post" enctype="multipart/form-data">
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
                 <div class="col-md-6 form-group">        
                <label for="jo_title">Jor Order Title:</label>
                <input type="text" class="form-control" rows="5" id="jo_title" name="jo_title" value="" required="">
                </div>
                <div class="col-md-6 form-group">        
                <label for="comment">Comment:</label>
                <textarea class="form-control" rows="5" id="comment" name="notes"></textarea>
                </div>
                <input type="hidden" name="client_id" value="<?=$this->session->userdata('id')?>">
                <div class="col-sm-6 form-group">
                    <!-- <label for="images">Required Files:</label> -->
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="control-label">Gallery</label>
                            <div class="">
                                <div class="dropzone gallery">
                                    <div id="hiddenimages" class="hide"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
                
                  <button type="submit" class="btn btn-default" id="submit2" onclick="history.go(-1);" style="visibility: hidden;">Back
                  </button>
                <button type="submit" id="add_user" class="btn btn-success btn-block" >Submit</button>
            </form>
      </div>
    </div>
    <br><br>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/min/dropzone.min.js"></script>

 <script src="<?=base_url('assets/themes')?>/custom.js"></script>

</body> 
</html>