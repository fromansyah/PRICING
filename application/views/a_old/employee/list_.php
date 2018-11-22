<link href="<?=$this->config->item('base_url');?>css/style.css" rel="stylesheet" type="text/css" />
<link href="<?=$this->config->item('base_url');?>css/flexigrid.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= base_url() ?>js/datetimepicker_css.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/bootstrap/css/bootstrap.min.js"></script>

<script type="text/javascript" src="<?=$this->config->item('base_url');?>js/flexigrid.pack.js"></script>
<script type="text/javascript" src="<?=$this->config->item('base_url');?>js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    
var _base_url = '<?= base_url() ?>';

function delete_asset(id, asset) {
  i = confirm('Delete Menu : ' + asset + ' ?');
  if (i) {
    window.location = _base_url + 'Asset/delete/' + id;
  }
}

function edit_asset(id) {
  window.location = _base_url + 'Asset/edit/' + id;
}

function view_depreciation(asset_id) {
  window.location = _base_url + 'Depreciation/lists/' + asset_id;
}

function view_location(asset_id) {
  window.location = _base_url + 'Asset_location/lists/' + asset_id;
}

function put_location(asset_id) {
  window.location = _base_url + 'Asset_location/add/' + asset_id;
}

function return_asset(asset_id) {
  window.location = _base_url + 'Asset_location/get_return_asset/' + asset_id;
}

function doCommand(com,grid)
{
    if (com == 'Add') {
      window.location = _base_url + 'Asset/add';
    }
    
    if (com=='Select All')
    {
        $('.bDiv tbody tr',grid).addClass('trSelected');
    }

    if (com=='DeSelect All')
    {
        $('.bDiv tbody tr',grid).removeClass('trSelected');
    }
}

</script>

<html>
    <head>
        <title>FIX ASSET</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>

    </head>
    <body>
        <h2 style="margin-top:0px">Employee Management</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <form action="<?php echo site_url('Employee/search'); ?>" class="form-inline" method="post">
                    <input name="keyword" class="form-control" value="<?php echo $keyword; ?>" />
                    <?php 
                    if ($keyword <> '')
                    {
                        ?>
                        <a href="<?php echo site_url('Employee'); ?>" class="btn btn-default">Reset</a>
                        <?php
                    }
                    ?>
                    <input type="submit" value="Search" class="btn btn-primary" />
                </form>
            </div>
        </div>
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th style="text-align:center" bgcolor="#428bca"><font color="white">ID</font></th>
		<th style="text-align:center" bgcolor="#428bca"><font color="white">Emp. Initial</font></th>
		<th style="text-align:center" bgcolor="#428bca"><font color="white">Emp. Name</font></th>
		<th style="text-align:center" bgcolor="#428bca"><font color="white">Nickname</font></th>
		<th style="text-align:center" bgcolor="#428bca"><font color="white">Email</font></th>
		<th style="text-align:center" bgcolor="#428bca"><font color="white">Status</font></th>
		<th style="text-align:center" bgcolor="#428bca"><font color="white">Action</font></th>
            </tr><?php
            foreach ($employee_data as $employee)
            {
                ?>
                <tr>
			<td><?php echo $employee->EMPLOYEE_ID ?></td>
			<td><?php echo $employee->EMP_INITIAL ?></td>
			<td><?php echo $employee->FIRST_NAME.' '.$employee->MIDDLE_NAME.' '.$employee->LAST_NAME ?></td>
			<td><?php echo $employee->NICKNAME ?></td>
			<td><?php echo $employee->EMAIL ?></td>
			<td><?php 
                                $status = '';
                                if($employee->RECORD_STATUS == 'A'){
                                    $status = 'Active';
                                }elseif($employee->RECORD_STATUS == 'D'){
                                    $status = 'Non Active';
                                }
                                
                                echo '['.$employee->RECORD_STATUS.'] '.$status;
                            ?></td>
			<td style="text-align:center">
				<?php 
                                $button = '<a href=\'#\' onclick="view_depreciation(\''.$employee->EMPLOYEE_ID.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/view.jpg\'></a>'.'&nbsp&nbsp&nbsp';
                                echo $button;
				?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div> 
    </body>
</html>