<link href="<?=$this->config->item('base_url');?>css/style.css" rel="stylesheet" type="text/css" />
<link href="<?=$this->config->item('base_url');?>css/flexigrid.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= base_url() ?>js/datetimepicker_css.js"></script>

<script type="text/javascript" src="<?=$this->config->item('base_url');?>js/flexigrid.pack.js"></script>
<script type="text/javascript" src="<?=$this->config->item('base_url');?>js/jquery.dataTables.min.js"></script>
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
    <script type="text/javascript" src="<?=$this->config->item('base_url');?>js/numeral.min.js"></script>

<?
echo $js_grid;
?>

<script type="text/javascript">
var _base_url = '<?= base_url() ?>';

function delete_role(id, role) {
  i = confirm('Delete Role : ' + role + ' ?');
  if (i) {
    window.location = _base_url + 'Role/delete/' + id;
  }
}

function edit_role(id) {
  window.location = _base_url + 'Role/edit/' + id;
}

function view_role(id) {
  window.location = _base_url + 'Role_menu/lists/' + id;
}



function doCommand(com,grid)
{
    if (com == 'Add') {
      window.location = _base_url + 'Role/add';
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

$(function(){
  
});
</script>
</p>
<br/>
<br/>
<br/>
<br/>
<table>
    <tr>
        <td width="6"></td>
        <td width="230" valign="top">
        </td>
        <td width="1076">
            <table id="flex1" style="display:none"></table>
        </td>
        <td><? // print_r($test)?></td>
    </tr>
</table>  
