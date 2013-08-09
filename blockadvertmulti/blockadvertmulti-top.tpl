<div id="blockadvmulti{$hook}" class="blockadvmulti" {if $side_by_side}style="text-align:center;" {/if} >
{$rotate=""}
{$numgrups=0}
{foreach from=$banners item=banner}
	{if $banner.rotate && $rotate != $banner.rotate}
	   {$rotate = $banner.rotate}
	   {$numgrups=$numgrups+1}
	   {if $numgrups > 1}
			</div>
	   {/if}
	   <div class="advmulti-rotate" style="position:absolute;left:50%">
	{/if}
	<p id="advmulti{$banner.id_blockadvertmulti}" class="advmulti{$hook}" {if $side_by_side}style="display:inline-block;" {/if} >
		{if $banner.image_link != ""}
		<a href="{$banner.image_link}" target="{if $banner.open_blank==0}_self{else}_blank{/if}" title="{$banner.description}">
		{/if}
			<img src="{$img_path}{$banner.image_name}" alt="{$banner.description}" class="advmulti-img" />
		{if $banner.image_link != ""}
		</a>
		{/if}
	</p>
{/foreach}
{if $numgrups > 0}
	</div>
	<script type="text/javascript">
	{literal}$(document).ready(function() {
		$("#blockadvmulti{/literal}{$hook} .advmulti-rotate").innerfade({literal}{'containerheight': 'auto', 'timeout': 5000});
// 		$("#blockadvmulti{/literal}{$hook} .advmulti-rotate").innerfade({literal}{'containerheight': '100px', 'timeout': 5000});
	});{/literal}
	</script>
{/if}
</div>
