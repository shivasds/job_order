<script type="text/javascript"> var base_url = "<?= base_url() ?>" </script>
<?php

if($this->session->userdata('user_type')==1)
  {
    ?>
    <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?=base_url();?>">Job Orders</a>
    </div>
    <?php
    $segment = $this->uri->segment('3');
    ?>
    <ul class="nav navbar-nav">
      <li class="<?php if($segment==""){ echo 'active';}?>"><a href="<?=base_url('admin/dashboard');?>">Home</a></li>
      <li class="<?php if($segment=="employees"){ echo 'active';}?>"><a href="<?=base_url('admin/dashboard/employees');?>">Empolyees</a></li>
      <li class="<?php if($segment=="clients"){ echo 'active';}?>"><a href="<?=base_url('admin/dashboard/clients');?>">Clients</a></li>
      <li class="<?php if($segment=="new_Job_orders"){ echo 'active';}?>"><a href="<?=base_url('admin/dashboard/new_Job_orders');?>">New Job Orders</a></li> 
      <li class="<?php if($segment=="pending_Job_orders"){ echo 'active';}?>"><a href="<?=base_url('admin/dashboard/pending_Job_orders');?>">Pending Job Orders</a></li>
      <li class="<?php if($segment=="finished_Job_orders"){ echo 'active';}?>"><a href="<?=base_url('admin/dashboard/finished_Job_orders');?>">Finshed Job Orders</a></li>
      <li><a href="<?=base_url('logout');?>">Logout</a></li>
    </ul>
  </div>
</nav>
<?php
}
elseif($this->session->userdata('user_type')==2)
{
  ?>
   <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?=base_url();?>">Job Orders</a>
    </div>
    <?php
    $segment = $this->uri->segment('3');
    ?>
    <ul class="nav navbar-nav">
      <li class="<?php if($segment==""){ echo 'active';}?>"><a href="<?=base_url('employee/dashboard');?>">Home</a></li>
      <li class="<?php if($segment=="new_Job_orders"){ echo 'active';}?>"><a href="<?=base_url('employee/dashboard/new_Job_orders');?>">New Job Orders</a></li> 
      <li class="<?php if($segment=="pending_Job_orders"){ echo 'active';}?>"><a href="<?=base_url('employee/dashboard/pending_Job_orders');?>">Pending Job Orders</a></li>
      <li class="<?php if($segment=="finished_Job_orders"){ echo 'active';}?>"><a href="<?=base_url('employee/dashboard/finished_Job_orders');?>">Finshed Job Orders</a></li>
      <li><a href="<?=base_url('logout');?>">Logout</a></li>
    </ul>
  </div>
</nav>
  <?php
}
else
{
  ?>
 <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?=base_url();?>">Job Orders</a>
    </div>
    <?php
    $segment = $this->uri->segment('3');
    ?>
    <ul class="nav navbar-nav">
      <li class="<?php if($segment==""){ echo 'active';}?>"><a href="<?=base_url('client/dashboard');?>">Home</a></li>
      <li class="<?php if($segment=="new_Job_orders"){ echo 'active';}?>"><a href="<?=base_url('client/dashboard/new_Job_orders');?>">New Job Orders</a></li> 
      <li class="<?php if($segment=="pending_Job_orders"){ echo 'active';}?>"><a href="<?=base_url('client/dashboard/pending_Job_orders');?>">Pending Job Orders</a></li>
      <li class="<?php if($segment=="finished_Job_orders"){ echo 'active';}?>"><a href="<?=base_url('client/dashboard/finished_Job_orders');?>">Finshed Job Orders</a></li>
      <li><a href="<?=base_url('logout');?>">Logout</a></li>
    </ul>
  </div>
</nav>
  <?php
}