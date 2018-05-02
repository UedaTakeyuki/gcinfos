<?php
require_once("common/common.php");
require_once('mccmnc.class.php');
define("TITLE","Info");

# ヘッダの表示
error_log('['.basename(__FILE__).':'.__LINE__.']'.' *** RENDERING START ***');    
show_html_head(TITLE);
?>

<body>

<div data-role="page" id="new"> 
	  
<div data-role="header" data-position="fixed" data-theme="b">
    <h1><?php echo TITLE; ?></h1>
    <!-- <a href="index.php" data-icon="forward" data-transition="fade" data-ajax="false">時刻合わせ</a> -->
</div>

<div data-role="content" data-theme="c" class="no-cache">
<?php if (file_exists("/tmp/modem.ini")): ?>
<?php   $configfile = "/tmp/modem.ini";
        $modem_ini = parse_ini_file($configfile, TRUE);
?>

        <h3>modem device</h3>
        <p>modem name: <?= $modem_ini[model][name] ?></p>

        <h3>sim info</h3>
        <p>vendor name: <?= $modem_ini[IMSI][carrier] ?></p>
        <p>IMSI: <?= $modem_ini[IMSI][imsi] ?></p>

        <h3>connecting  info</h3>
        <p>operator: <?= mccmnc::operator($modem_ini[carrier][cop]) ?></p>
        <p>country: <?= mccmnc::country($modem_ini[carrier][mcc]) ?></p>

        <h3>connecting  quality</h3>
        <p>signal quality: <?= $modem_ini[CSQ][csq] ?></p>
        <p>rssi: <?= $modem_ini[CSQ][rssi] ?></p>
        <p>condition: <?= $modem_ini[CSQ][condition] ?></p>

<?php endif; ?>
</div><!-- <div data-role="content" data-theme="c" class="no-cache">-->

<?php show_html_jquery_footer(); ?>
</div> <!-- page -->


</body>
</html>
