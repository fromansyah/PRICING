<script type="text/javascript">
$(document).ready(function(){
    var base_url = '<?= base_url() ?>';

    $('#btn_merk').click(function(){
        window.location = base_url + 'index.php/merk';
    });

    $('#btn_master_brg').click(function(){
        window.location = base_url + 'index.php/master_brg';
    });


});
</script>

<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us">
<head>
	<title>jGlideMenu - Static Menu</title>
	<style  type="text/css">
		body { font-family: verdana, arial, sans-serif; color: #535353; font-size: .62em;  background: #f3f8f0; }
                #launch
                { font-family: tahoma,sans-serif; }
                a#launch
                { text-decoration: none; color: #535353; }
                a#launch:HOVER
                { text-decoration: underline; color: #f90; }
		.ifM_header
		{ cursor: Move; }
		#overview a { color: darkgreen; text-decoration: none; }
		#overview a:HOVER { color: #f90; }
		#jGlide_001 { top: 85px; left: 10px; display: none; /* Hide Menu Until Ready(Optional) */ }
	</style>

	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/jGlideMenu.css" />
	<script type="text/javascript" src="<?= base_url() ?>js/jQuery.jGlideMenu.067.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			// Initialize Menu
			$('#jGlide_001').jGlideMenu({
				tileSource	: '.jGlide_001_tiles' , 
				demoMode	: false 
			}).show();

			// Connect "Toggle" Link	
			$('#switch').click(function(){$(this).jGlideMenuToggle();});
		});
	</script>
</head>
<body>

<div class="jGM_box" id="jGlide_001">

		This is Example One

		<!-- Tiles for Menu -->
		<ul id="tile_001" class="jGlide_001_tiles" title="Main Menu" alt="Menu list">
                        <li rel="tile_002">Master Data</li>
			<li rel="tile_003">Employee</li>
			<li rel="tile_004">Report</li>
		</ul>
		<ul id="tile_002" class="jGlide_001_tiles" title="Master Data" alt="Application Setting">
			<li rel="tile_005">Click Here</li>
			<li><a href="<?= base_url() ?>index.php/master_data_type">Master Data Type</a></li>
                        <li><a href="<?= base_url() ?>index.php/country_codes">Country Codes</a></li>
                        <li><a href="<?= base_url() ?>index.php/departments">Department</a></li>
                        <li><a href="<?= base_url() ?>index.php/positions">Position</a></li>
                        <li><a href="<?= base_url() ?>index.php/depnaker_pph21">PPH21</a></li>
                        <li><a href="<?= base_url() ?>index.php/depnaker_ptkp_setup">PTKP</a></li>
                        <li><a href="<?= base_url() ?>index.php/ssek_ot">SSEK Overtime</a></li>
                        <li><a href="<?= base_url() ?>index.php/depnaker_ot">Depnaker Overtime</a></li>
                        <li><a href="<?= base_url() ?>index.php/jamsostek">Jamsostek</a></li>
                        <li><a href="<?= base_url() ?>index.php/ssek_allowance">SSEK Allowance</a></li>
                        <li><a href="<?= base_url() ?>index.php/ssek_ot_setting">Overtime Rule Setting</a></li>
                        <li><a href="<?= base_url() ?>index.php/ssek_ot_setting">SSEK Monthly Cut Off Date</a></li>
                        <li><a href="<?= base_url() ?>index.php/ssek_thr">SSEK THR Setup</a></li>
                        <li><a href="<?= base_url() ?>index.php/ssek_medical">SSEK Medical Setup</a></li>
                                               
                        
		</ul>
		<ul id="tile_003" class="jGlide_001_tiles" title="Employee" alt="Employee menu">
			<li><a href="<?= base_url() ?>index.php/employee">Employee</a></li>
                        <li><a href="<?= base_url() ?>index.php/employee_payment/payment">Employee Payment</a></li>
                        
		</ul>
		<ul id="tile_004" class="jGlide_001_tiles" title="Reports" alt="All report on the application">
                        <li><a href="<?= base_url() ?>index.php/employee/recap_salary_per_month">Recap Salary per Month</a></li>
                        
                </ul>
                
                
		<ul id="tile_005" class="jGlide_001_tiles" title="Tile Five" alt="Active Spot Light Link">
                        <li><a href="">Test Link</a></li>
                </ul>
		<!-- Tiles for Menu -->
</div>
<!-- Menu Holder -->
</body>
<script type="text/javascript" src="/resources/js/plugins/google/analytics/gatag.js"></script>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7365212-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</html>
