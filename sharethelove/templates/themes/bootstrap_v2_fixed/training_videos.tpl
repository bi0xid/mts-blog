{*
-------------------------------------------------------
	iDevAffiliate HTML Front-End Template
-------------------------------------------------------
	Template   : Bootstrap 2 - Fixed Width Responsive
-------------------------------------------------------
	Copyright  : iDevDirect.com LLC
	Website    : www.idevdirect.com
-------------------------------------------------------
*}

{if isset($uploaded_training_videos)}
<div class="clearfix"></div>
<h4 class="h3bg">Training Videos</h4>
<table class="table table-bordered">{$Uploaded_Video_Tutorials}</table>
{/if}

{if isset($training_videos)}
<div class="clearfix"></div>
<h4 class="h3bg">General Affiliate Marketing</h4>
<table class="table table-bordered">{$Table_Rows_General_Affiliate_Marketing}</table>
<h4 class="h3bg">Marketing Materials</h4>
<table class="table table-bordered">{$Table_Rows_Marketing_Materials}</table>
<h4 class="h3bg">Tier System</h4>
<table class="table table-bordered">{$Table_Rows_Tier_System}</table>
<h4 class="h3bg">Advanced Affiliate Marketing</h4>
<table class="table table-bordered">{$Table_Rows_Advanced_Affiliate_Marketing}</table>
<h4 class="h3bg">Advanced Marketing Materials</h4>
<table class="table table-bordered">{$Table_Rows_Advanced_Marketing_Materials}</table>
{/if}