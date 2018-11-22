<script type="text/javascript" src="<?= base_url() ?>js/datetimepicker_css.js"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>

<script>
function formatCurrency(num) {
    num = num.toString().replace(/\$|\,/g,'');
    if(isNaN(num))
    num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num*100+0.50000000001);
    cents = num%100;
    num = Math.floor(num/100).toString();
    if(cents<10)
    cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
    num = num.substring(0,num.length-(4*i+3))+','+
    num.substring(num.length-(4*i+3));
    return (((sign)?'':'-') + ' ' + num + '.' + cents);
    }
</script>

<script type="text/javascript">

$_base_url = '<?= base_url() ?>';

var $id;
var $name;
var $barcode;
var $category;
var $year_num;
var $purchase_date;
var $currency;
var $rate;
var $value;
var $idr_value;
var $vendor;
var $employee;
var $department;
var $desc;
var $note;

$(document).ready(function(){

  $id = $('#id')[0];
  $name = $('#name')[0];
  $barcode = $('#barcode')[0];
  $category = $('#category')[0];
  $year_num = $('#year_num')[0];
  $purchase_date = $('#purchase_date')[0];
  $currency = $('#currency')[0];
  $rate = $('#rate')[0];
  $value = $('#value')[0];
  $idr_value = $('#idr_value')[0];
  $vendor = $('#vendor')[0];
  $employee = $('#employee')[0];
  $department = $('#department')[0];
  $desc = $('#desc')[0];
  $note = $('#note')[0];

  $purchase_date.focus();

  $('#btn_simpan').click(function(){
      
    if ($.trim($purchase_date.value) == '') {
      alert('Purchase date can not empty.');
      $purchase_date.focus();
      return false;
    }
    
    if ($.trim($name.value) == '') {
      alert('Asset name can not empty.');
      $name.focus();
      return false;
    }
    
    if ($.trim($category.value) == '#') {
      alert('Category can not empty.');
      $category.focus();
      return false;
    }
    
    if ($.trim($year_num.value) == '') {
      alert('Num. of year can not empty.');
      $year_num.focus();
      return false;
    }
    
    if ($.trim($department.value) == '#') {
      alert('Department can not empty.');
      $department.focus();
      return false;
    }
    
    if ($.trim($barcode.value) == '') {
      alert('Barcode can not empty.');
      $barcode.focus();
      return false;
    }
    
    if ($.trim($rate.value) <= 0) {
      alert('Rate must be greater than 0.');
      $rate.focus();
      return false;
    }
    
    if ($.trim($value.value) <= 0) {
      alert('Purchase value can not empty and must be greater than 0.');
      $value.focus();
      return false;
    }

      $.post(
        $_base_url + 'Asset/update_asset',
        {
         id: $id.value,
         name: $name.value,
         barcode: $barcode.value,
         category: $category.value,
         year_num: $year_num.value,
         purchase_date: $purchase_date.value,
         currency: $currency.value,
         rate: $rate.value,
         value: $value.value,
         idr_value: $idr_value.value,
         vendor: $vendor.value,
         employee: $employee.value,
         department: $department.value,
         desc: $desc.value,
         note: $note.value
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
            window.location = $_base_url + 'Asset';
          }
        },
        'json'
      );
  });

  $('#btn_batal').click(function(){
    window.location = $_base_url + 'Asset';
  });
});

</script>

