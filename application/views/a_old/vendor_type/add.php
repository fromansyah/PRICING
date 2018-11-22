<script type="text/javascript">

$_base_url = '<?= base_url() ?>';

var $name;
var $desc;

$(document).ready(function(){

  $name = $('#name')[0];
  $desc = $('#desc')[0];

  $name.focus();

  $('#btn_simpan').click(function(){
    if ($.trim($name.value) == '') {
      alert('Vendor type name can not empty.');
      $name.focus();
      return false;
    }

      $.post(
        $_base_url + 'Vendor_type/save_vendor_type_ajax',
        {
         name: $name.value,
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
            window.location = $_base_url + 'Vendor_type';
          }
        },
        'json'
      );
  });

  $('#btn_batal').click(function(){
    window.location = $_base_url + 'Vendor_type';
  });
});

</script>

<fieldset style="position: absolute; top: 65px; left: 240px; width: 300px; height: 400px">
    <legend><?=$page_title?></legend>
    
    <p>
    <font color="red">*</font> Vendor Type Name <br/>
    <input type="text" name="name" id="name" height="4" size="50" class="input_text"/>
    </p>
    
    <p>
    Description <br/>
    <textarea rows="5" name="desc" id="desc" cols="50"></textarea>
    </p>
    
    <br/>
    <p>
        <input type="button" value="Save" id="btn_simpan" class="button_save"/>
        <input type="button" value="Cancel" id="btn_batal" class="button_cancel"/>
    </p>
</fieldset>
<table height="520" width="1300"></table>