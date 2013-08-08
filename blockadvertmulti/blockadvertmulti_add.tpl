<script language="javascript">
	{literal}
	function deleteBanner(bnr, question) {
		if (confirm(question)){
			document.deleteBannerForm.bannerDelete.value = bnr;
			document.deleteBannerForm.deleteSubmit.click();
		} else {
			return false;
		}
	}
	function addBanner() {
		document.getElementById('addBanner').style.display = '';
		document.getElementById('addBanner').scrollIntoView();
	}
	{/literal}
</script>
<br/><br/>
<!--Add new banner -->
<div style="display:none;" id="addBanner" name="addBanner">
<form action="{$smarty.server.REQUEST_URI}" method="post" enctype="multipart/form-data">
<fieldset class="mod_blockadvertmulti">
    <legend><img src="../img/admin/add.gif" />{l s='Add new banner' mod='blockadvertmulti'}</legend>
    <span>{l s='Provide the following information to create a new banner' mod='blockadvertmulti'}</span><br /><br />
    <label for="banner_description">{l s='Banner description' mod='blockadvertmulti'}</label>
    <div class="margin-form">
        <input type="text" name="banner_description" size="30" />
    </div>
    <br />
	<label for="banner_link">{l s='Banner link' mod='blockadvertmulti'}</label>
    <div class="margin-form">
        <input type="text" name="banner_link" size="80" />
        <p>{l s='Provide full URL for link the banner (e.g. http://www.prestashop.com/forums/user/286018-felibv/' mod='blockadvertmulti'}</p>
    </div>
    <br />
	<label for="banner_order">{l s='Banner order' mod='blockadvertmulti'}</label>
    <div class="margin-form">
        <input type="text" name="banner_order" size="2" maxlength="2" />
        <p>{l s='Order of the banner within the block' mod='blockadvertmulti'}</p>
    </div>
    <br />
	<label for="banner_block_id">{l s='Block space' mod='blockadvertmulti'}</label>
    <div class="margin-form">
        <label for="banner_block_id_top" class="t"> {l s='Top' mod='blockadvertmulti'}</label>
		<input type="Radio" class="radio" name="banner_block_id" id="banner_block_id_top" value="1" />
        <label for="banner_block_id_left" class="t"> {l s='Left' mod='blockadvertmulti'}</label>
		<input type="Radio" class="radio" name="banner_block_id" id="banner_block_id_left" value="2" />
        <label for="banner_block_id_right" class="t"> {l s='Right' mod='blockadvertmulti'}</label>
		<input type="Radio" class="radio" name="banner_block_id" id="banner_block_id_right" value="3" checked="checked" />
		<label for="banner_block_id_home" class="t"> {l s='Home' mod='blockadvertmulti'}</label>
		<input type="Radio" class="radio" name="banner_block_id" id="banner_block_id_home" value="4" />
        <label for="banner_block_id_footer" class="t"> {l s='Footer' mod='blockadvertmulti'}</label>
		<input type="Radio" class="radio" name="banner_block_id" id="banner_block_id_footer" value="5" />
		<p>{l s='The position at which the banners are displayed' mod='blockadvertmulti'}</p>
    </div>
    <br />
	<label for="banner_image">{l s='Banner image' mod='blockadvertmulti'}</label>
    <div class="margin-form">
        <input type="file" name="banner_image" />
        <p>{l s='Select an image from your computer' mod='blockadvertmulti'}</p>
    </div>
	<br />
	<label for="banner_blank">{l s='Group to rotate image' mod='blockadvertmulti'}</label>
    <div class="margin-form">
        <input type="checkbox" name="banner_rotate" />
        <p>{l s='Check it if you want rotate the banner' mod='blockadvertmulti'}</p>
    </div>
	<br />
	<label for="banner_blank">{l s='Open link in new window' mod='blockadvertmulti'}</label>
    <div class="margin-form">
        <input type="checkbox" name="banner_blank" />
        <p>{l s='Check it if you want the link opens in a new window' mod='blockadvertmulti'}</p>
    </div>
    <br />
	<label for="banner_active">{l s='Active' mod='blockadvertmulti'}</label>
    <div class="margin-form">
        <input type="checkbox" name="banner_active" checked="checked" />
        <p>{l s='Check it if you want to enable the new banner' mod='blockadvertmulti'}</p>
    </div>
    <br />
	<p class="center"><input class="button" name="addSubmit" value="{l s='Add banner' mod='blockadvertmulti'}" type="submit" /></p>
</fieldset>
</form>
<form action="{$smarty.server.REQUEST_URI}" method="post" class="hidden" name="deleteBannerForm">
	<fieldset class="hidden">
	<input type="hidden" value="" name="bannerDelete"/>
	<input class="hidden" name="deleteSubmit" value="{l s='Delete banner' mod='blockadvertmulti'}" type="submit" />
	</fieldset>
</form>
<br/><br/>
</div>