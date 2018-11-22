<script type="text/javascript" src="<?= base_url() ?>js/datetimepicker_css.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.csv-0.71.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">

<!DOCTYPE html>
<head>
<script type="text/javascript">  
$_base_url = '<?= base_url() ?>';

$(document).ready(function() {

    // The event listener for the file upload
    document.getElementById('txtFileUpload').addEventListener('change', upload, false);

    // Method that checks that the browser supports the HTML5 File API
    function browserSupportFileUpload() {
        var isCompatible = false;
        if (window.File && window.FileReader && window.FileList && window.Blob) {
        isCompatible = true;
        }
        return isCompatible;
    }

    // Method that reads and processes the selected file
    function upload(evt) {
        if (!browserSupportFileUpload()) {
            alert('The File APIs are not fully supported in this browser!');
            } else {
                var data = null;
                var file = evt.target.files[0];
                var reader = new FileReader();
                if(confirm('Are you sure want to upload this file? '+file.name)){
                    reader.readAsText(file);
                    reader.read
                    reader.onload = function(event) {
                        var csvData = event.target.result;
                        data = $.csv.toArrays(csvData);
                        $.post(
                                $_base_url + 'Sales/ajax_upload',
                                {
                                    data: data
                                },
                                function(data) {
                                    alert(data.text);
                                },
                                'json'
                            );
                                
//                        alert('test');  
                    };
                    reader.onerror = function() {
                        alert('Unable to read ' + file.fileName);
                    };
                }
            }   
        }

    $('#btn_cancel').click(function(){
        window.location = $_base_url + 'Sales/';
    });

    $('#download_template').click(function(){
        window.location = $_base_url + 'Sales/download_template';
    });

    $('#show_log_file').click(function(){
        window.location = $_base_url + 'Sales/log_file';
    });
});
</script>
    </head>
    <body>
        <br/><br/><br/><br/>
        <div align="center">
        <fieldset style="position: relative; width: 500px; height: 400px;">
            <legend>Upload Sales</legend>
            <br/>
            <br/>
            <table>
                <tr>
                    <td>
                        <input type="button" value="Download Template" id="download_template"  class="btn btn-primary"/>&nbsp;&nbsp;&nbsp;
                    </td>
                    <td>
                        <input type="button" value="Log File" id="show_log_file"  class="btn btn-primary"/>
                    </td>
                </tr>
            </table>

            <br/>
            <br/>
            <p>
            Sales CSV File : <input type="file" name="txtFileUpload" id="txtFileUpload" size="20" class="input_text" accept=".csv"/>
            </p>
            <br/>
            <p>
                <input type="button" value="Cancel" id="btn_cancel" class="button_cancel"/>
            </p>
        </fieldset>
        </div>
    </body>
</html>