<script type="text/javascript">

$_base_url = '<?= base_url() ?>';

var $id;
var $role;

$(document).ready(function(){

  $id = $('#id')[0];
  $role = $('#role')[0];

  $role.focus();

  $('#btn_simpan').click(function(){
    if ($.trim($role.value) == '') {
      alert('Role can not empty.');
      $role.focus();
      return false;
    }
    
      $.post(
        $_base_url + 'index.php/Role/update_role_ajax',
        {id: $id.value,
         role: $role.value
        },
        function(data) {
          if (data.result == 'false') {
            alert('Update data failed.');
          } else {
            alert('Updated.');
            window.location = $_base_url + 'Role';
          }
        },
        'json'
      );
  });

  $('#btn_batal').click(function(){
    window.location = $_base_url + 'Role';
  });
});

</script>

<fieldset style="position: absolute; top: 65px; left: 240px; width: 300px; height: 200px">
    <legend>Edit Role</legend>
    <input value="<?=$id?>" type="hidden" name="id" id="id" height="4" size="50" class="input_text"/>
    
    <p>
    Role <br/>
    <input value="<?=$role?>" type="text" name="role" id="role" height="4" size="50" class="input_text"/>
    </p>
    
    <br/>
    <p>
        <input type="button" value="Save" id="btn_simpan" class="button_save"/>
        <input type="button" value="Cancel" id="btn_batal" class="button_cancel"/>
    </p>
</fieldset>
<table height="520" width="1300"></table>