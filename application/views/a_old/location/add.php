<script type="text/javascript">

$_base_url = '<?= base_url() ?>';

var $location;
var $desc;

$(document).ready(function(){

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
        $_base_url + 'Location/save_location_ajax',
        {
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
            alert('Saved.');
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
    
    <p>
    <font color="red">*</font> Location <br/>
    <input type="text" name="location" id="location" height="4" size="50" class="input_text"/>
    </p>
    
    <p>
    Description <br/>
    <textarea rows="5" name="desc" id="desc" cols="50"></textarea>
    </p>
    <br/>
    <br/>
    <p>
        <input type="button" value="Save" id="btn_simpan" class="button_save"/>
        <input type="button" value="Cancel" id="btn_batal" class="button_cancel"/>
    </p>
</fieldset>

<table height="500" width="1300"></table>