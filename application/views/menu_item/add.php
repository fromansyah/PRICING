<script type="text/javascript">

$_base_url = '<?= base_url() ?>';
$_type = 'add';

var $menu_id;
var $menu_name;
var $link;
var $sequence;

$(document).ready(function(){
  
  $menu_id = $('#menu_id')[0];
  $menu_name = $('#menu_name')[0];
  $link = $('#link')[0];
  $sequence = $('#sequence')[0];

  $menu_name.focus();

  $('#btn_simpan').click(function(){
    if ($.trim($menu_name.value) == '') {
      alert('Menu name can not empty.');
      $menu_name.focus();
      return false;
    }
    
    if ($.trim($link.value) == '') {
      alert('Link can not empty.');
      $link.focus();
      return false;
    }
    
    if ($.trim($sequence.value) == '') {
      alert('Sequence can not empty.');
      $sequence.focus();
      return false;
    }

    if ($_type == 'add') {
      $.post(
        $_base_url + 'index.php/menu_item/simpan_menuItem_ajax',
        {
         menu_id: $menu_id.value,
         menu_name: $menu_name.value,
         link: $link.value,
         sequence: $sequence.value
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
            window.location = $_base_url + 'index.php/menu_item/lists/' + $menu_id.value;
          }
        },
        'json'
      );
    } else {
      $.post(
        $_base_url + 'index.php/menu/simpan_menuItem_ajax',
        {
         id: $id.value,
         menu_id: $menu_id.value,
         menu_name: $menu_name.value,
         link: $link.value,
         sequence: $sequence.value
        },
        function(data) {
          if (data.result == 'false') {
            alert('Update data failed.');
          } else {
            alert('Updated.');
            window.location = $_base_url + 'index.php/menu_item/lists/' + $menu_id.value;
          }
        },
        'json'
      );
    }
  });

  $('#btn_batal').click(function(){
    window.location = $_base_url + 'index.php/menu_item/lists/' + $menu_id.value;
  });
});

</script>

<fieldset style="position: absolute; top: 65px; left: 240px; width: 300px; height: 300px">
    <legend>Add Menu Item for : <?=$menu?></legend>
    <input value="<?=$menu_id?>" type="hidden" name="menu_id" id="menu_id" height="4" size="50" class="input_text"/>
    
    <p>
    Menu Name <br/>
    <input type="text" name="menu_name" id="menu_name" height="4" size="50" class="input_text"/>
    </p>
    
    <p>
    Link <br/>
    <input type="text" name="link" id="link" height="4" size="50" class="input_text"/>
    </p>
    
    <p>
    Sequence <br/>
    <input type="text" name="sequence" id="sequence" height="4" size="50" class="input_text"/>
    </p>
    
    <br/>
    <p>
        <input type="button" value="Save" id="btn_simpan" class="button_save"/>
        <input type="button" value="Cancel" id="btn_batal" class="button_cancel"/>
    </p>
</fieldset>
<table height="520" width="1300"></table>