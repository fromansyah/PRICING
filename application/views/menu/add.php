<script type="text/javascript">

$_base_url = '<?= base_url() ?>';
$_type = 'add';

var $menu;
var $link;

$(document).ready(function(){

  $menu = $('#menu')[0];
  $link = $('#link')[0];

  $menu.focus();

  $('#btn_simpan').click(function(){
    if ($.trim($menu.value) == '') {
      alert('Menu can not empty.');
      $menu.focus();
      return false;
    }

    if ($_type == 'add') {
      $.post(
        $_base_url + 'index.php/menu/simpan_menu_ajax',
        {
         menu: $menu.value,
         link: $link.value
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
            window.location = $_base_url + 'index.php/menu';
          }
        },
        'json'
      );
    } else {
      $.post(
        $_base_url + 'index.php/menu/update_menu_ajax',
        {
         id: $id.value,
         menu: $menu.value,
         link: $link.value
        },
        function(data) {
          if (data.result == 'false') {
            alert('Update data failed.');
          } else {
            alert('Updated.');
            window.location = $_base_url + 'index.php/menu';
          }
        },
        'json'
      );
    }
  });

  $('#btn_batal').click(function(){
    window.location = $_base_url + 'index.php/menu';
  });
});

</script>

<fieldset style="position: absolute; top: 65px; left: 240px; width: 300px; height: 200px">
    <legend>Add Menu</legend>
    
    <p>
    Menu <br/>
    <input type="text" name="menu" id="menu" height="4" size="50" class="input_text"/>
    </p>
    
    <p>
    Link <br/>
    <input type="text" name="link" id="link" height="4" size="50" class="input_text"/>
    </p>
    
    <br/>
    <p>
        <input type="button" value="Save" id="btn_simpan" class="button_save"/>
        <input type="button" value="Cancel" id="btn_batal" class="button_cancel"/>
    </p>
</fieldset>
<table height="520" width="1300"></table>