<script type="text/javascript">// <![CDATA[
    $(document).ready(function(){

        $('#category').change(function(){ 
            
            var category = $('#category').val();
            var date = $('#purchase_date').val();
            var dept = $('#department').val();
            var old_ctgr = $('#old_category').val();
            var old_date = $('#old_purchase_date').val();
            var old_dept = $('#old_department').val();
            var old_barcode = $('#old_barcode').val();
            if(category != '#'){
                $.ajax({
                    type: "POST",
                    url: $_base_url + 'Category/get_year_category/' + category , //here we are calling our user controller and get_cities method with the country_id

                    success: function(value)
                    {
                        $.each(value,function(id,test) 
                        {
                            $(id).val(test); 
                        }); 
                    }

                });
                
                if(date != ''){
                    if(category==old_ctgr && date==old_date && dept==old_dept){
                        $("#barcode").val(old_barcode);
                    }else{
                        $.ajax({
                            type: "POST",
                            url: $_base_url + 'Asset/get_barcode_for_edit/' + $id.value + '/' + category + '/' + dept + '/' + date, //here we are calling our user controller and get_cities method with the country_id

                            success: function(value)
                            {
                                $.each(value,function(id,test) 
                                {
                                    $(id).val(test); 
                                }); 
                            }

                        });
                    }
                }
            }
        });
        
        $('#purchase_date').change(function(){ 
            
            var category = $('#category').val();
            var date = $('#purchase_date').val();
            var dept = $('#department').val();
            var old_ctgr = $('#old_category').val();
            var old_date = $('#old_purchase_date').val();
            var old_dept = $('#old_department').val();
            var old_barcode = $('#old_barcode').val();
            if(date != '' && category != '#'){
                if(category==old_ctgr && date==old_date && dept==old_dept){
                    $("#barcode").val(old_barcode);
                }else{
                    $.ajax({
                        type: "POST",
                        url: $_base_url + 'Asset/get_barcode_for_edit/' + $id.value + '/' + category + '/' + dept + '/' + date, //here we are calling our user controller and get_cities method with the country_id

                        success: function(value)
                        {
                            $.each(value,function(id,test) 
                            {
                                $(id).val(test); 
                            });
                        }

                    });
                }
            }
        });
        
        $('#department').change(function(){ 
            
            var category = $('#category').val();
            var date = $('#purchase_date').val();
            var dept = $('#department').val();
            var old_ctgr = $('#old_category').val();
            var old_date = $('#old_purchase_date').val();
            var old_dept = $('#old_department').val();
            var old_barcode = $('#old_barcode').val();
            if(date != '' && category != '#'){
                if(category==old_ctgr && date==old_date && dept==old_dept){
                    $("#barcode").val(old_barcode);
                }else{
                    $.ajax({
                        type: "POST",
                        url: $_base_url + 'Asset/get_barcode_for_edit/' + $id.value + '/' + category + '/' + dept + '/' + date, //here we are calling our user controller and get_cities method with the country_id

                        success: function(value)
                        {
                            $.each(value,function(id,test) 
                            {
                                $(id).val(test); 
                            });
                        }

                    });
                }
            }
        });

        $('#currency').change(function(){ 
            
            var category = $('#currency').val();
            var rate = $('#rate').val();
            var purchase_value = $('#value').val();
            var idr_value = 0;
            if(category == 'USD'){
                idr_value = purchase_value * rate;
                $('#idr_value').val(idr_value); 
            }else{
                $('#idr_value').val(purchase_value); 
                $('#rate').val(1); 
            }
        });

        $('#rate').change(function(){ 
            
            var category = $('#currency').val();
            var rate = $('#rate').val();
            var purchase_value = $('#value').val();
            var idr_value = 0;
            if(category == 'USD'){
                idr_value = purchase_value * rate;
                $('#idr_value').val(idr_value); 
            }else{
                $('#idr_value').val(purchase_value); 
            }
        });

        $('#value').change(function(){ 
            
            var category = $('#currency').val();
            var rate = $('#rate').val();
            var purchase_value = $('#value').val();
            var idr_value = 0;
            if(category == 'USD'){
                idr_value = purchase_value * rate;
                $('#idr_value').val(idr_value); 
            }else{
                $('#idr_value').val(purchase_value); 
            }
        });
    });
</script>

