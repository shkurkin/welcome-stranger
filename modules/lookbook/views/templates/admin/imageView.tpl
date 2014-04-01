<script>
	id_language = Number({$lookbookObj->getDefaultLang()});
</script>

 <h3>{l s='Upload an image to a lookbook' mod='lookbook'}</h3>
<form>
	<div style="float:left;">{$lookbookObj->getLangDiv('lbImage','lbImage')}</div>
	{foreach from=$lookbookObj->getLanguageIds() item=id_lang}
		<div id="lbImage_{$id_lang}" style="float:left;margin:0 0 50px 20px; display:{if $lookbookObj->getDefaultLang() == $id_lang}block{else}none{/if};">
            <select id="upload-image_{$id_lang}" name="lookbook"  class="selectMenu">
			<option value="">{l s='Select a lookbook' mod='lookbook'}</option>
			<option value="">------------</option>
		    {foreach from=$lookbookObj->getLookbooks(true) item='lookbook'}
			<option value="{$lookbook.id_lookbook}">{$lookbook.name}</option>
		    {/foreach}
		    </select>
        </div>
	{/foreach}
		<div id="file-uploader" style="display:none; float:left;margin-left:100px;">		
			<noscript>			
				<p>Please enable JavaScript to use file uploader.</p>
				<!-- or put a simple form for upload here -->
			</noscript>         
		</div>
	<div style="clear:both;"></div>
	<div id="current_lookbook_image" style="display:none;width:100%;text-align:center;"></div>
	<script>
		id_lookbook = 0;
		function createUploader(){ldelim}			  
			uploader = new qq.FileUploader({ldelim}
				element: document.getElementById('file-uploader'),
				action: '{$lookbookObj->getWebPath()}classes/qqUploadedFileXhr.php',
				allowedExtensions: ['jpg'],
				debug: true,
				template:	'<div class="qq-uploader">' + 
							'<div class="qq-upload-drop-area"><span>{l s='Drop files here to upload' mod='lookbook'}</span></div>' +
							'<div class="qq-upload-button">{l s='Upload an image' mod='lookbook'}</div>' +
							'<ul class="qq-upload-list"></ul>' + 
					 		'</div>',
				sizeLimit: 0, // max size	
				minSizeLimit: 0 // min size
			{rdelim});
		{rdelim}
		// in your app create uploader as soon as the DOM is ready
		// don't wait for the window to load  
		window.onload = createUploader;
	</script>
</form>