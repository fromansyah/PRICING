<link href="<?=$this->config->item('base_url');?>css/style.css" rel="stylesheet" type="text/css" />
<link href="<?=$this->config->item('base_url');?>css/flexigrid.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= base_url() ?>js/datetimepicker_css.js"></script>

<script type="text/javascript" src="<?=$this->config->item('base_url');?>js/flexigrid.pack.js"></script>
<script type="text/javascript" src="<?=$this->config->item('base_url');?>js/jquery.dataTables.min.js"></script>

<style>
    
#put_location{
	position: absolute; 
        top: 28%; left: 28%;
	border: 5px solid gray;
	padding: 10px;
	background: white;
	width: 800px;
	height: 350px;
}
    
#return_asset{
	position: absolute; 
        top: 28%; left: 28%;
	border: 5px solid gray;
	padding: 10px;
	background: white;
	width: 800px;
	height: 350px;
}

</style>

<?
echo $js_grid;
?>

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
    
    $('#submit_location').click(function(){
        
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
    
    $('#cancel_location').click(function(){
        $("#put_location").fadeOut(500);
        
        $('#location').empty();
        $('#employee').empty();
        
        $('#asset_id').val('');
        $('#asset_barcode').val('');
        $('#asset_name').val('');
        $('#location').val('');
        $('#employee').val('');
        $('#start_date').val('');
        $('#end_date').val('');
        $('#desc').val('');
    });
    
    $('#submit_return_asset').click(function(){
        
        $return_asset_location_id = $('#return_asset_location_id')[0];
        $return_asset_id = $('#return_asset_id')[0];
        $return_end_date = $('#return_end_date')[0];
        $return_note = $('#return_note')[0];
        
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
    
    $('#cancel_return').click(function(){
        $("#return_asset").fadeOut(500);
        
        $('#return_location').empty();
        $('#return_employee').empty();
        
        $('#return_asset_location_id').val('');
        $('#return_asset_id').val('');
        $('#return_asset_barcode').val('');
        $('#return_asset_name').val('');
        $('#return_location').val('');
        $('#return_employee').val('');
        $('#return_start_date').val('');
        $('#return_end_date').val('');
        $('#return_note').val('');
    });
    
});

function delete_asset(id, asset) {
  i = confirm('Delete Menu : ' + asset + ' ?');
  if (i) {
    window.location = _base_url + 'Asset/delete/' + id;
  }
}

function edit_asset(id) {
  window.location = _base_url + 'Asset/edit/' + id;
}

function view_depreciation(id) {
  window.location = _base_url + 'Depreciation/lists/' + id;
}

function view_location(id) {
  window.location = _base_url + 'Asset_location/lists/' + id;
}

function put_location(id) {
    
      $("#location > option").remove();
      var post_url = _base_url + 'Location/getlocationList';
      $.ajax({
          type: "POST",
          url: post_url,
          success: function(location)
          {
              $('#location').empty();
              var data = eval('(' + location + ')')
              $.each(data,function(location_id,location_name)
              {
                  var opt = $('<option />'); 
                  opt.val(location_id);
                  opt.text(location_name);
                  $('#location').append(opt);
              });
          }
      });
      
    
      $("#employee > option").remove();
      var post_url = _base_url + 'Employee/getEmployeeActiveList';
      $.ajax({
          type: "POST",
          url: post_url,
          success: function(employee)
          {
              $('#employee').empty();
              var data = eval('(' + employee + ')')
              $.each(data,function(emp_id,emp_name)
              {
                  var opt = $('<option />'); 
                  opt.val(emp_id);
                  opt.text(emp_name);
                  $('#employee').append(opt);
              });
          }
      });
    
    $("#put_location").fadeIn(1000);  
      
    $.ajax({
          type: "POST",
          url: _base_url + 'Asset_location/get_value_for_put_location/' + id, //here we are calling our user controller and get_cities method with the country_id
          
          success: function(result)
          {
                for(var key in result) {
                    $(key).val(result[key]);
                }
          }
    });
}

function return_asset(id) {
    
      $("#return_location > option").remove();
      var post_url = _base_url + 'Location/getlocationList';
      $.ajax({
          type: "POST",
          url: post_url,
          success: function(location)
          {
              $('#return_location').empty();
              var data = eval('(' + location + ')')
              $.each(data,function(location_id,location_name)
              {
                  var opt = $('<option />'); 
                  opt.val(location_id);
                  opt.text(location_name);
                  $('#return_location').append(opt);
              });
          }
      });
      
    
      $("#return_employee > option").remove();
      var post_url = _base_url + 'Employee/getEmployeeActiveList';
      $.ajax({
          type: "POST",
          url: post_url,
          success: function(employee)
          {
              $('#return_employee').empty();
              var data = eval('(' + employee + ')')
              $.each(data,function(emp_id,emp_name)
              {
                  var opt = $('<option />'); 
                  opt.val(emp_id);
                  opt.text(emp_name);
                  $('#return_employee').append(opt);
              });
          }
      }); 
      
    $.ajax({
          type: "POST",
          url: _base_url + 'Asset_location/get_value_for_return_asset/' + id, //here we are calling our user controller and get_cities method with the country_id
          
          success: function(result)
          {
                for(var key in result) {
                    $(key).val(result[key]);
                }
          }
    });
    
    $("#return_asset").fadeIn(1000); 
}

function doCommand(com,grid)
{
    if (com == 'Add') {
      window.location = _base_url + 'Asset/add';
    }
    
    if (com=='Select All')
    {
        $('.bDiv tbody tr',grid).addClass('trSelected');
    }

    if (com=='DeSelect All')
    {
        $('.bDiv tbody tr',grid).removeClass('trSelected');
    }
}
</script>
</p>
<br/>
<br/>
<br/>
<br/>
<table>
    <tr>
        <td width="6"></td>
        <td width="230" valign="top">
        </td>
        <td width="1076">
            <table id="flex1" style="display:none"></table>
        </td>
    </tr>
</table>  

<form id="put_location" style="display:none">
    <b><font size="3">Add Location</font></b>
    <?= $content_put_location?>
    <br/>
    <input type="button" value="Cancel" id="cancel_location" class="button_cancel_2"/>
    <input type="button" value="Submit" id="submit_location" class="button_save"/>
</form>

<form id="return_asset" style="display:none">
    <b><font size="3">Return Asset</font></b>
    <?= $content_return_asset?>
    <br/>
    <input type="button" value="Cancel" id="cancel_return" class="button_cancel_2"/>
    <input type="button" value="Return" id="submit_return_asset" class="button_save"/>
</form>