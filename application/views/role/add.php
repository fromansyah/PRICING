<script type="text/javascript">

$_base_url = '<?= base_url() ?>';

var $role;

$(document).ready(function(){

  $role = $('#role')[0];

  $role.focus();

  $('#btn_simpan').click(function(){
    if ($.trim($role.value) == '') {
      alert('Role can not empty.');
      $role.focus();
      return false;
    }

   $.post(
    $_base_url + 'Role/save_role_ajax',
    {
        role: $role.value
    },
    function(data) {
        if (data.result == 'false') {
            serr = 'Fail to save data.';
            try {
              serr = serr + ' ' + data.keterangan;
            } catch(e) {}
            alert(serr);
        } else {
            alert('Saved.');
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
    <legend>Add Role</legend>
    
    <p>
    Role <br/>
    <input type="text" name="role" id="role" height="4" size="50" class="input_text"/>
    </p>
    
    <br/>
    <p>
        <input type="button" value="Save" id="btn_simpan" class="button_save"/>
        <input type="button" value="Cancel" id="btn_batal" class="button_cancel"/>
    </p>
</fieldset>
<table height="520" width="1300"></table>