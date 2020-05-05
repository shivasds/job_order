<?php $this->load->view('inc/common_header') ?>

<body>

 <?php $this->load->view("inc/header_nav");?>
  
<div class="container">    
    <div class="page-header">
        <h1>Welcome To The Finished!</h1>
    </div>  
</div>
<div class="container">
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="priority-1" style="width:30%;">No</th>
                            <th class="priority-2" style="width:30%;">Title</th> 
                            <th class="priority-9" style="width:30%;">Approval</th>  
                        </tr>
                    </thead> 
                    <tbody>
                        <?php if(count($finished)>0){
                            $i=1;
                            foreach($finished as $finished){ ?>
                                <tr>
                                    <td class="priority-1" style="width:30%;"><?php echo $i++; ?></td>
                                    <td class="priority-2" style="width:30%;"><?php echo $finished->title; ?></td>  
                                    <td class="priority-8" style="width:30%;vertical-align:middle;"><button type="button" class="btn btn-info" onclick="alert('Congratulations! This Job Order Successfully Completed');" data-toggle="modal" data-target="#modal_edit">Finished Job Order</button></td> 
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