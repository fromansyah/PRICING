<script type="text/javascript" src="<?= base_url() ?>js/datetimepicker_css.js"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
<script type="text/javascript">
    
var _base_url = '<?= base_url() ?>';

var $return_asset_location_id;
var $return_asset_id;
var $return_end_date;
var $return_note;

$(document).ready(function(){

    $('#btn_simpan').click(function(){
        
        $return_asset_location_id = $('#return_asset_location_id')[0];
        $return_asset_id = $('#return_asset_id')[0];
        $return_end_date = $('#return_end_date')[0];
        $return_note = $('#return_note')[0];
        
        $return_end_date.focus();
        
        if ($.trim($return_end_date.value) == '') {
          alert('End date can not empty.');
          $return_end_date.focus();
          return false;
        }
        
        i = confirm('Are you sure want to return this asset?');
        if (i) {
            $.post(
            _base_url + 'Asset_location/return_asset',
            {asset_location_id: $return_asset_location_id.value,
             asset_id : $return_asset_id.value,
             end_date : $return_end_date.value,
             note : $return_note.value
            },
            function(data) {
              if (data.result == 'false') {
                serr = 'Fail to return asset.';
                try {
                  serr = serr + ' ' + data.keterangan;
                } catch(e) {}
                alert(serr);
              } else {
                alert('Asset has been returned.');
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
    <legend>Return Asset</legend>
    <table>
        <tr>
            <td valign="top" width="450">
                <input value="<?=$return_asset_location_id?>" type="hidden" name="return_asset_location_id" id="return_asset_location_id" height="4" size="50" disabled="true"/>
                <input value="<?=$return_asset_id?>" type="hidden" name="return_asset_id" id="return_asset_id" height="4" size="50" disabled="true"/>

                <p>
                Barcode <br/>
                <input value="<?=$return_asset_barcode?>" type="text" name="return_asset_barcode" id="return_asset_barcode" height="4" size="50" disabled="true" class="input_text"/>
                </p>

                <p>
                Asset name <br/>
                <input value="<?=$return_asset_name?>" type="text" name="return_asset_name" id="return_asset_name" height="4" size="50" disabled="true" class="input_text"/>
                </p>

                <p>
                    <font color="red">*</font> Location<br/>
                    <input value="<?=$return_location?>" type="text" name="return_location" id="return_location" height="4" size="50" disabled="true" class="input_text"/>
                </p>

                <p>
                    Employee<br/>
                    <input value="<?=$return_employee?>" type="text" name="return_employee" id="return_employee" height="4" size="50" disabled="true" class="input_text"/>
                </p>
            </td>
            <td valign="top" width="450">
                <p>
                    <font color="red">*</font> Start Date (mm-dd-yyyy)</font><br/>
                    <input value="<?=$return_start_date?>" type="Text" name="return_start_date" id="return_start_date" maxlength="25" size="20" disabled="true" class="input_text">
                </p>

                <p>
                    <font color="red">*</font> End Date (mm-dd-yyyy)</font><br/>
                    <input value="<?=$return_end_date?>" type="Text" name="return_end_date" id="return_end_date" maxlength="25" size="20" class="input_text">&nbsp;&nbsp;<a href="javascript:NewCssCal('return_end_date','mmddyyyy')"><img src="<?php echo base_url();?>images/001_44.gif" width="16" height="16" alt="Pick a date"></a>
                </p>

                <p>
                    Note <br/>
                    <textarea rows="5" name="return_note" id="return_note" cols="50" class="input_text"></textarea>
                </p>

                <p>
                    <input type="button" value="Save" id="btn_simpan" class="button_save"/>
                    <input type="button" value="Cancel" id="btn_batal" class="button_cancel"/>
                </p>
            </td>
    </table>
</fieldset>
<table height="500" width="1300"></table>