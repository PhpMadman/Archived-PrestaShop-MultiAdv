<div>
<script type="text/javascript">
var come_from = 'bannerTable';
var alternate = true;
$(document).ready(function() {
	$(".vergrande").fancybox();
});
</script>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js" ></script>
<script type="text/javascript" src="../js/admin-dnd.js" ></script>
<!-- <form action="{$smarty.server.REQUEST_URI}" method="post" > -->
<!-- Patch by Madman -->
<form action="{$smarty.server.REQUEST_URI}" method="post" enctype="multipart/form-data" >
<!-- Patch by Madman -->
	<fieldset class="mod_blockadvertmulti">
		<legend><img src="{$module_dir}logo.gif" />{$title} {l s='Banners' mod='blockadvertmulti'}</legend>
		<span>{l s='Table with the' mod='blockadvertmulti'} {$title} {l s='banners' mod='blockadvertmulti'}</span><br /><br />
		<table cellspacing="0" cellpadding="0" class="table tableDnD" id="bannerTable{$block}">
            <thead>
                <tr class="nodrag nodrop">
                    <th align="center"> </th>
					<th align="center"> </th>
					<th>{l s='Image' mod='blockadvertmulti'}</th>
                    <th>{l s='Description' mod='blockadvertmulti'}</th>
                    <th>{l s='Link' mod='blockadvertmulti'}</th>
                    <th align="center">{l s='Order' mod='blockadvertmulti'}</th>
					<th align="center">{l s='Rotate' mod='blockadvertmulti'}</th>
                    <th align="center">{l s='Blank' mod='blockadvertmulti'}</th>
                    <th align="center">{l s='Active' mod='blockadvertmulti'}</th>
                    <th align="center"> </th>
                </tr>
            </thead>
            <tbody>
				{if !$banners}
                	<tr>
                        <td colspan="10" align="left" class="">
							<label for="bannerBlock_empty" class="t">{l s='There are no banners for' mod='blockadvertmulti'} <b>{$title}</b></label>
                        </td>
                    </tr>
				{else}
					{foreach from=$banners key='index' item='banner' name='banner'}
						<tr name="banner_{$banner.id_blockadvertmulti}" id="bannerTable{$block}_{$banner.id_blockadvertmulti}" {if $smarty.foreach.banner.index % 2}class="alt_row"{/if}>
							<td>{$banner.order}<input type="checkbox" style="display:none" value="{$banner.id_blockadvertmulti}" name="blockadvertmultiId[]" checked="checked"></td>
							<td {if $leftBanners >= 2}class="dragHandle"{/if} id="td_bannerTable{$block}_{$banner.id_blockadvertmulti}" width="40">
								<a {if $smarty.foreach.banner.first}style="display: none;"{/if} href="{$currentIndex}&id_banner={$banner.id_blockadvertmulti}&direction=0&token={$smarty.get.token|escape:'htmlall':'UTF-8'}&changePosition={$rand}#{$banner.block_id}"><img src="../img/admin/up.gif" alt="{l s='Up' mod='blockadvertmulti'}" title="{l s='Up' mod='blockadvertmulti'}" /></a><br />
								<a {if $smarty.foreach.banner.last}style="display: none;"{/if} href="{$currentIndex}&id_banner={$banner.id_blockadvertmulti}&direction=1&token={$smarty.get.token|escape:'htmlall':'UTF-8'}&changePosition={$rand}#{$banner.block_id}"><img src="../img/admin/down.gif" alt="{l s='Down' mod='blockadvertmulti'}" title="{l s='Down' mod='blockadvertmulti'}" /></a>
							</td>
							<td><a class="vergrande" rel="bannerTable{$block}" href="{$img_path}{$banner.image_name}" >
								<img src="{$img_path}{$banner.image_name}" name="image_{$banner.id_blockadvertmulti}" style="width:80px;height:80" /><input type="hidden" name="image_name_{$banner.id_blockadvertmulti}" value="{$banner.image_name}"/></a>
								<!-- Patch by Madman -->
								<input type="file" name="banner_image_{$banner.id_blockadvertmulti}" />
								<!-- Patch by Madman -->
								</td>
							<td><input type="text" value="{$banner.description}" name="desc_{$banner.id_blockadvertmulti}" size="30"/></td>
							<td><textarea rows="3" name="link_{$banner.id_blockadvertmulti}" cols="35">{$banner.image_link}</textarea></td>
							<td><input type="text" value="{$banner.order}" name="order_{$banner.id_blockadvertmulti}" align="right" size="2" maxlength="3"/></td>
							<td align="center"><input type="checkbox" class="noborder" value="{$banner.id_blockadvertmulti}" name="rotate_{$banner.id_blockadvertmulti}" {if (intval($banner.rotate))} checked="checked"{/if}></td>
							<td align="center"><input type="checkbox" class="noborder" value="{$banner.id_blockadvertmulti}" name="blank_{$banner.id_blockadvertmulti}" {if (intval($banner.open_blank))} checked="checked"{/if}></td>
							<td align="center"><input type="checkbox" class="noborder" value="{$banner.id_blockadvertmulti}" name="active_{$banner.id_blockadvertmulti}" {if (intval($banner.active))} checked="checked"{/if}><input type="hidden" name="block_{$banner.id_blockadvertmulti}" value="{$banner.block_id}"/></td>
							<td align="center"><img src="../img/admin/delete.gif" alt="{l s='Delete Banner' mod='blockadvertmulti'}" title="{l s='Delete Banner' mod='blockadvertmulti'}" onclick="deleteBanner({$banner.id_blockadvertmulti}, '{l s='Do you want to delete the following banner?' mod='blockadvertmulti'}');"/></td>
						</tr>
					{/foreach}
				{/if}
            </tbody>
		</table>
		<br />
		<p class="center"><input class="button" name="updateSubmit" value="{l s='Update banners' mod='blockadvertmulti'}" type="submit" /></p>
	</fieldset>
</form>
</div>