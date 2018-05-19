<?php
require_once("../gc_common/common.php");
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
    return 0.5;
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
	  
<div data-role="header" data-position="fixed">
    <h1><?php echo TITLE; ?></h1>
    <a href="../../index.php"  data-icon="back">Back</a>
</div>

<div data-role="content" data-theme="c" class="no-cache">
  <h1>modem</h1><hr>

<?php if (file_exists("/tmp/modem.ini")): ?>
<?php   $configfile = "/tmp/modem.ini";
        $modem_ini = parse_ini_file($configfile, TRUE);
?>
  <h2>device</h2>
  <p>product: <b><?= $modem_ini[model][name] ?></b></p>

  <h2>sim info</h2>
  <p>vendor: <b><?= $modem_ini[IMSI][carrier] ?></b></p>
  <p>IMSI: <b><?= $modem_ini[IMSI][imsi] ?></b></p>

  <h2>connection  info</h2>
  <p>operator: <b><?= mccmnc::operator($modem_ini[carrier][cop]) ?></b></p>
  <p>country: <b><?= mccmnc::country($modem_ini[carrier][mcc]) ?></b></p>

  <h2>radio  quality</h2>
  <span class="fa-stack fa-lg">
  <i class="fa fa-signal fa-stack-1x" style="opacity:.3"></i>
  <i class="fa fa-signal fa-stack-1x" style="overflow:hidden; width:<?= ss_width($modem_ini[CSQ][csq])?>em; margin-left:0.4em;"></i>
  <!-- 0.0em 0.2em 0.5em 0.7em 0.9em 1.2em -->
  </span>
  <p>signal quality: <b><?= $modem_ini[CSQ][csq] ?>/30</b></p>
  <p>rssi: <b><?= $modem_ini[CSQ][rssi] ?></b></p>
  <p>condition: <b><?= $modem_ini[CSQ][condition] ?></b></p>

<?php else: ?>
  <h2>No Device</h2>
<?php endif; ?>

  <h1>Board</h1><hr>
  <p>serial id: <b><?= `python -m piserialnumber` ?></b></p>

  <h1>Software</h1><hr>
  <p>version: <b><?= `cat /boot/gc_issue.txt | grep -e "^-" | tail -n 1 | tr -d "\- "` ?></b></p>

</div><!-- <div data-role="content" data-theme="c" class="no-cache">-->

<?php show_html_footer(); ?>
</div> <!-- page -->


</body>
</html>