<fieldset style="position: absolute; top: 80px; left: 20px; width: 450px; height: 600px; padding: 30px;">
    <legend>Edit Asset</legend>
    <input value="<?=$asset_id?>" type="hidden" name="id" id="id" height="4" size="35" class="input_text"/>

    <p>
    <input value="<?=$date?>" type="hidden" name="old_purchase_date" id="old_purchase_date" height="4" size="35" class="input_text"/>
    <font color="red">*</font> Purchase Date <br/>
    <input value="<?=$date?>" type="Text" name="purchase_date" id="purchase_date" maxlength="25" size="20" class="input_text"><a href="javascript:NewCssCal('purchase_date','mmddyyyy')"><img src="<?php echo base_url();?>images/001_44.gif" width="16" height="16" alt="Pick a date"></a>
    </p>
    
    <p>
    <font color="red">*</font> Asset Name <br/>
    <input value="<?=$asset_name?>" type="text" name="name" id="name" height="4" size="35" class="input_text"/>
    </p>
    
    <p>
    <input value="<?=$category?>" type="hidden" name="old_category" id="old_category" height="4" size="35" class="input_text"/>
    <font color="red">*</font> Category <br/>
    <?php echo form_dropdown('category', $category_list, $category, 'id="category" name = "category" class="input_text"'); ?>
    </p>
    
    <p>
    <font color="red">*</font> Num. of Year <br/>
    <input value="<?=$year_num?>" type="text" name="year_num" id="year_num" height="4" size="35" class="input_text"/>
    </p>
    
    <p>
    <input value="<?=$department_id?>" type="hidden" name="old_department" id="old_department" height="4" size="35" class="input_text"/>
    <font color="red">*</font> Department <br/>
    <?php echo form_dropdown('department', $dept_list, $department_id, 'id="department" name = "department" class="input_text"'); ?>
    </p>
    
    <p>
    <input value="<?=$asset_barcode?>" type="hidden" name="old_barcode" id="old_barcode" height="4" size="35" class="input_text"/>
    <font color="red">*</font> Barcode <br/>
    <input value="<?=$asset_barcode?>" type="text" name="barcode" id="barcode" height="4" size="35" class="input_text"/>
    </p>
    
    <p>
    <font color="red">*</font> Currency <br/>
    <?
        $currencyList = array();
        $currencyList['IDR'] = 'IDR';
        $currencyList['USD'] = 'USD';

        echo form_dropdown('currency', $currencyList, $currency, 'id = "currency" name = "currency" class="input_text"');
    ?>
    </p>
    
    <p>
    <font color="red">*</font> Rate <br/>
    <input value="<?=$rate?>" value="1" type="text" name="rate" id="rate" height="4" size="30" onkeyup="document.getElementById('format1').innerHTML = formatCurrency(this.value);" onchange="document.getElementById('format1').innerHTML = formatCurrency(this.value);" class="input_text"/><span id="format1"></span>
    </p>
    
    <p>
    <font color="red">*</font> Purchase Value<br/>
    <input value="<?=$value?>" type="text" name="value" id="value" height="4" size="30" onkeyup="document.getElementById('format2').innerHTML = formatCurrency(this.value);" onchange="document.getElementById('format2').innerHTML = formatCurrency(this.value);" class="input_text"/><span id="format2"></span>
    </p>
    
</fieldset>
<fieldset style="position: absolute; top: 80px; left: 500px; width: 450px; height: 600px; padding: 30px;">
    
    <p>
    Voucher Number <br/>
    <input value="<?=$voucher_number?>" type="text" name="voucher_number" id="voucher_number" height="4" size="30" class="input_text"/>
    </p>
    
    <p>
    <font color="red">*</font> IDR Value<br/>
    <input value="<?=$idr_value?>" disabled="true" type="text" name="idr_value" id="idr_value" height="4" size="30" onkeyup="document.getElementById('format3').innerHTML = formatCurrency(this.value);" onchange="document.getElementById('format3').innerHTML = formatCurrency(this.value);" class="input_text"/><span id="format3"></span>
    </p>
    
    <p>
    Vendor <br/>
    <?php echo form_dropdown('vendor', $vendor_list, $vendor_id, 'id="vendor" name = "vendor" class="input_text"'); ?>
    </p>
    
    <p>
    Requestor <br/>
    <?php echo form_dropdown('employee', $employee_list, $employee_id, 'id="employee" name = "employee" class="input_text"'); ?>
    </p>
    
    <p>
    Asset Description <br/>
    <textarea rows="5" name="desc" id="desc" cols="45"><?=$desc?></textarea>
    </p>
    
    <p>
    Note <br/>
    <textarea rows="5" name="note" id="note" cols=45"><?=$note?></textarea>
    </p>
    <br/>
    <p>
        <input type="button" value="Save" id="btn_simpan" class="button_save"/>
        <input type="button" value="Cancel" id="btn_batal" class="button_cancel"/>
    </p>
</fieldset>
<table height="650" width="1300"></table>