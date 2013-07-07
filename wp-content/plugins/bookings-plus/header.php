<?php
global $wpdb;
$url = plugins_url('', __FILE__);
?>
<style type="text/css">
html, body, div, span, legend
{
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	vertical-align: baseline;
}
body{clear: both;padding:1px; font-size: 12px; line-height: 22px; color: #5f5f5f; height: 100%;}

img { border: none; }
textarea { overflow: auto; }
textarea, input, input[type=text], input[type=password] { font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
button, input[type=submit], input[type=button] { font-family: Arial, Helvetica, sans-serif; cursor: pointer; }
ol, ul { list-style: none; }
blockquote, q { quotes: none; }
blockquote:before, blockquote:after, q:before, q:after { content: ''; content: none; }
a { text-decoration: none; }
*, * focus { outline: none; margin: 0; padding: 0; }
input::-moz-focus-inner { border:0; padding:0 }
.hideControl{display: none !important}



p { margin: 0 0 10px; }
small { font-size: 85%; }
strong { font-weight: bold; }
em { font-style: italic; }
cite { font-style: normal; }
.muted { color: #999999; }
.text-warning { color: #c09853; }
.text-error { color: #b94a48; }
.text-info { color: #3a87ad; }
.text-success { color: #468847; }

h1, h2, h3, h4, h5, h6 { margin: 10px 0; font-family: inherit; font-weight: bold; color: inherit; text-rendering: optimizelegibility; }
h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-weight: normal; line-height: 1; color: #999999; margin-left: 12px; }
h1 { font-size: 36px; line-height: 40px; }
h2 { font-size: 30px; line-height: 40px; }
h3 { font-size: 24px; line-height: 40px; }
h4 { font-size: 18px; }
h5 { font-size: 14px; }
h6 { font-size: 12px; }
h1 small { font-size: 24px; }
h2 small { font-size: 18px; }
h3 small { font-size: 14px; }
h4 small { font-size: 14px; }

dt, dd { line-height: 20px; }
dt { font-weight: bold; }
dd { margin-left: 10px; }
.dl-horizontal { *zoom: 1; }
.dl-horizontal:before, .dl-horizontal:after { display: table; content: ""; line-height: 0; }
.dl-horizontal:after { clear: both; }
.dl-horizontal dt { float: left; width: 160px; clear: left; text-align: right; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.dl-horizontal dd { margin-left: 180px; }
hr { margin: 20px 0; border: 0; border-top: 1px solid #eeeeee; border-bottom: 1px solid #ffffff; }
abbr[title] { cursor: help; border-bottom: 1px dotted #999999; }
abbr.initialism { font-size: 90%; text-transform: uppercase; }
blockquote { padding: 0 0 0 15px; border-left: 5px solid #eeeeee; }
blockquote p { margin-bottom: 0; font-size: 14px; }
blockquote small { display: block; line-height: 20px; color: #999999; }
blockquote small:before { content: '\2014 \00A0'; }
blockquote.pull-right { float: right; padding-right: 15px; padding-left: 0; border-right: 5px solid #eeeeee; border-left: 0; }
blockquote.pull-right p, blockquote.pull-right small { text-align: right; }
blockquote.pull-right small:before { content: ''; }
blockquote.pull-right small:after { content: '\00A0 \2014'; }
q:before, q:after, blockquote:before, blockquote:after { content: ""; }
code, pre { padding: 0 3px 2px; font-family: Monaco, Menlo, Consolas, "Courier New", monospace; font-size: 12px; color: #333333; }
code { padding: 2px 6px; color: #ca3131; background-color: #f7f7f9; border: 1px solid #e1e1e8; font-size: 11px; }
pre { display: block; padding: 8px; font-size: 12px; line-height: 20px; word-break: break-all; word-wrap: break-word; white-space: pre; white-space: pre-wrap; background-color: #f5f5f5; border: 1px solid #ccc; border: 1px solid rgba(0, 0, 0, 0.15); -webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px; }
pre code { padding: 0; color: inherit; background-color: transparent; border: 0; }
.pre-scrollable { max-height: 340px; overflow-y: scroll; }

table { max-width: 100%; background-color: transparent; border-collapse: collapse; border-spacing: 0; }
.table { width: 100%; }
.table th, .table td { padding: 8px 12px; line-height: 20px; vertical-align: middle; border-top: 1px solid #e2e2e2; }
.table td { background: #fefefe; }
.table th { font-weight: bold; text-align: left; }
.table thead th { background-color: #f8f8f8; }




fieldset { padding: 0; margin: 0; border: 0; }
legend { display: block; width: 100%; padding: 0; font-size: 16px; line-height: 40px; color: #5F5F5F; border: 0; border-bottom: 1px solid #E5E5E5; box-shadow: 0 1px 0 white; -webkit-box-shadow: 0 1px 0 white; -moz-box-shadow: 0 1px 0 white; font-weight: bold; }
legend small { font-size: 15px; color: #999999; }
label {display: inline-block; }
select, textarea, 
input[type="text"], 
input[type="password"], 
input[type="datetime"], 
input[type="datetime-local"], 
input[type="date"], 
input[type="month"], 
input[type="time"], 
input[type="week"], 
input[type="number"], 
input[type="email"], 
input[type="url"], 
input[type="search"], 
input[type="tel"], 
input[type="color"], 
.uneditable-input  { display: inline-block; padding: 8px 7px; font-size: 11px; color: #5F5F5F; font-family: Arial, Helvetica, sans-serif; -webkit-appearance: none !important; -webkit-border-radius: 0 !important; border-radius: 0 !important; -moz-border-radius: 0 !important;  }

input[type="search"] { -webkit-border-radius: 0; -moz-border-radius: 0; -webkit-appearance: none; }
input[disabled], select[disabled], textarea[disabled], input[readonly], select[readonly], textarea[readonly] { cursor: not-allowed; background-color: #f5f5f5; color: #999999; }
input[type=submit][disabled], input[type=button][disabled] { color: #fff; }
input[type="radio"][disabled], input[type="checkbox"][disabled], input[type="radio"][readonly], input[type="checkbox"][readonly] { background-color: transparent; }
textarea { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; -ms-box-sizing: border-box; }
select { width: 220px; height: 30px; padding: 6px; border: 1px solid #cccccc; background-color: #ffffff; }
select:focus { box-shadow: none; -webkit-box-shadow: none; -moz-box-shadow: none; }

textarea, 
input[type="text"], 
input[type="password"], 
input[type="datetime"], 
input[type="datetime-local"], 
input[type="date"], 
input[type="month"], 
input[type="time"], 
input[type="week"], 
input[type="number"], 
input[type="email"], 
input[type="url"], 
input[type="search"], 
input[type="tel"], 
input[type="color"], 
.uneditable-input  { background-color: #ffffff; border: 1px solid #dadada; 
	-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.02), 0 1px 0 #ffffff; 
	-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.02), 0 1px 0 #ffffff; 
	box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.02), 0 1px 0 #ffffff; 
}

input[type="text"], 
input[type="password"], 
input[type="datetime"], 
input[type="datetime-local"], 
input[type="date"], 
input[type="month"], 
input[type="time"], 
input[type="week"], 
input[type="number"], 
input[type="email"], 
input[type="url"], 
input[type="search"], 
input[type="tel"], 
input[type="color"] { height: 30px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; -ms-box-sizing: border-box; }

input[class*="span"], 
select[class*="span"], 
textarea[class*="span"], 
.uneditable-input[class*="span"], 
.row-fluid input[class*="span"], 
.row-fluid select[class*="span"], 
.row-fluid textarea[class*="span"], 
.row-fluid .uneditable-input[class*="span"] { float: none; margin-left: 0; }

.input-append input[class*="span"], 
.input-append .uneditable-input[class*="span"], 
.input-prepend input[class*="span"], 
.input-prepend .uneditable-input[class*="span"], 
.row-fluid input[class*="span"], 
.row-fluid select[class*="span"], 
.row-fluid textarea[class*="span"], 
.row-fluid .uneditable-input[class*="span"], 
.row-fluid .input-prepend [class*="span"], 
.row-fluid .input-append [class*="span"] { display: inline-block; }

input[type="radio"], input[type="checkbox"] { *margin-top: 0; margin-top: 1px \9; line-height: normal; cursor: pointer; }
input[type="file"], input[type="image"], input[type="submit"], input[type="reset"], input[type="button"], input[type="radio"], input[type="checkbox"] { width: auto; }

.uneditable-input, .uneditable-textarea { color: #999999; background-color: #fcfcfc; border-color: #cccccc; -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.025); -moz-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.025); box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.025); cursor: not-allowed; }
.uneditable-input { overflow: hidden; white-space: nowrap; }
.uneditable-textarea { width: auto; height: auto; }

</style>
<script type="text/javascript">
  var __lc = {};
  __lc.license = 2078171;

  (function() {
    var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
    lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
  })();
</script>
<div class="row-fluid nested" style="margin-top:5px;">
	<a href="http://bookings-plus.com/" target="_blank"><img src="<?php echo plugins_url('/images/logo.png', __FILE__); ?>" alt="" /></a>
	<a href="http://bookings-plus.com/" target="_blank"><img src="<?php echo plugins_url('/images/banner.png', __FILE__); ?>" style="float:right;margin-right:5px;" alt="" /></a>
	
</div>
