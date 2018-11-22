<link href="<?= base_url() ?>css/menu.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url() ?>js/menu.js" type="text/javascript"></script>
<link href="<?= base_url() ?>css/style.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/flexigrid.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?= base_url() ?>js/flexigrid.pack.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/datetimepicker_css.js"></script>


        <ul id="nav">
            <li><a href="<?= base_url() ?>index.php/"><img src="<?= base_url() ?>images/001_20.gif"/></a>
            </li>
            <li><a href="#">Master Data</a>
                <ul>
                    <li><a href="<?= base_url() ?>index.php/master_data_type">Master Data Type</a></li>
                    <li><a href="<?= base_url() ?>index.php/country_codes">Country Codes</a></li>
                    <li><a href="<?= base_url() ?>index.php/departments">Department</a></li>
                    <li><a href="<?= base_url() ?>index.php/positions">Position</a></li>
                </ul>
            </li>
            <li><a href="#">Employee</a>
                <ul>
                    <li><a href="<?= base_url() ?>index.php/employee">Employee Mgmt.</a></li>
                </ul>
            </li>
            <li><a href="<?= base_url() ?>index.php/users">User</a>
                <ul>
                    <li><a href="<?= base_url() ?>index.php/employee">User Mgmt.</a></li>
                </ul>
            </li>
        </ul>