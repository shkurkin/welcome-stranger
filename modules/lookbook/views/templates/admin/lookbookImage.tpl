
{if $image}
	<img src="{$lookbookObj->getWebPath()}uploads/{$image}?{math equation="rand(1,65535)"}"/>
{else}
	<img src="{$lookbookObj->getWebPath()}css/images/no-image.jpg"/>
{/if}