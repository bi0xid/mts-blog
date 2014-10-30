<?PHP

$control_panel_session = true;
include_once("includes/control_panel.php");

if (isset($_SERVER['HTTP_REFERER'])) { $clickref = $_SERVER['HTTP_REFERER']; } else { $clickref = null; }

$id = check_type('id');
$page = check_type('page');
$peel = check_type('peel');

$get_peel = mysql_query("select * from idevaff_peels where number = '$peel'");
if (mysql_num_rows($get_peel)) {

$peel_data = mysql_fetch_array($get_peel);
$group = $peel_data['grp'];
$image500 = $base_url . '/media/pagepeels/' . $peel_data['image500'];

if (isset($page)) {
$page = '&page=' . $page;
} else {
$page = null;
}

$urltodeliver = $base_url . '/' . $filename . '.php?id=' . $id . '&clickref=' . $clickref . "&set=6&link=" . $peel . $page;

}

?>

    $(function() {
      $('body').peelback({
        adImage  : '<?PHP echo $image500; ?>',
        peelImage  : '<?PHP echo $base_url; ?>/templates/source/pagepeels/peel-image.png',
        clickURL : '<?PHP echo $urltodeliver; ?>',
        smallSize: 50,
        bigSize: 500,
        gaTrack  : true,
        gaLabel  : '',
        autoAnimate: true
      });
    });
