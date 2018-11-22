<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="<?= base_url() ?>css/backoff_ssek.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url() ?>js/utility.js" type="text/javascript"></script>


<link href="<?= base_url() ?>css/datePicker.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url() ?>js/jquery.datePicker.js" type="text/javascript"></script>

<link href="<?= base_url() ?>css/tabbed_new.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url() ?>js/jquery-1.8.0.min.js" type="text/javascript"></script>

<link href="<?=$this->config->item('base_url');?>css/style.css" rel="stylesheet" type="text/css" />

<link rel="icon" type="image/gif" href="<?= base_url() ?>images/logo_application.gif" />
<title>
    <?
    $title_ = "";
    if (isset($title)) {
        $title_ = " - " . $title;
    }
    if ($this->config->item('nama_aplikasi')):
        echo $this->config->item('nama_aplikasi').$title_;
    endif;
    ?>
</title>
</head>
<body bgcolor="#e9f4f5">
    
    <?
    if ($this->session->userdata('username')):
    ?>
        <div id="alert-box">
            <table width="100%" border="0">
            <td width="8%">
                &nbsp;<img border="0" src="<?= base_url() ?>images/new_logo.jpg"/>
            </td>
            <td valign="bottom" width="200">
                &nbsp;<b><font color="#F9FF4D" size="5">Admin Mode</font></b>
            </td>
            <?if($this->session->userdata("user_group")=='ADMIN'):?>
                <?if($this->session->userdata("mode")=='USER'):?>
                    <td valign="bottom" width="10%">
                        <b><a style="text-decoration:none" href="<?= base_url() ?>Menu_utama/change_mode"><button class="button_logout">Admin Mode</button></a></b>
                    </td>
                <?else:?>
                    <td valign="bottom" width="10%">
                        <b><a style="text-decoration:none" href="<?= base_url() ?>Menu_utama/change_mode"><button class="button_logout">User Mode</button></a></b>
                    </td>
                <?endif;?>
            <?endif;?>
            </td>
            <td valign="top" align="right">
                <table>
                    <tr>
                        <td valign="middle" align="right">
                          
                        </td>
                    </tr>
                    <tr>
                        <td valign="bottom" align="right">
                            <b><font color="#FFFFFF">Welcome <?= $this->session->userdata("emp_name") ?> </font></b>
                            <!--<b><font color="#FFFFFF">User ID. : <?= $this->session->userdata("username") ?></font></b>-->
                            <!--<b><font color="#FFFFFF">| Grup: <?= $this->session->userdata("user_group") ?> | </font></b>-->
                            <b><a style="text-decoration:none" href="<?= base_url() ?>Welcome/logout"><button class="button_logout">Log Out</button></a></b>
                        </td>
                    </tr>
                </table>
                
            </td>
        </table>
        </div>
    <?
    endif;
    ?>

<br />
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us">
<head>
	<title>jGlideMenu - Static Menu</title>
	<style  type="text/css">
		/*body { font-family: verdana, arial, sans-serif; color: #535353; font-size: .62em;  background: #f3f8f0; }*/
/*                #launch
                { font-family: tahoma,sans-serif; }*/
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

	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/jGlideMenu_ssek.css" />
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

		<!-- Tiles for Menu -->
		<ul id="tile_001" class="jGlide_001_tiles" title="Main Menu" alt="Menu list ">
                    <li><a href="<?= base_url() ?>index.php/menu_utama">Home</a></li>  
                    <?
                        $menu_admin = $this->session->userdata("admin_menu");
                        $menu_item = $this->session->userdata("menu_item_admin");
                        for($i=0;$i<count($menu_admin);$i++):?>
                            <li rel="<?=$i?>"><?=$menu_admin[$i];?></li>
                    <?  endfor;?>
		</ul>
                <?for($i=0;$i<count($menu_admin);$i++):?>
                    <ul id="<?=$i?>" class="jGlide_001_tiles" title="Menu Item" alt="<?=$menu_admin[$i];?>">
                        <?for($j=0;$j<count($menu_item[$i]);$j++):?>
                            <li><a href="<?= base_url() ?><?=$menu_item[$i][$j]['menu_link']?>"><?=$menu_item[$i][$j]['menu_name']?></a></li>
                        <?  endfor;?>
                    </ul>
                <?  endfor;?>
                
<!--		<ul id="tile_001" class="jGlide_001_tiles" title="Main Menu" alt="Menu list ">
                    <li><a href="<?= base_url() ?>index.php/menu_utama">Home</a></li>  
                    <li rel="tile_002">Master Data</li>
                    <li rel="tile_003">Employee Management</li>
                    <li rel="tile_004">User Management</li>
		</ul>
		<ul id="tile_002" class="jGlide_001_tiles" title="Master Data" alt="Application Setting">
                    <li><a href="<?= base_url() ?>index.php/master_data_type">Master Data Type</a></li>
                    <li><a href="<?= base_url() ?>index.php/country_codes">Country Codes</a></li>
                    <li><a href="<?= base_url() ?>index.php/departments">Department</a></li>
                    <li><a href="<?= base_url() ?>index.php/positions">Position</a></li>
		</ul>
		<ul id="tile_003" class="jGlide_001_tiles" title="Employee" alt="Employee menu">
			<li><a href="<?= base_url() ?>index.php/employee">Employee</a></li>
		</ul>
                
		<ul id="tile_004" class="jGlide_001_tiles" title="Tile Five" alt="Active Spot Light Link">
                        <li><a href="<?= base_url() ?>index.php/menu">Menu</a></li>
                        <li><a href="<?= base_url() ?>index.php/role">Role</a></li>
                        <li><a href="<?= base_url() ?>index.php/users">User</a></li>
                </ul>-->
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
<div id="content">
    <?= $content ?>
    
</div>

<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<?
//    print_r($this->session->userdata("menu_admin"));
//    echo"<br/>";
//    print_r($this->session->userdata("menu_item_admin"));
//    echo"<br/>";
//    print_r($this->session->userdata("all_menu"));
//    $dsn3 = 'oci8://SSEK_PROD:ssek_prod@192.168.0.40/ssekdb';
//    $this->db3= $this->load->database($dsn3, true); 
//    if(!$this->db3){
//        echo 'Gagal Konek!';
//    }else{
//        echo 'Berhasil Konek!';
//        print_r($this->db3->query("select * from employee"));
//    }

//    $db['crm']['hostname'] = "//192.168.0.40/";
//    $db['crm']['username'] = 'SSEK_PROD';
//    $db['crm']['password'] = 'ssek_prod';
//    $db['crm']['database'] = 'ssekdb';
//    $db['crm']['dbdriver'] = 'oci8';
//    $db['crm']['dbprefix'] = '';
//    $db['crm']['pconnect'] = TRUE;
//    $db['crm']['db_debug'] = TRUE;
//    $db['crm']['cache_on'] = FALSE;
//    $db['crm']['cachedir'] = '';
//    $db['crm']['char_set'] = 'utf8';
//    $db['crm']['dbcollat'] = 'utf8_general_ci';
//    $db['crm']['swap_pre'] = '';
//    $db['crm']['autoinit'] = TRUE;
//    $db['crm']['stricton'] = FALSE; 
//    
//    $db2 = $this->load->database('crm',true);
//    if(!$db2){
//        echo 'Gagal Konek!';
//    }else{
//        echo 'Berhasil Konek!';
//        $test = $db2->query("select * from employee", TRUE);
//    }
?>
<?
    if ($this->session->userdata('username')):
      $this->load->view('vfooter');
    endif;
?>

</body>
</html>