<img src='{$module_dir}img/blockadvertmulti.png' class="ba_logo" />
<b>{l s='This module allows you to include as many banners as you like.' mod='blockadvertmulti'}</b><br />
<br />{l s='You can upload, order, activate or deactivate as many banners and select if you want them in the top/right/left/footer.' mod='blockadvertmulti'}<br />
<br /><br />
<a href="" onclick="addBanner();return false;"><img border="0" src="../img/admin/add.gif"> {l s='Add a new banner' mod='blockadvertmulti'} </a>
<div>
	<div class="tab-pane" id="tab-pane-bnr" style="width:100%;margin:10px 0 0">
		<script type="text/javascript">
			var tabPaneBnr = new WebFXTabPane( document.getElementById( "tab-pane-bnr" ) );
		</script>
		<input type="hidden" name="tabs" id="tabs" value="{$block}" />
		<div class="tab-page" id="tab-page-1">
			<h4 class="tab">{l s='General Configuration' mod='blockadvertmulti'} </h4>
			{include file="./blockadvertmulti_cfg.tpl" }
		</div>
		<div class="tab-page" id="tab-page-2">
			<h4 class="tab">{l s='Top Banners' mod='blockadvertmulti'} </h4>
			{include file="./blockadvertmulti_tbl.tpl" block="1" title="Top" banners=$banners_1 }
		</div>
		<div class="tab-page" id="tab-page-3">
			<h4 class="tab">{l s='Left Banners' mod='blockadvertmulti'} </h4>
			{include file="./blockadvertmulti_tbl.tpl" block="2" title="Left" banners=$banners_2 }
		</div>
		<div class="tab-page" id="tab-page-4">
			<h4 class="tab">{l s='Right Banners' mod='blockadvertmulti'} </h4>
			{include file="./blockadvertmulti_tbl.tpl" block="3" title="Right" banners=$banners_3 }
		</div>
		<div class="tab-page" id="tab-page-5">
			<h4 class="tab">{l s='Home Banners' mod='blockadvertmulti'} </h4>
			{include file="./blockadvertmulti_tbl.tpl" block="4" title="Home" banners=$banners_4 }
		</div>
		<div class="tab-page" id="tab-page-6">
			<h4 class="tab">{l s='Footer Banners' mod='blockadvertmulti'} </h4>
			{include file="./blockadvertmulti_tbl.tpl" block="5" title="Footer" banners=$banners_5 }
		</div>
		<script type="text/javascript">
		setupAllTabs();
		</script>
	</div>
	<div class="clear"></div>
</div>
{include file="./blockadvertmulti_add.tpl"}
