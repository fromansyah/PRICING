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

function delete_menu(id, menu) {
  i = confirm('Delete Menu : ' + menu + ' ?');
  if (i) {
    window.location = _base_url + 'index.php/menu_item/delete/' + id;
  }
}

function edit_menu(id) {
  window.location = _base_url + 'index.php/menu_item/edit/' + id;
}

</script>

<br/>
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
            <span style="text-shadow: 1px 1px 1px #a6a9b6;"><font color="#00688B" size="4"><b>Menu Item : <?=$menu?></b></font></span>
            <input type="button" value="Add"
                onclick="window.location = '<?= base_url() ?>index.php/menu_item/add/<?=$menu_id?>'" class="button_add"/>
            <input type="button" value="Back To Menu Management"
                onclick="window.location = '<?= base_url() ?>index.php/menu'" class="button_back"/>
            <br/>
            <br/>
            <table id="flex1" style="display:none"></table>
        </td>
    </tr>
</table>  
