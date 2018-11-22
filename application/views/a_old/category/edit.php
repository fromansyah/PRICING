<script type="text/javascript">

$_base_url = '<?= base_url() ?>';

var $id;
var $name;
var $year_num;
var $percentage;
var $desc;

$(document).ready(function(){
    
  $id = $('#id')[0];
  $name = $('#name')[0];
  $year_num = $('#year_num')[0];
  $percentage = $('#percentage')[0];
  $desc = $('#desc')[0];

  $name.focus();

  $('#btn_simpan').click(function(){
    if ($.trim($name.value) == '') {
      alert('Category name can not empty.');
      $name.focus();
      return false;
    }

      $.post(
        $_base_url + 'Category/update_category_ajax',
        {
         id: $id.value,
         name: $name.value,
         year_num: $year_num.value,
         percentage: $percentage.value,
         desc: $desc.value
        },
        function(data) {
          if (data.result == 'false') {
            serr = 'Fail to update data.';
            try {
              serr = serr + ' ' + data.keterangan;
            } catch(e) {}
            alert(serr);
          } else {
            alert('Updated.');
            window.location = $_base_url + 'Category';
          }
        },
        'json'
      );
  });

  $('#btn_batal').click(function(){
    window.location = $_base_url + 'Category';
  });
});

</script>

<fieldset style="position: absolute; top: 65px; left: 240px; width: 300px; height: 400px">
    <legend>Edit Category</legend>
    <input value="<?=$category_id?>" type="hidden" name="id" id="id" height="4" size="50" class="input_text"/>
    
    <p>
    <font color="red">*</font> Category Name <br/>
    <input value="<?=$category_name?>" type="text" name="name" id="name" height="4" size="50" class="input_text"/>
    </p>
    
    <p>
    Num. of Year <br/>
    <input value="<?=$num_of_year?>" type="text" name="year_num" id="year_num" height="4" size="50" class="input_text"/>
    </p>
    
    <p>
    Depreciation Percentage <br/>
    <input value="<?=$depreciation_percentage?>" type="text" name="percentage" id="percentage" height="4" size="50" class="input_text"/>
    </p>
    
    <p>
    Description <br/>
    <textarea rows="5" name="desc" id="desc" cols="50"><?=$category_desc?></textarea>
    </p>
    
    <br/>
    <p>
        <input type="button" value="Save" id="btn_simpan" class="button_save"/>
        <input type="button" value="Cancel" id="btn_batal" class="button_cancel"/>
    </p>
</fieldset>
<table height="520" width="1300"></table>