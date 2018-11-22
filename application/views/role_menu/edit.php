<script type="text/javascript">

$_base_url = '<?= base_url() ?>';

var $role_id;
var $menu_item_id;

$(document).ready(function(){

  $role_id = $('#role_id')[0];
  $menu_item_id = $('#menu_item_id')[0];

  $menu_item_id.focus();

  $('#btn_simpan').click(function(){
    if ($.trim($menu_item_id.value) == '') {
      alert('Role can not empty.');
      $menu_item_id.focus();
      return false;
    }
    
      $.post(
        $_base_url + 'index.php/Role_menu/update_roleMenu_ajax',
        {role_id: $role_id.value,
         menu_item_id: $menu_item_id.value
        },
        function(data) {
          if (data.result == 'false') {
            alert('Update data failed.');
          } else {
            alert('Updated.');
            window.location = $_base_url + 'Role_menu/lists/' + $role_id.value;
          }
        },
        'json'
      );
  });

  $('#btn_batal').click(function(){
    window.location = $_base_url + 'Role_menu/lists/' + $role_id.value;
  });
});

</script>

<fieldset style="position: absolute; top: 65px; left: 240px; width: 300px; height: 200px">
    <legend><?=$role_name?> - Edit Menu</legend>
    <input value="<?=$role_id?>" type="text" name="role_id" id="role_id" height="4" size="50" class="input_text"/>
    
    <p>
    Menu <br/>
    <?echo form_dropdown('menu_item_id', $menu_list, $menu_item_id, 'id = "menu_item_id" name = "menu_item_id" class="input_text"');?>
    </p>
    
    <br/>
    <p>
        <input type="button" value="Save" id="btn_simpan" class="button_save"/>
        <input type="button" value="Cancel" id="btn_batal" class="button_cancel"/>
    </p>
</fieldset>
<table height="520" width="1300"></table>