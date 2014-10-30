
function copyToClipBoard(sContents)
{
window.clipboardData.setData("Text", sContents);
alert("The contents have been copied to your clipboard.\t");
}