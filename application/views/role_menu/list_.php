<link href="<?=$this->config->item('base_url');?>css/style.css" rel="stylesheet" type="text/css" />
<link href="<?=$this->config->item('base_url');?>css/flexigrid.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= base_url() ?>js/datetimepicker_css.js"></script>

<script type="text/javascript" src="<?=$this->config->item('base_url');?>js/flexigrid.pack.js"></script>
<script type="text/javascript" src="<?=$this->config->item('base_url');?>js/jquery.dataTables.min.js"></script>

<?
echo $js_grid;
?>

<script type="text/javascript">
var _base_url = '<?= base_url() ?>';
var $role_id = '<?=$role_id?>';

function delete_role_menu(role_id, menu_item_id, menu) {
  i = confirm('Delete Menu : ' + menu + ' ?');
  if (i) {
    window.location = _base_url + 'Role_menu/delete/' + role_id + '/' + menu_item_id;
  }
}

function edit_role_menu(role_id, menu_item_id) {
  window.location = _base_url + 'Role_menu/edit/' + role_id + '/' + menu_item_id;
}



function doCommand(com,grid)
{
    if (com == 'Add') {
      window.location = _base_url + 'Role_menu/add/'+$role_id;
    }
    
    if (com=='Select All')
    {
        $('.bDiv tbody tr',grid).addClass('trSelected');
    }

    if (com=='DeSelect All')
    {
        $('.bDiv tbody tr',grid).removeClass('trSelected');
    }
    
    if (com == 'Back') {
      window.location = _base_url + 'Role';
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
