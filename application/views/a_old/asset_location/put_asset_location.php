<script type="text/javascript" src="<?= base_url() ?>js/datetimepicker_css.js"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>

<script type="text/javascript">

var _base_url = '<?= base_url() ?>';

var $asset_id;
var $asset_barcode;
var $asset_name;
var $location;
var $employee;
var $start_date;
var $end_date;
var $desc;

$(document).ready(function(){
   
    $('#btn_simpan').click(function(){
        
        $asset_id = $('#asset_id')[0];
        $asset_barcode = $('#asset_barcode')[0];
        $asset_name = $('#asset_name')[0];
        $location = $('#location')[0];
        $employee = $('#employee')[0];
        $start_date = $('#start_date')[0];
        $end_date = $('#end_date')[0];
        $desc = $('#desc')[0];
        
        if ($.trim($location.value) == 0) {
          alert('location can not empty.');
          $location.focus();
          return false;
        }
    
        if ($.trim($start_date.value) == '') {
          alert('Start date can not empty.');
          $start_date.focus();
          return false;
        }
    
        if ($.trim($end_date.value) == '') {
          alert('End date can not empty.');
          $end_date.focus();
          return false;
        }
        
        i = confirm('Are you sure want to submit this asset location?');
        if (i) {
            $.post(
            _base_url + 'Asset_location/save_asset_location_ajax',
            {asset_id : $asset_id.value,
             barcode : $asset_barcode.value,
             name : $asset_name.value,
             location : $location.value,
             employee : $employee.value,
             start_date : $start_date.value,
             end_date : $end_date.value,
             desc : $desc.value
            },
            function(data) {
              if (data.result == 'false') {
                serr = 'Fail to submit asset location.';
                try {
                  serr = serr + ' ' + data.keterangan;
                } catch(e) {}
                alert(serr);
              } else {
                alert('Asset location Submitted.');
                window.location = _base_url + 'Asset';
              }
            },
            'json'
          );
        }
    });
    
    $('#btn_batal').click(function(){
        window.location = _base_url + 'Asset';
  });
});

</script>

<fieldset style="position: absolute; top: 80px; left: 20px; width: 95%; height: 400px; padding: 30px;">
    <legend>Add Location</legend>
    <table>
        <tr>
            <td valign="top" width="450">
                <input value="<?=$asset_id?>" type="hidden" name="asset_id" id="asset_id" height="4" size="50" disabled="true"/>

                <p>
                Barcode <br/>
                <input value="<?=$asset_barcode?>" type="text" name="asset_barcode" id="asset_barcode" height="4" size="50" disabled="true" class="input_text"/>
                </p>

                <p>
                Asset name <br/>
                <input value="<?=$asset_name?>" type="text" name="asset_name" id="asset_name" height="4" size="50" disabled="true" class="input_text"/>
                </p>

                <p>
                    <font color="red">*</font> Location<br/>
                        <?php 
                        echo form_dropdown('location', $location_list, '', 'id = "location" name = "location" class="input_text"');
                        ?>
                </p>

                <p>
                    Employee<br/>
                        <?php 
                        echo form_dropdown('employee', $employee_list, '', 'id = "employee" name = "employee" class="input_text"');
                        ?>
                </p>
            </td>
            <td valign="top" width="450">
                <p>
                    <font color="red">*</font> Start Date (mm-dd-yyyy)</font><br/>
                    <input type="Text" name="start_date" id="start_date" maxlength="25" size="20"  class="input_text">&nbsp;&nbsp;<a href="javascript:NewCssCal('start_date','mmddyyyy')"><img src="<?php echo base_url();?>images/001_44.gif" width="16" height="16" alt="Pick a date"></a>
                </p>

                <p>
                    <font color="red">*</font> End Date (mm-dd-yyyy)</font><br/>
                    <input type="Text" name="end_date" id="end_date" maxlength="25" size="20"  class="input_text">&nbsp;&nbsp;<a href="javascript:NewCssCal('end_date','mmddyyyy')"><img src="<?php echo base_url();?>images/001_44.gif" width="16" height="16" alt="Pick a date"></a>
                </p>

                <p>
                    Description <br/>
                    <textarea rows="5" name="desc" id="desc" cols="50" class="input_text"></textarea>
                </p>

                <p>
                    <input type="button" value="Save" id="btn_simpan" class="button_save"/>
                    <input type="button" value="Cancel" id="btn_batal" class="button_cancel"/>
                </p>
            </td>
    </table>
</fieldset>
<table height="500" width="1300"></table>