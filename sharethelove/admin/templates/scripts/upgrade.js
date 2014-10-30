
Event.observe(window, 'load', function () { setTimeout('showUpgradeImage()', 50) } );
function showUpgradeImage() {
var tmp = document.getElementById('upgradeImage');
if (tmp && myLightbox) {
myLightbox.start(tmp); } };
