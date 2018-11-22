<script type="text/javascript">

$_base_url = '<?= base_url() ?>';

var $name;
var $type;
var $address;
var $phone;
var $desc;

$(document).ready(function(){

  $name = $('#name')[0];
  $type = $('#vendor_type')[0];
  $address = $('#address')[0];
  $phone = $('#phone')[0];
  $desc = $('#desc')[0];

  $name.focus();

  $('#btn_simpan').click(function(){
    if ($.trim($name.value) == '') {
      alert('Vendor name can not empty.');
      $name.focus();
      return false;
    }
    
    if ($.trim($type.value) == '#') {
      alert('Vendor type can not empty.');
      $type.focus();
      return false;
    }
    
    if ($.trim($phone.value) == '') {
      alert('Phone number can not empty.');
      $phone.focus();
      return false;
    }

      $.post(
        $_base_url + 'Vendor/save_vendor_ajax',
        {
         name: $name.value,
         type: $type.value,
         address: $address.value,
         phone: $phone.value,
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
            window.location = $_base_url + 'Vendor';
          }
        },
        'json'
      );
  });

  $('#btn_batal').click(function(){
    window.location = $_base_url + 'Vendor';
  });
});

</script>

<fieldset style="position: absolute; top: 65px; left: 240px; width: 300px; height: 330px">
    <legend><?=$page_title?></legend>
    
    <p>
    <font color="red">*</font> Vendor Name <br/>
    <input type="text" name="name" id="name" height="4" size="50" class="input_text"/>
    </p>
    
    <p>
    <font color="red">*</font> Vendor Type <br/>
    <?echo form_dropdown('vendor_type', $type_list, '', 'id = "vendor_type" name = "vendor_type" class="input_text"');?>
    </p>
    
    <p>
    Address <br/>
    <textarea rows="5" name="address" id="address" cols="50"></textarea>
    </p>
    
    <p>
    <font color="red">*</font> Phone <br/>
    <input type="text" name="phone" id="phone" height="4" size="50" class="input_text"/>
    </p>

    <br/>
</fieldset>
<fieldset style="position: absolute; top: 65px; left: 740px; width: 300px; height: 330px">
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
<table height="500" width="1300"></table>