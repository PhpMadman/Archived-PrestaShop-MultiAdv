<span>{l s='Your banners are separated in different tabs, up there' mod='blockadvertmulti'}</span>
<br /><br />
<span>{l s='You can always add a new banner from the top clicking on the "+" icon.' mod='blockadvertmulti'}</span>
<br /><br />
<fieldset class="mod_blockadvertmulti">
	<legend><img src="../img/admin/enabled.gif" alt="I Like this!" />{l s='You Like this?' mod='blockadvertmulti'}</legend>
	{assign var=cfm value=['en'=>['RGJ3CFCZXGR96','http://goo.gl/TZRtP'],'es'=>['MLFV4S4N7U8G6','http://bit.ly/13C53Z9'],'fr'=>['95PNPV4LSD7UW','http://goo.gl/R2Z3f']]}
	{if false}{$sandbox=".sandbox"}{$cfm[$lng][0]="A8GW6YKPGPVWE"}{/if}
	<label style="text-align:left">{l s='Visit the' mod='blockadvertmulti'} <a href="{$cfm[$lng][1]}" target="_blank" ><b>{l s='Prestashop Forum' mod='blockadvertmulti'}</b></a> {l s='to contact me, send your questions or suggest improvements' mod='blockadvertmulti'}.<br/><br/>
	{l s='And click' mod='blockadvertmulti'} <a class="ipsLikeButton ipsLikeButton_enabled" title="I Like this work" href="{$cfm[$lng][1]}" target="_blank" >Like This</a><br />{l s='to promote this module within the community' mod='blockadvertmulti'}.
	<br />
	</label>
	{include file="./changelog_$lng.tpl"}
	<div class="margin-form">
		<form name="frmPayPal" action="https://www{$sandbox}.paypal.com/cgi-bin/webscr" method="post" style="margin:auto;" target="_blank">
		<input type="hidden" name="cmd" value="_s-xclick" />
		<input type="hidden" name="hosted_button_id" id="btnSubmit_id" value="{$cfm[$lng][0]}" />
		<b>{l s='Did you find this module is useful?' mod='blockadvertmulti'}</b><br />
		<b>{l s='Do you want to help me to improve it?' mod='blockadvertmulti'}</b><br />
		<div class="mediopanel">{l s='So you can resolve errors and develop new features, you can help me by clicking the button to buy one or more coffees' mod='blockadvertmulti'}.</div><br />
		<input type="hidden" name="on0" value="{l s='Meet new improvements?' mod='blockadvertmulti'}" />
		<select name="os0">
		<option value="Yes">{l s='I want to help, and see the new improvements' mod='blockadvertmulti'}&nbsp; </option>
		<option value="No">{l s='I want to help, but do not send me anything' mod='blockadvertmulti'}&nbsp; </option>
		</select>
		<a id="btnSubmit" href="javascript:void(0);" title="{l s='Buy Me a Coffee, thanks!' mod='blockadvertmulti'}"><div>{l s='Buy Me a Coffee' mod='blockadvertmulti'}</div></a>
		<input type="image" src="https://www.paypalobjects.com/es_ES/i/scr/pixel.gif" border="0" name="submit" alt="PayPal"/>
		</form>
	</div>
</fieldset>