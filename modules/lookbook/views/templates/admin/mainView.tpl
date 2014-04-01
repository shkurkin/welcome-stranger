<script>
	var _PS_LB_MODULE_DIR_ = '{$lookbookObj->getWebPath()}';
	var _PS_LB_MODULE_URL_ = '{$lookbookObj->getWebURL()}';
	var _PS_LB_REQUEST_URI_ = '{$smarty.server.REQUEST_URI}';
	var _PS_LB_LANGUAGE_IDS_ = [];
	id_language = Number({$lookbookObj->getDefaultLang()});
	{assign var='modulePath' value=$lookbookObj->getModulePath()}
	{include file="`$modulePath`views/templates/admin/jsMessages.tpl"}
{foreach from=$lookbookObj->getLanguageIds() key=k item=id_language}
	_PS_LB_LANGUAGE_IDS_[{$k}] = '{$id_language}';
{/foreach}
</script>


{$lookbookObj->getJqueryAndJs()}

{$lookbookObj->getCss()}

{if !empty($bMultiGroupError)}
    {include file="`$modulePath`views/templates/admin/multishopConfig.tpl"}
{else}
    <h2>{l s='Edit lookbooks' mod='lookbook'}</h2>
    <div id="lbcontainer">
        <div class="lookbook-tabs">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">{l s='Categories' mod='lookbook'}</a></li>
                    <li><a href="#tabs-2">{l s='Lookbooks' mod='lookbook'}</a></li>
                    <li><a href="#tabs-3">{l s='Assignments' mod='lookbook'}</a></li>
                    <li><a href="#tabs-4">{l s='Images' mod='lookbook'}</a></li>
                </ul>
                <div id="allViews">
                    <div id="messageBox" style="display:none;"><a class="icon-close"></a><span class="hMsg"></span><span class="errorList"><p></p></span></div>
                    <div id="tabs-1">
                        <fieldset id="categoryForm" class="myform stylized">
                            <legend><span class="legend-add" style="display:inline;">{l s='Add a category' mod='lookbook'}</span><span class="legend-update" style="display:none;">{l s='Update a category' mod='lookbook'}</span></legend>
                            <form name="add_category" id='add_category' method="post">
                                <input type="hidden" name="operation" value="add">
                                <p style="text-align:right;margin-bottom:20px;font-size:10pt;"><a href="javascript: inst.liveActions('LBCategoryActions', 'category', 'template');"><img src="{$smarty.const._PS_IMG_}admin/add.gif"/>Create a new category</a></p>
                            {foreach from=$lookbookObj->getLanguageIds() item=id_lang}
                                <div id="category_{$id_lang}" class="categories" style="display:{if $lookbookObj->getDefaultLang() == $id_lang} block; {else} none; {/if}">
                                    <p>
                                        <label>{l s='Category name' mod='lookbook'}
                                            <span class="small">{l s='Type here the name of your category' mod='lookbook'}</span>
                                        </label>
                                        <input type="text" id="category_name_{$id_lang}"/>
                                    </p>
                                    <p>
                                    <label>{l s='Category description' mod='lookbook'}
                                        <span class="small">{l s='Type here the description of your category' mod='lookbook'}</span>
                                    </label>
                                    <textarea id="category_description_{$id_lang}"></textarea>
                                    </p>
                                </div>
                            {/foreach}
                                <div>
                                    <p>
                                        <label>{l s='Active' mod='lookbook'}
                                            <span class="small">{l s='Check this checkbox if the category is active' mod='lookbook'}</span>
                                        </label>
                                        <input type="checkbox" id="category_active" value="1"/>
                                    </p>
                                </div>
                                <p>
                                    <span class="legend-add" style="display:inline;"><button style="float:right;" class="submit">{l s='Save' mod='lookbook'}</button></span>
                                    <span class="legend-update" style="display:none;"><button style="float:right;" class="submit">{l s='Update' mod='lookbook'}</button></span>
                                </p>
                                <div style="float:left;">{$lookbookObj->getLangDiv('category','category')}</div>
                            </form>
                        </fieldset>
                        <hr/>
                        <fieldset class="stylized myform">
                            <legend>{l s='List of the categories' mod='lookbook'}</legend>
                            <table>
                                <thead>
                                    <tr>
                                        <th>{l s='Name' mod='lookbook'}</th><th>{l s='Description summary' mod='lookbook'}</th><th>{l s='# lookbooks' mod='lookbook'}</th><th>{l s='Actions' mod='lookbook'}</th>
                                    </tr>
                                </thead>
                                <tbody id="category">
                                {foreach from=$lookbookObj->getCategories() item='category'}
                                    <tr style="background-color: {cycle values="#ddf,#eef"}">
                                        <td>{$category.name}</td>
                                        <td>{$category.description|truncate:40:"..."}</td>
                                        <td>{$lookbookObj->getNbLookbookForThisCategory($category.id_category)}</td>
                                        <td>
                                            <a class="cat_status" rel="{$category.id_category}"><img rel="status" src="{$smarty.const._PS_IMG_}admin/{if $category.active == 0}disabled{else}enabled{/if}.gif"/></a>|
                                            <a class="cat_edit"  rel="{$category.id_category}"><img rel="edit" src="{$smarty.const._PS_IMG_}admin/edit.gif" /></a>|
                                            <a class="cat_delete"  rel="{$category.id_category}"><img rel="delete" src="{$smarty.const._PS_IMG_}admin/delete.gif" /></a>
                                        </td>
                                    </tr>
                                {/foreach}
                                </tbody>
                            </table>
                        </fieldset>
                    </div>
                    <div id="tabs-2">

                        <fieldset id="lookbookForm" class="stylized myform">
                            <legend><span class="legend-add" style="display:inline;">{l s='Add a lookbook' mod='lookbook'}</span><span class="legend-update" style="display:none;">{l s='Update a lookbook' mod='lookbook'}</span></legend>
                            <form name="add_lookbook" id='add_lookbook' method="post">
                                <input type="hidden" name="operation" value="add">
                                <p style="text-align:right;margin-bottom:20px;font-size:10pt;"><a href="javascript: inst.liveActions('LBLookbookActions', 'lookbook', 'template');"><img src="{$smarty.const._PS_IMG_}admin/add.gif"/>Create a new lookbook</a></p>
                                {foreach from=$lookbookObj->getLanguageIds() item=id_lang}
                                    <div id="lookbook_{$id_lang}" class="lookbooks" style="display:{if $lookbookObj->getDefaultLang() == $id_lang} block; {else} none; {/if}">
                                        <p>
                                            <label>{l s='Lookbook name' mod='lookbook'}
                                                <span class="small">{l s='Type here the name of your lookbook' mod='lookbook'}</span>
                                            </label>
                                            <input type="text" id="lookbook_name_{$id_lang}"/>
                                        </p>
                                        <p>
                                        <label>{l s='Lookbook description' mod='lookbook'}
                                            <span class="small">{l s='Type here the description of your lookbook' mod='lookbook'}</span>
                                        </label>
                                        <textarea id="lookbook_description_{$id_lang}"></textarea>
                                        </p>
                                    </div>
                                {/foreach}
                                    <div>
                                        <p>
                                            <label>{l s='Active' mod='lookbook'}
                                                <span class="small">{l s='Check this checkbox if the lookbook is active' mod='lookbook'}</span>
                                            </label>
                                            <input type="checkbox" id="lookbook_active" value="1"/>
                                        </p>
                                    </div>
                                <p>
                                    <span class="legend-add" style="display:inline;"><button style="float:right;" class="submit">{l s='Save' mod='lookbook'}</button></span>
                                    <span class="legend-update" style="display:none;"><button style="float:right;" class="submit">{l s='Update' mod='lookbook'}</button></span>
                                </p>
                                <div style="float:left;">{$lookbookObj->getLangDiv('lookbook','lookbook')}</div>
                            </form>
                        </fieldset>
                        <hr/>
                        <fieldset class="stylized myform">
                            <legend>{l s='List of the lookbooks' mod='lookbook'}</legend>
                            <table>
                                <thead>
                                    <tr>
                                        <th>{l s='Name' mod='lookbook'}</th><th>{l s='Description summary' mod='lookbook'}</th><th>{l s='# products' mod='lookbook'}</th><th>{l s='Actions' mod='lookbook'}</th>
                                    </tr>
                                </thead>
                                <tbody id='lookbook'>
                                {foreach from=$lookbookObj->getLookbooks() item='lookbook'}
                                    <tr style="background-color: {cycle values="#ddf,#eef"}">
                                        <td>{$lookbook.name}</td>
                                        <td>{$lookbook.description|truncate:40:"..."}</td>
                                        <td>{$lookbookObj->getNbProductsInLookbook($lookbook.id_lookbook)}</td>
                                        <td>
                                            <a class="lb_status" rel="{$lookbook.id_lookbook}"><img rel="status" src="{$smarty.const._PS_IMG_}admin/{if $lookbook.active == 0}disabled{else}enabled{/if}.gif"/></a>|
                                            <a class="lb_edit"  rel="{$lookbook.id_lookbook}"><img rel="edit" src="{$smarty.const._PS_IMG_}admin/edit.gif" /></a>|
                                            <a class="lb_delete"  rel="{$lookbook.id_lookbook}"><img rel="delete" src="{$smarty.const._PS_IMG_}admin/delete.gif" /></a>
                                        </td>
                                    </tr>
                                {/foreach}
                                </tbody>
                            </table>
                        </fieldset>
                    </div>
                    <div id="tabs-3">
                        <h3>{l s='Assign multiple lookbooks to a category' mod='lookbook'}</h3>
                        <form>
                            <div class="assignments" id="lookbookAssignments">
                                <fieldset>
                                    <legend>
                                        <select id="categoryToBeAssignedSelect" name="categoryToBeAssignedSelect" class="selectMenu">
                                                <option value="">{l s='Choose a category' mod='lookbook'}</option>
                                                <option value="">------------</option>
                                            {foreach from=$lookbookObj->getCategories(true) item='category'}
                                                <option value="{$category.id_category}">{$category.name}</option>
                                            {/foreach}
                                        </select>
                                    </legend>
                                    <div style="float:left;text-align:center;">
                                        <select id="lookbooksAssignedSelect" name="assignedLookbook[]" class="multiple" multiple="true">
                                        </select>
                                        <br/>
                                        <input style="width:80%;margin-top:10px;" type="button" id="lookbooksRemoveButton" value="{l s='Remove' mod='lookbook'} ->"/>
                                    </div>
                                    <div style="float:left;text-align:center;">
                                        <select id="lookbooksToAssignSelect" name="assignedLookbook[]" class="multiple" multiple="true">
                                        </select>
                                        <br/>
                                        <input style="width:80%;margin-top:10px;" type="button" id="lookbooksAddButton" value="<- {l s='Add' mod='lookbook'}"/>
                                    </div>
                                </fieldset>
                            </div>
                        </form>
                        <hr/>
                        <h3>{l s='Assign products to a lookbook' mod='lookbook'}</h3>
                        <form>
                            <div class="assignments" id="productAssignements">
                                <fieldset>
                                    <div id="productAssignmentsAssigned" style="float:left;text-align:center;">
                                        <select id="lookbookToBeAssignedSelect" name="lookbookToBeAssignedSelect" class="selectMenu">
                                            <option value="">{l s='Choose a lookbook' mod='lookbook'}</option>
                                            <option value="">------------</option>
                                            {foreach from=$lookbookObj->getLookbooks(true) item='lookbook'}
                                                <option value="{$lookbook.id_lookbook}">{$lookbook.name}</option>
                                            {/foreach}
                                        </select><br/>
                                        <select id="productsAssignedSelect" name="assignedProducts[]" class="multiple"  multiple="true">
                                        </select>
                                        <br/>
                                        <input style="width:80%;margin-top:10px;" type="button" id="productsRemoveButton" value="{l s='Remove' mod='lookbook'}"/>
                                    </div>

                                    <div id="productAssignmentsUnAssigned" style="float:left;text-align:center;">
                                        <select id="productsFromManufacturerSelect" name="productsFromManufacturerSelect" class="selectMenu">
                                            <option value="">{l s='Choose a manufacturer' mod='lookbook'}</option>
                                            <option value="">------------</option>
                                            {foreach from=$lookbookObj->getManufacturers() item='manufacturer'}
                                                <option value="{$manufacturer.id_manufacturer}">{$manufacturer.name}</option>
                                            {/foreach}
                                        </select><br/>
                                        <select id="productsToAssignSelect" name="assignedProducts[]" class="multiple"  multiple="true">
                                        </select>
                                        <br/>
                                        <input style="width:80%;margin-top:10px;" type="button" id="productsAddButton" value="<- {l s='Add' mod='lookbook'}"/>
                                    </div>
                                </fieldset>
                            </div>
                        </form>
                    </div>
                    <div id="tabs-4" style="height:600px;">
                         <h3>{l s='Upload an image to a lookbook' mod='lookbook'}</h3>
                        <form>
                            <div style="float:left;">{$lookbookObj->getLangDiv('upload-image','upload-image')}</div>
                            {foreach from=$lookbookObj->getLanguageIds() item=id_lang}
                                <select id="upload-image_{$id_lang}" name="lookbook" style="float:left; margin:0 0 50px 20px; display:{if $lookbookObj->getDefaultLang() == $id_lang} block; {else} none; {/if}" class="selectMenu">
                                    <option value="">{l s='Select a lookbook' mod='lookbook'}</option>
                                    <option value="">------------</option>
                                {foreach from=$lookbookObj->getLookbooks(true) item='lookbook'}
                                    <option value="{$lookbook.id_lookbook}">{$lookbook.name}</option>
                                {/foreach}
                                </select>
                            {/foreach}
                                <div id="file-uploader" style="display:none; float:left;margin-left:100px;">
                                    <noscript>
                                        <p>Please enable JavaScript to use file uploader.</p>
                                        <!-- or put a simple form for upload here -->
                                    </noscript>
                                </div>
                            <div style="clear:both;"></div>
                            <div id="current_lookbook_image" style="display:none;text-align:center;"></div>
                            <script>
                                lookbook_id = 0;
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
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}

