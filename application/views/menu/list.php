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
    window.location = _base_url + 'index.php/Menu/delete/' + id;
  }
}

function edit_menu(id) {
  window.location = _base_url + 'index.php/Menu/edit/' + id;
}

function view_menu(id) {
  window.location = _base_url + 'index.php/Menu_item/lists/' + id;
}

function btn(com,grid)
{
    if (com == 'Add') {
      alert('Add');
    }
    if (com=='Select All')
    {
		$('.bDiv tbody tr',grid).addClass('trSelected');
    }

    if (com=='DeSelect All')
    {
		$('.bDiv tbody tr',grid).removeClass('trSelected');
    }

    if (com=='Delete')
        {
           if($('.trSelected',grid).length>0){
			   if(confirm('Delete ' + $('.trSelected',grid).length + ' items?')){
		            var items = $('.trSelected',grid);
		            var itemlist ='';
		        	for(i=0;i<items.length;i++){
						itemlist+= items[i].id.substr(3)+",";
					}
					$.ajax({
					   type: "POST",
					   url: "<?=site_url("/ajax/deletec");?>",
					   data: "items="+itemlist,
					   success: function(data){
					   	$('#flex1').flexReload();
					  	alert(data);
					   }
					});
				}
			} else {
				return false;
			}
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
