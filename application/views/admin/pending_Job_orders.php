<?php $this->load->view('inc/common_header') ?>

<body>

 <?php $this->load->view("inc/header_nav");?>
  
<div class="container">    
    <div class="page-header">
        <h1>Welcome To The Pending!</h1>
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
                        <?php if(count($pending)>0){
                            $i=1;
                            foreach($pending as $pending){ ?>
                                <tr>
                                    <td class="priority-1" style="width:30%;"><?php echo $i++; ?></td>
                                    <td class="priority-2" style="width:30%;"><?php echo $pending->title; ?></td>  
                                    <td class="priority-8" style="width:30%;vertical-align:middle;"><button type="button" class="btn btn-info" onclick="alert('Please check the jo and Update');" data-toggle="modal" data-target="#modal_edit">Pending Job Orders</button></td> 
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

</body> 
</html>