<div id="blockadvmulti{$hook}" class="blockadvmulti">
{$rotate=""}
{$numgrups=0}
{foreach from=$banners item=banner}
	{if $banner.rotate && $rotate != $banner.rotate}
	   {$rotate = $banner.rotate}
	   {$numgrups=$numgrups+1}
	   {if $numgrups > 1}
			</div>
	   {/if}
	   <div class="advmulti-rotate">
	{/if}
	<p id="advmulti{$banner.id_blockadvertmulti}" class="advmulti{$hook}">
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
		$("#blockadvmulti{/literal}{$hook} .advmulti-rotate").innerfade({literal}{'containerheight': '100px', 'timeout': 5000});
	});{/literal}
	</script>
{/if}
</div>
