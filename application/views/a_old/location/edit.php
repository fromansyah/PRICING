<script type="text/javascript">

$_base_url = '<?= base_url() ?>';

var $id;
var $location;
var $desc;

$(document).ready(function(){

  $id = $('#id')[0];
  $location = $('#location')[0];
  $desc = $('#desc')[0];

  $location.focus();

  $('#btn_simpan').click(function(){
    if ($.trim($location.value) == '') {
      alert('Location can not empty.');
      $location.focus();
      return false;
    }

      $.post(
        $_base_url + 'Location/update_location_ajax',
        {
         id: $id.value,
         location: $location.value,
         desc: $desc.value
        },
        function(data) {
          if (data.result == 'false') {
            serr = 'Fail to save data.';
            try {
              serr = serr + ' ' + data.keterangan;
            } catch(e) {}
            alert(serr);
          } else {
            alert('Updated.');
            window.location = $_base_url + 'Location';
          }
        },
        'json'
      );
  });

  $('#btn_batal').click(function(){
    window.location = $_base_url + 'Location';
  });
});

</script>

<fieldset style="position: absolute; top: 65px; left: 240px; width: 300px; height: 330px">
    <legend><?=$page_title?></legend>
    <input value="<?=$location_id?>" type="hidden" name="id" id="id" height="4" size="50" class="input_text"/>
    
    <p>
    <font color="red">*</font> Location <br/>
    <input value="<?=$location?>" type="text" name="location" id="location" height="4" size="50" class="input_text"/>
    </p>
    
    <p>
    description <br/>
    <textarea rows="5" name="desc" id="desc" cols="50"><?=$desc?></textarea>
    </p>
    
    <br/>
    <br/>
    <p>
        <input type="button" value="Save" id="btn_simpan" class="button_save"/>
        <input type="button" value="Cancel" id="btn_batal" class="button_cancel"/>
    </p>
</fieldset>
<table height="500" width="1300"></table>