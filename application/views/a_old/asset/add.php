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
var $voucher_number;

var $paymentType;

$(document).ready(function(){

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
  $paymentType = $('#payment_type')[0];
  $voucher_number = $('#voucher_number')[0];

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
    
//    if ($.trim($barcode.value) == '') {
//      alert('Barcode can not empty.');
//      $barcode.focus();
//      return false;
//    }
    
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
        $_base_url + 'Asset/save_asset',
        {
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
         note: $note.value,
         payment_type: $paymentType.value,
         voucher_number: $voucher_number.value
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
            var payment = $('#payment_type').val();
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
                
                if(date != '' && payment == 2){
                    $.ajax({
                        type: "POST",
                        url: $_base_url + 'Asset/get_barcode/' + category + '/' + dept + '/' + date, //here we are calling our user controller and get_cities method with the country_id

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
        
        $('#purchase_date').change(function(){ 
            
            var category = $('#category').val();
            var date = $('#purchase_date').val();
            var dept = $('#department').val();
            var payment = $('#payment_type').val();
            if(date != '' && category != '#' && payment == 2){
                $.ajax({
                    type: "POST",
                    url: $_base_url + 'Asset/get_barcode/' + category + '/' + dept + '/' + date, //here we are calling our user controller and get_cities method with the country_id

                    success: function(value)
                    {
                        $.each(value,function(id,test) 
                        {
                            $(id).val(test); 
                        });
                    }

                });
            }
        });
        
        $('#department').change(function(){ 
            
            var category = $('#category').val();
            var date = $('#purchase_date').val();
            var dept = $('#department').val();
            var payment = $('#payment_type').val();
            if(date != '' && category != '#' && payment == 2){
                $.ajax({
                    type: "POST",
                    url: $_base_url + 'Asset/get_barcode/' + category + '/' + dept + '/' + date, //here we are calling our user controller and get_cities method with the country_id

                    success: function(value)
                    {
                        $.each(value,function(id,test) 
                        {
                            $(id).val(test); 
                        });
                    }

                });
            }
        });
        
        $('#payment_type').change(function(){ 
            
            var category = $('#category').val();
            var date = $('#purchase_date').val();
            var dept = $('#department').val();
            var payment = $('#payment_type').val();
            if(date != '' && category != '#' && payment == 2){
                $.ajax({
                    type: "POST",
                    url: $_base_url + 'Asset/get_barcode/' + category + '/' + dept + '/' + date, //here we are calling our user controller and get_cities method with the country_id

                    success: function(value)
                    {
                        $.each(value,function(id,test) 
                        {
                            $(id).val(test); 
                        });
                    }

                });
            }else if(payment == 1){
                $('#barcode').val(''); 
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

<fieldset style="position: absolute; top: 80px; left: 20px; width: 480px; height: 650px; padding: 30px;">
    <legend>Add Asset</legend>
    
    <p>
    Payment Type <br/>
    <?php echo form_dropdown('payment_type', $payment_type_list, '', 'id="payment_type" name = "payment_type" class="input_text"'); ?>
    </p>
    
    <p>
    <font color="red">*</font> Purchase Date <br/>
    <input type="Text" name="purchase_date" id="purchase_date" maxlength="25" size="20" class="input_text"><a href="javascript:NewCssCal('purchase_date','mmddyyyy')"><img src="<?php echo base_url();?>images/001_44.gif" width="16" height="16" alt="Pick a date"></a>
    </p>
    
    <p>
    <font color="red">*</font> Asset Name <br/>
    <input type="text" name="name" id="name" height="4" size="35" class="input_text"/>
    </p>
    
    <p>
    <font color="red">*</font> Category <br/>
    <?php echo form_dropdown('category', $category_list, '', 'id="category" name = "category" class="input_text"'); ?>
    </p>
    
    <p>
    <font color="red">*</font> Num. of Year <br/>
    <input type="text" name="year_num" id="year_num" height="4" size="35" class="input_text"/>
    </p>
    
    <p>
    <font color="red">*</font> Department <br/>
    <?php echo form_dropdown('department', $dept_list, '', 'id="department" name = "department" class="input_text"'); ?>
    </p>
    
    <p>
    <font color="red">*</font> Barcode <br/>
    <input type="text" name="barcode" id="barcode" height="4" size="35" class="input_text" readonly="readonly"/>
    </p>
    
    <p>
    Asset Description <br/>
    <textarea rows="5" name="desc" id="desc" cols="45"></textarea>
    </p>
    
</fieldset>
<fieldset style="position: absolute; top: 80px; left: 530px; width: 480px; height: 650px; padding: 30px;">

    <p>
    Voucher Number <br/>
    <input type="text" name="voucher_number" id="voucher_number" height="4" size="30" class="input_text"/>
    </p>
    
    <p>
    <font color="red">*</font> Currency <br/>
    <?
        $currencyList = array();
        $currencyList['IDR'] = 'IDR';
        $currencyList['USD'] = 'USD';

        echo form_dropdown('currency', $currencyList, '', 'id = "currency" name = "currency" class="input_text"');
    ?>
    </p>
    
    <p>
    <font color="red">*</font> Rate <br/>
    <input value="1" type="text" name="rate" id="rate" height="4" size="30" onkeyup="document.getElementById('format1').innerHTML = formatCurrency(this.value);" onchange="document.getElementById('format1').innerHTML = formatCurrency(this.value);" class="input_text"/><span id="format1"></span>
    </p>
    
    <p>
    <font color="red">*</font> Purchase Value<br/>
    <input type="text" name="value" id="value" height="4" size="30" onkeyup="document.getElementById('format2').innerHTML = formatCurrency(this.value);" onchange="document.getElementById('format2').innerHTML = formatCurrency(this.value);" class="input_text"/><span id="format2"></span>
    </p>
    
    <p>
    <font color="red">*</font> IDR Value<br/>
    <input disabled="true" type="text" name="idr_value" id="idr_value" height="4" size="30" onkeyup="document.getElementById('format3').innerHTML = formatCurrency(this.value);" onchange="document.getElementById('format3').innerHTML = formatCurrency(this.value);" class="input_text"/><span id="format3"></span>
    </p>
    
    <p>
    Vendor <br/>
    <?php echo form_dropdown('vendor', $vendor_list, '', 'id="vendor" name = "vendor" class="input_text"'); ?>
    </p>
    
    <p>
    Requestor <br/>
    <?php echo form_dropdown('employee', $employee_list, '', 'id="employee" name = "employee" class="input_text"'); ?>
    </p>
    
    <p>
    Note <br/>
    <textarea rows="3" name="note" id="note" cols="45"></textarea>
    
    <br/>
    <br/>
    <p>
        <input type="button" value="Save" id="btn_simpan" class="button_save"/>
        <input type="button" value="Cancel" id="btn_batal" class="button_cancel"/>
    </p>
    
</fieldset>
<table height="700" width="1300"></table>