<link href="<?=$this->config->item('base_url');?>css/style.css" rel="stylesheet" type="text/css" />
<link href="<?=$this->config->item('base_url');?>css/flexigrid.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= base_url() ?>js/datetimepicker_css.js"></script>
<script type="text/javascript" src="<?=$this->config->item('base_url');?>js/flexigrid.pack.js"></script>
<script type="text/javascript" src="<?=$this->config->item('base_url');?>js/jquery.dataTables.min.js"></script>
<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">

<?
echo $js_grid;
?>

<script type="text/javascript">
var _base_url = '<?= base_url() ?>';

function doCommand(com,grid)
{
    if (com=='Select All')
    {
        $('.bDiv tbody tr',grid).addClass('trSelected');
    }

    if (com=='DeSelect All')
    {
        $('.bDiv tbody tr',grid).removeClass('trSelected');
    }
    
    if (com == 'Back') {
      window.location = _base_url + 'Asset';
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
    </tr>
</table>  
