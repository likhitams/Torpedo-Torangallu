<style>
	.badge{padding-right:9px;padding-left:9px;-webkit-border-radius:9px;-moz-border-radius:9px;border-radius:9px}
    .badge-warning{background-color:#F0AD4E}
    .badge-success{background-color:#00A65A}
    .badge-danger{background-color:#F56954}
    .badge-new{background-color:#00C0EF}
	.addoverlay 
	{
    background-color: black;
    left: 0;
    opacity: 0.4;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: 10000;
	}
	PRE 
	{
	PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; PADDING-TOP: 0px
	}
	.dg_left 
	{
	TEXT-ALIGN: left
	}
	.dg_center 
	{
	TEXT-ALIGN: center
	}
	.dg_right 
	{
	TEXT-ALIGN: right
	}
	.dg_nowrap 
	{
	WHITE-SPACE: nowrap
	}
	.dg_underline 
	{
	TEXT-DECORATION: underline
	}
	.resizable-textarea .grippie 
	{
	BORDER-BOTTOM: #d2d0bb 1px solid; BORDER-LEFT: #d2d0bb 1px solid; HEIGHT: 6px; OVERFLOW: hidden; BORDER-TOP: #d2d0bb 1px solid; CURSOR: s-resize; BORDER-RIGHT: #d2d0bb 1px solid
	}
	A.default_dg_a 
	{
	FONT-FAMILY: Tahoma; BACKGROUND: none transparent scroll repeat 0% 0%; COLOR: #72705b; FONT-SIZE: 12px; TEXT-DECORATION: none
	}
	A.default_dg_a:link 
	{
	FONT-FAMILY: Tahoma; BACKGROUND: none transparent scroll repeat 0% 0%; COLOR: #72705b; FONT-SIZE: 12px; TEXT-DECORATION: none
	}
	A.default_dg_a:hover 
	{
	FONT-FAMILY: Tahoma; BACKGROUND: none transparent scroll repeat 0% 0%; COLOR: #f0c030; FONT-SIZE: 12px; TEXT-DECORATION: none
	}
	A.default_dg_a:visited 
	{

	}
	A.default_dg_a2 
	{
	FONT-FAMILY: Tahoma; BACKGROUND: none transparent scroll repeat 0% 0%; COLOR: #72705b; FONT-SIZE: 12px; TEXT-DECORATION: none
	}
	A.default_dg_a2:link 
	{
	FONT-FAMILY: Tahoma; BACKGROUND: none transparent scroll repeat 0% 0%; COLOR: #72705b; FONT-SIZE: 12px; TEXT-DECORATION: none
	}
	A.default_dg_a2:hover 
	{
	FONT-FAMILY: Tahoma; BACKGROUND: none transparent scroll repeat 0% 0%; COLOR: #ffcc33; FONT-SIZE: 12px; TEXT-DECORATION: none
	}
	A.default_dg_a2:visited 
	{
	FONT-FAMILY: Tahoma; BACKGROUND: none transparent scroll repeat 0% 0%; COLOR: #72705b; FONT-SIZE: 12px; TEXT-DECORATION: none
	}
	A.default_dg_a_header 
	{
	FONT-FAMILY: Tahoma; BACKGROUND: none transparent scroll repeat 0% 0%; COLOR: #72705b; FONT-SIZE: 12px; TEXT-DECORATION: none
	}
	A.default_dg_a_header:link 
	{
	FONT-FAMILY: Tahoma; BACKGROUND: none transparent scroll repeat 0% 0%; COLOR: #72705b; FONT-SIZE: 12px; TEXT-DECORATION: none
	}
	A.default_dg_a_header:hover 
	{
	FONT-FAMILY: Tahoma; BACKGROUND: none transparent scroll repeat 0% 0%; COLOR: #f0c030; FONT-SIZE: 12px; TEXT-DECORATION: none
	}
	A.default_dg_a_header:visited 
	{

	}
	.default_dg_fieldset 
	{
	BORDER-BOTTOM: #dddddd 1px solid; BORDER-LEFT: #dddddd 1px solid; MARGIN: 0px; BORDER-TOP: #dddddd 1px solid; BORDER-RIGHT: #dddddd 1px solid
	}
	.default_dg_filter_table 
	{
	BORDER-BOTTOM: #d0d0d0 0px solid; BORDER-LEFT: #d0d0d0 0px solid; FONT: 12px Tahoma; BORDER-TOP: #d0d0d0 0px solid; BORDER-RIGHT: #d0d0d0 0px solid
	}
	.default_dg_legend 
	{
	FONT: 12px Tahoma
	}
	.default_dg_paging_table 
	{
	BORDER-BOTTOM: #d0d0d0 0px solid; BORDER-LEFT: #d0d0d0 0px solid; FONT: 12px Tahoma; BORDER-TOP: #d0d0d0 0px solid; BORDER-RIGHT: #d0d0d0 0px solid
	}
	.default_dg_table 
	{
	 FONT: 12px Tahoma; background:#fff;
	}

	.default_dg_td.dg_left.dg_nowrap > input {  border: 1px solid #CCCCCC;    border-radius: 2px 2px 2px 2px;    height: 25px;    width: 184px;}

	.default_dg_td.dg_left.dg_nowrap > select { font: 12px/37px arial;    height: 25px;    padding: 4px;    width: 180px;}

	.default_dg_th 
	{
	/*BORDER-BOTTOM: #ffcc33 2px solid; PADDING-BOTTOM: 2px; PADDING-LEFT: 5px; PADDING-RIGHT: 2px; FONT: bold 13px Tahoma; COLOR: #333333; BORDER-RIGHT: #d2d0bb 2px solid; PADDING-TOP: 2px*/
	}
	.default_dg_th_normal 
	{
	BORDER-BOTTOM: #d2d0bb 2px solid; BORDER-LEFT: #e1e2e3 2px solid; PADDING-BOTTOM: 2px; BACKGROUND-COLOR: #e2e0cb; PADDING-LEFT: 5px; PADDING-RIGHT: 2px; FONT: bold 13px Tahoma; COLOR: #333333; MARGIN-LEFT: 0px; BORDER-RIGHT: #d2d0bb 2px solid; PADDING-TOP: 2px
	}
	.default_dg_th_selected 
	{
	BORDER-BOTTOM: #cd0000 2px solid; PADDING-BOTTOM: 2px; BACKGROUND-COLOR: #e2e0cb; PADDING-LEFT: 5px; PADDING-RIGHT: 2px; FONT: bold 13px Tahoma; COLOR: #333333; BORDER-RIGHT: #d2d0bb 2px solid; PADDING-TOP: 2px
	}
	.default_dg_td 
	{
	 padding:2px 6px;
	}
	.default_dg_td_main 
	{
	BORDER-LEFT: #e1e2e3 1px solid; PADDING-BOTTOM: 2px; PADDING-LEFT: 6px; PADDING-RIGHT: 6px; FONT: 12px Tahoma; BORDER-TOP: #f1efe2 1px solid; BORDER-RIGHT: #fefefe 1px solid; PADDING-TOP: 2px
	}
	.default_dg_td_selected 
	{
	BORDER-BOTTOM: #f1efe2 1px solid; BORDER-LEFT: #f1efe2 1px solid; PADDING-BOTTOM: 2px; PADDING-LEFT: 6px; PADDING-RIGHT: 6px; FONT: 12px Tahoma; BORDER-TOP: #f1efe2 1px solid; BORDER-RIGHT: #f1efe2 1px solid; PADDING-TOP: 2px
	}
	.default_dg_button 
	{
	BORDER-BOTTOM: #b2b09b 1px solid; BORDER-LEFT: #ffffff 1px solid; PADDING-BOTTOM: 2px; BACKGROUND-COLOR: #e2e0cb; PADDING-LEFT: 5px; PADDING-RIGHT: 2px; FONT: bold 12px Tahoma; COLOR: #333333; BORDER-TOP: #ffffff 2px solid; BORDER-RIGHT: #b2b09b 1px solid; PADDING-TOP: 2px
	}
	.default_dg_select 
	{
	BORDER-BOTTOM: #b2b09b 1px solid; BORDER-LEFT: #b2b09b 1px solid; BACKGROUND-COLOR: #fcfaf6; FONT: 12px Tahoma; BORDER-TOP: #b2b09b 1px solid; BORDER-RIGHT: #b2b09b 1px solid
	}
	.default_dg_label 
	{
	FONT-FAMILY: Tahoma; FONT-SIZE: 12px
	}
	.default_dg_textbox 
	{
	BORDER-BOTTOM: #b2b09b 1px solid; BORDER-LEFT: #b2b09b 1px solid; PADDING-LEFT: 3px; WIDTH: 210px; FONT: 12px Tahoma; BORDER-TOP: #b2b09b 1px solid; BORDER-RIGHT: #b2b09b 1px solid
	}
	.default_dg_checkbox 
	{
	BORDER-BOTTOM: 0px; BORDER-LEFT: 0px; WIDTH: 20px; FONT: 12px Tahoma; BORDER-TOP: 0px; BORDER-RIGHT: 0px
	}
	.default_dg_radiobutton 
	{
	BORDER-BOTTOM: 0px; BORDER-LEFT: 0px; WIDTH: 20px; FONT: 12px Tahoma; BORDER-TOP: 0px; BORDER-RIGHT: 0px
	}
	.default_dg_caption 
	{
	TEXT-ALIGN: center; PADDING-BOTTOM: 0px; FONT: bold 14px Tahoma
	}
	.default_dg_error_message 
	{
	FONT: 12px Tahoma; COLOR: #ff8822
	}
	.default_dg_ok_message 
	{
	FONT: 12px Tahoma; COLOR: #449944
	}

	.alpha30{float:left; padding:6px; background:#333 transparent;background:rgba(51,51,51,0.3);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#4C333333',endColorstr='#4C333333');-ms-filter:"progid:DXImageTransform.Microsoft.gradient(startColorstr=#4C333333, endColorstr=#4C333333)";}

	.white{padding:5px 0px 15px;	background-color:#FFFFFF;	text-decoration: none; height:auto; float:left;   }

	#close-b span {background-image:url(<?php echo asset_url();?>images/close_pop.png);	background-repeat: no-repeat;	background-position: left top;	float: left;
	height: 30px;	width: 30px; cursor:pointer; }

	.bmargin10{margin-bottom:10px}

	.lmargin249{margin-left:249px}

	#close-b {float: right;	height: 30px;	width: 270px;}
	.cart-tabs{font-family:tahoma,verdana,arial,sans-serif;}

	.cart-tabs .tab{float:left;padding:5px 10px;margin-left:5px;margin-top:6px;font-weight:normal;background-color:#e4e4e4;border-radius:3px 3px 0 0;-moz-border-radius:3px 3px 0 0;}

	.cart-tabs .tab.selected{padding:8px 10px;margin-top:0;font-weight:bold;}
	#cart-tab.tab.selected{ background-color:#fff;}
	.lastUnit {overflow: hidden;}
	body 
	{
	padding-bottom: 40px;
	}
	.sidebar-nav 
	{
	padding: 9px 0;
	}
	
	</style>