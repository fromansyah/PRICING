<link href="<?=$this->config->item('base_url');?>css/style.css" rel="stylesheet" type="text/css" />
<link href="<?=$this->config->item('base_url');?>css/flexigrid.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= base_url() ?>js/datetimepicker_css.js"></script>

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
        <h2 style="margin-top:0px">Asset Management</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('Asset/add'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <form action="<?php echo site_url('Asset/search'); ?>" class="form-inline" method="post">
                    <input name="keyword" class="form-control" value="<?php echo $keyword; ?>" />
                    <?php 
                    if ($keyword <> '')
                    {
                        ?>
                        <a href="<?php echo site_url('Asset'); ?>" class="btn btn-default">Reset</a>
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
		<th style="text-align:center" bgcolor="#428bca"><font color="white">Barcode</font></th>
		<th style="text-align:center" bgcolor="#428bca"><font color="white">Name</font></th>
		<th style="text-align:center" bgcolor="#428bca"><font color="white">Category</font></th>
		<th style="text-align:center" bgcolor="#428bca"><font color="white">Department</font></th>
		<th style="text-align:center" bgcolor="#428bca"><font color="white">Employee</font></th>
		<th style="text-align:center" bgcolor="#428bca"><font color="white">Status</font></th>
		<th style="text-align:center" bgcolor="#428bca"><font color="white">Action</font></th>
            </tr><?php
            foreach ($asset_data as $asset)
            {
                ?>
                <tr>
			<td><?php echo $asset->asset_id ?></td>
			<td><?php echo $asset->barcode ?></td>
			<td><?php echo $asset->name ?></td>
			<td><?php echo $asset->category ?></td>
			<td><?php echo $asset->dept_name ?></td>
			<td><?php echo $asset->emp_name ?></td>
			<td><?php 
                                $status = 'Available';
                                if($asset->status == 'N'){
                                    $status = 'Unavailable';
                                }elseif($asset->status == 'D'){
                                    $status = 'Disposed Off';
                                }
                                
                                echo '['.$asset->status.'] '.$status;
                            ?></td>
			<td style="text-align:center">
				<?php 
                                $button = '';
                                if($asset->status == 'A'){
                                    $button = '<a href=\'#\' onclick="edit_asset(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/b_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                                          '<a href=\'#\' onclick="put_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/green-location-icons-17.png\'></a>'.'&nbsp&nbsp&nbsp'.
                                          '<a href=\'#\' onclick="view_depreciation(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/081_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                                          '<a href=\'#\' onclick="view_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/locations.png\'></a>'.'&nbsp&nbsp&nbsp'.
                                          '<a href=\'#\' onclick="dispose(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/trash_icon_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                                          '<a href=\'#\' onclick="delete_asset(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/Delete.png\'></a>';
                                }elseif($asset->status == 'N'){
                                    $button = '<a href=\'#\' onclick="edit_asset(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/b_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                                          '<a href=\'#\' onclick="return_asset(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/return.jpg\'></a>'.'&nbsp&nbsp&nbsp'.
                                          '<a href=\'#\' onclick="view_depreciation(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/081_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                                          '<a href=\'#\' onclick="view_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/locations.png\'></a>'.'&nbsp&nbsp&nbsp'.
                                          '<a href=\'#\' onclick="delete_asset(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/Delete.png\'></a>';
                                }elseif($asset->status == 'D'){
                                    $button = '<a href=\'#\' onclick="edit_asset(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/b_edit.png\'></a>'.'&nbsp&nbsp&nbsp'.
                                          '<a href=\'#\' onclick="view_depreciation(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/081_a.png\'></a>'.'&nbsp&nbsp&nbsp'.
                                          '<a href=\'#\' onclick="view_location(\''.$asset->asset_id.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/locations.png\'></a>'.'&nbsp&nbsp&nbsp'.
                                          '<a href=\'#\' onclick="delete_asset(\''.$asset->asset_id.'\''.',\''.$asset->name.'\')"><img border=\'0\' src=\''.$this->config->item('base_url').'images/Delete.png\'></a>';
                                }
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