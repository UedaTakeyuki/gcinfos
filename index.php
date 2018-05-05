<?php
require_once("common/common.php");
require_once('mccmnc.class.php');
define("TITLE","Info");

# ヘッダの表示
error_log('['.basename(__FILE__).':'.__LINE__.']'.' *** RENDERING START ***');    
show_html_head(TITLE);

/**
 * Make widht of mask on fa-signal.
 *
 * @param int $sq sq value of modem.
 * @return int width (.em).
 */
function ss_width($sq){
  if ($sq == 0){
    return 0.0;
  } elseif ($sq == 1 or $sq == 2){
    return 0.2;
  } elseif ($sq >= 3 and $sq <= 9){
    return 0.4;
  } elseif ($sq >= 10 and $sq <= 14){
    return 0.7;
  } elseif ($sq >= 15 and $sq <= 19){
    return 0.9;
  } elseif ($sq >= 20 and $sq <= 30){
    return 1.2;
  }
}
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
        <span class="fa-stack fa-lg">
        <i class="fa fa-signal fa-stack-1x" style="opacity:.3"></i>
        <i class="fa fa-signal fa-stack-1x" style="overflow:hidden; width:<?= ss_width($modem_ini[CSQ][csq])?>em; margin-left:0.4em;"></i>
        <!-- 0.0em 0.2em 0.4em 0.7em 0.9em 1.2em -->
        </span>
        <p>signal quality: <?= $modem_ini[CSQ][csq] ?></p>
        <p>rssi: <?= $modem_ini[CSQ][rssi] ?></p>
        <p>condition: <?= $modem_ini[CSQ][condition] ?></p>

<?php endif; ?>
</div><!-- <div data-role="content" data-theme="c" class="no-cache">-->

<?php show_html_jquery_footer(); ?>
</div> <!-- page -->


</body>
</html>
