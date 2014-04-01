{if !empty($bMultiGroupError)}
{include file="`$modulePath`views/templates/admin/multishopConfig.tpl"}
{else}

    <fieldset>
        <legend><img src="{$lookbook->getWebPath()}logo.gif" alt="" title="" />{l s='Lookbook banner image file dimensions' mod='lookbook'}</legend>
    <form action="{$smarty.server.REQUEST_URI}" method="POST">
        <p>{l s='Please change the dimensions of the banner here.' mod='lookbook'}</p>
        {l s='Enter the banner size' mod='lookbook'} <input type="text" name="banner_size" value="{$lookbook->getConfigurationValue('LOOKBOOK_IMG_DIMENSIONS')}"/> pixels. ({l s='Default' mod='lookbook'}:555 pixels)<br/>
        <input type="submit" value="{l s='Save' mod='lookbook'}" name="submitImageSize"/>
    </form>
    </fieldset>
    <br/>
    <fieldset>
        <legend><img src="{$lookbook->getWebPath()}logo.gif" alt="" title="" />{l s='Lookbook thumbnail image file dimensions' mod='lookbook'}</legend>
    <form action="{$smarty.server.REQUEST_URI}" method="POST">
        <p>{l s='Please change the dimensions of the thumbnails here.' mod='lookbook'}</p>
        {l s='Enter the thumbnail size' mod='lookbook'} <input type="text" name="thumb_size" value="{$lookbook->getConfigurationValue('LOOKBOOK_IMG_TH_DIMENSIONS')}"/> pixels. ({l s='Default' mod='lookbook'}:120 pixels)<br/>
        <input type="submit" value="{l s='Save' mod='lookbook'}" name="submitImageThumbSize"/>
    </form>
    </fieldset>
    <br/>
    {*
    <fieldset>
        <legend><img src="{$lookbook->getWebPath()}logo.gif" alt="" title="" />{l s='Lookbook display in front office' mod='lookbook'}</legend>
    <form action="{$smarty.server.REQUEST_URI}" method="POST">
        <p>{l s='Please select the display preference you prefer' mod='lookbook'}</p>
        <p>
            <input type="radio" name="display_preferences" {if $lookbook->getConfigurationValue('LOOKBOOK_DISPLAY_PREFERENCES') == 'linear'}checked="checked{/if}" value="linear"/> - {l s='Linear display' mod='lookbook'}<br/>
            <input type="radio" name="display_preferences" {if $lookbook->getConfigurationValue('LOOKBOOK_DISPLAY_PREFERENCES') == 'mosaic'}checked="checked{/if}" value="mosaic"/> - {l s='Mosaic display' mod='lookbook'}<br/>
        </p>
        <input type="submit" value="{l s='Save' mod='lookbook'}" name="submitDisplayPreferences"/>
    </form>
    </fieldset>
    *}
{/if}