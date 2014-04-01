var LookbookAdminPr = function()
{

    // Allocate this to this object context
    var lbOps = this;

    // Global variables
    lbOps.messageDiv = 'divMessage';

    // This method checks errors in json result
    lbOps.checkErrors = function(json)
    {
        if (json && json.error)
            return json.error;
        else
            return false;
    };

    // This method displays errors in the DOM
    lbOps.displayMessage = function(sElement, sClass, sHeadMessage, sMessage, countdown)
    {
        $('.' + sClass).promise().done(function() {
            $('.' + sClass).hide();
            $('#' + sElement).attr('class', '').addClass(sClass);
            $('#' + sElement).fadeIn();
            $('.icon-close').click(function() {
                $('.' + sClass).fadeOut('slow');
            });
            $('.hMsg').html(sHeadMessage + '<br/>');
            $('#' + sElement + ' .errorList p').empty().html(sMessage);
            if (!countdown)
                setTimeout(function() {
                    $('#' + sElement).fadeOut()
                }, 2500);
        });
    };

    // Returns the current tab ID
    lbOps.getSelectedTab = function()
    {
        var $tabs = $('#tabs').tabs();
        var selectedTab = '#tabs-' + ($tabs.tabs('option', 'selected') + 1);
        return selectedTab;
    };

    // This method executes the ajax requests given by other methods
    lbOps.ajaxRequest = function(sType, sPhpClass, sMethod, sParams)
    {
        lbOps.displayMessage('messageBox', 'infomsg', _MESSAGE_['loading'], '', true)
        $.ajax({
            type: sMethod,
            url: _PS_LB_REQUEST_URI_,
            data: {
                'lbAjax': 'true',
                'method': sPhpClass,
                'params': sParams
            },
            dataType: sType,
            success: function(data) {
                $('#messageBox').fadeOut('fast', function()
                {
                    if (data.type == 'error')
                        lbOps.displayMessage('messageBox', data.class, _MESSAGE_['fieldNotFilled'], data.outputTemplate, true);
                    else
                    {
                        if (data.class)
                        {
                            lbOps.displayMessage('messageBox', data.class, _MESSAGE_[data.msg], data.outputTemplate);
                        }
                        lbOps.updateView(data.view, data.viewContent);
                    }

                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                lbOps.displayMessage('messageBox', 'errormsg', _MESSAGE_['unknownError'], xhr.responseText, true);
            }
        });
    };


    // This method creates or updates categories
    lbOps.addNewLookbookCategory = function()
    {
        var myData = [];

        var category_name;
        var category_desc;
        var categoryDivName;

        $('.categories').each(function() {
            categoryDivName = $(this).attr('id');
            category_name = $('#' + categoryDivName + ' input[type=text]').val();
            category_desc = $('#' + categoryDivName + ' textarea').val();
            myData.push('category_name_' + categoryDivName.slice(-1) + '=' + category_name + '&' + 'category_desc_' + categoryDivName.slice(-1) + '=' + category_desc);
        });

        var serialized = myData.join("&");
        serialized = serialized + '&active=' + $('#category_active').attr('checked');

        if ($('#add_category input[name=operation]').val() == 'update')
            serialized = serialized + '&id_category=' + $('#add_category input[name=id_category]').val();

        lbOps.ajaxRequest('json', 'LBCreateCategory', 'POST', serialized);
    };

    // This method creates or updates lookbooks
    lbOps.addNewLookbook = function()
    {

        var myData = [];

        var lookbook_name;
        var lookbook_desc;
        var lookbookDivName;

        $('.lookbooks').each(function() {
            lookbookDivName = $(this).attr('id');
            lookbook_name = $('#' + lookbookDivName + ' input[type=text]').val();
            lookbook_desc = $('#' + lookbookDivName + ' textarea').val();
            myData.push('lookbook_name_' + lookbookDivName.slice(-1) + '=' + lookbook_name + '&' + 'lookbook_desc_' + lookbookDivName.slice(-1) + '=' + lookbook_desc);
        });

        var serialized = myData.join("&");
        serialized = serialized + '&active=' + $('#lookbook_active').attr('checked');

        if ($('#add_lookbook input[name=operation]').val() == 'update')
            serialized = serialized + '&id_lookbook=' + $('#add_lookbook input[name=id_lookbook]').val();

        lbOps.ajaxRequest('json', 'LBCreateLookbook', 'POST', serialized);


    };

    //This method sorts and dispatchs actions to the ajaxRequest method 
    lbOps.liveActions = function(sPhpClass, sKey, sAction, iId)
    {
        var serialized;

        switch (sAction)
        {
            case 'status':
                serialized = 'operation=toggle&' + sKey + '=' + iId;
                lbOps.ajaxRequest('json', sPhpClass, 'POST', serialized);
                break;
            case 'edit':
                serialized = 'operation=edit&' + sKey + '=' + iId;
                lbOps.ajaxRequest('json', sPhpClass, 'POST', serialized);
                break;
            case 'delete':
                var answer = confirm(_MESSAGE_['confirm_delete']);
                if (answer)
                {
                    serialized = 'operation=delete&' + sKey + '=' + iId;
                    lbOps.ajaxRequest('json', sPhpClass, 'POST', serialized);
                }
                break;
            case 'template':
                serialized = 'operation=template';
                lbOps.ajaxRequest('json', sPhpClass, 'POST', serialized);
                break;
            case 'categoryToBeAssignedSelect':
                serialized = 'operation=getLookbooksForCategory&category=' + iId;
                lbOps.ajaxRequest('json', sPhpClass, 'POST', serialized);
                break;
            case 'lookbookToBeAssignedSelect':
                lbOps.emptyManufacturerAssignmentSelect();
                serialized = 'operation=getProductsForLookbook&lookbook=' + iId;
                lbOps.ajaxRequest('json', sPhpClass, 'POST', serialized);
                break;
            case 'productsFromManufacturerSelect':
                var lookbook = $('#lookbookToBeAssignedSelect option:selected').val();
                serialized = 'operation=getUnAssignedProducts&manufacturer=' + iId + '&lookbook=' + lookbook;
                lbOps.ajaxRequest('json', sPhpClass, 'POST', serialized);
                break;
            case 'image':
                if (iId)
                {
                    var lang = sKey.slice(-1);
                    serialized = 'operation=getLookbookImage&lookbook=' + iId + '&lang=' + lang;
                    lbOps.ajaxRequest('json', sPhpClass, 'POST', serialized);
                    uploader.setParams({
                        id_lookbook: iId,
                        id_lang: lang
                    });
                } else
                {
                    $('#file-uploader').hide();
                    $('#current_lookbook_image').hide();
                }
                break;
            case 'tab':
                switch (iId)
                {
                    case 0:
                        serialized = 'operation=getCategoryView&tabindex=' + iId;
                        lbOps.ajaxRequest('json', sPhpClass, 'POST', serialized);
                        break;
                    case 1:
                        serialized = 'operation=getLookbookView&tabindex=' + iId;
                        lbOps.ajaxRequest('json', sPhpClass, 'POST', serialized);
                        break;
                    case 2:
                        serialized = 'operation=getAssignmentView&tabindex=' + iId;
                        lbOps.ajaxRequest('json', sPhpClass, 'POST', serialized);
                        break;
                    case 3:
                        serialized = 'operation=getImageView&tabindex=' + iId;
                        lbOps.ajaxRequest('json', sPhpClass, 'POST', serialized);
                        break;
                    default:
                        break;
                }
                break;
            default:
                alert('Something went wrong here...');
                break;
        }
    };

    // This methods handles lookbooks and products assignment button events
    lbOps.buttonActions = function(sId)
    {
        var selectedItems = [];
        var existingValues = [];
        var serialized;

        switch (sId)
        {
            case 'lookbooksAddButton':
                var category = $('#categoryToBeAssignedSelect option:selected').val();
                $('#lookbooksToAssignSelect option:selected').each(function() {
                    selectedItems.push($(this).val());
                });
                $('#lookbooksAssignedSelect option').each(function() {
                    existingValues.push($(this).val());
                });
                var currentValues = $.merge(selectedItems, existingValues);
                $('#lookbooksToAssignSelect option').remove().appendTo('#lookbooksAssignedSelect');
                serialized = 'operation=assignLookbooks&lookbook=' + currentValues + '&category=' + category;
                lbOps.ajaxRequest('json', 'LBAssignmentsActions', 'POST', serialized);
                break;
            case 'lookbooksRemoveButton':
                var category = $('#categoryToBeAssignedSelect option:selected').val();
                $('#lookbooksAssignedSelect option:selected').each(function() {
                    selectedItems.push($(this).val());
                });
                var currentValues = $.merge(selectedItems, existingValues);
                $('#lookbooksAssignedSelect option').remove().appendTo('#lookbooksToAssignSelect');
                serialized = 'operation=unAssignLookbooks&lookbook=' + selectedItems + '&category=' + category;
                lbOps.ajaxRequest('json', 'LBAssignmentsActions', 'POST', serialized);
                break;
            case 'productsAddButton':
                var lookbook = $('#lookbookToBeAssignedSelect option:selected').val();
                $('#productsToAssignSelect option:selected').each(function() {
                    selectedItems.push($(this).val());
                });
                $('#productsAssignedSelect option').each(function() {
                    existingValues.push($(this).val());
                });
                var currentValues = $.merge(selectedItems, existingValues);
                $('#productsToAssignSelect option:selected').remove().appendTo('#productsAssignedSelect');
                serialized = 'operation=assignProducts&product=' + currentValues + '&lookbook=' + lookbook;
                lbOps.ajaxRequest('json', 'LBAssignmentsActions', 'POST', serialized);
                break;
            case 'productsRemoveButton':
                var lookbook = $('#lookbookToBeAssignedSelect option:selected').val();
                $('#productsAssignedSelect option:selected').each(function() {
                    selectedItems.push($(this).val());
                });
                lbOps.emptyManufacturerAssignmentSelect();
                $('#productsAssignedSelect option').remove();
                serialized = 'operation=unAssignProducts&product=' + selectedItems + '&lookbook=' + lookbook;
                lbOps.ajaxRequest('json', 'LBAssignmentsActions', 'POST', serialized);
                break;
            default:
                break;
        }
    };


    // This method reinitialise product to assign view
    lbOps.emptyManufacturerAssignmentSelect = function()
    {
        $('#productsFromManufacturerSelect option:eq(0)').attr('selected', 'selected');
        $('#productsToAssignSelect option').remove();
    };

    //This method updates choosen part of the DOM. If no parameter given, does a window.reload
    lbOps.updateView = function(sView, sContent)
    {
        switch (sView)
        {
            case 'category':
                $('#' + sView).empty().html(sContent);
                break;
            case 'lookbook':
                $('#' + sView).empty().html(sContent);
                break;
            case 'categoryForm':
                $('#' + sView).empty().html(sContent);
                break;
            case 'lookbookForm':
                $('#' + sView).empty().html(sContent);
                break;
            case 'lookbookAssignments':
                $('#' + sView).empty().html(sContent);
                break;
            case 'productAssignmentsAssigned':
                $('#' + sView).empty().html(sContent);
                break;
            case 'productAssignmentsUnAssigned':
                $('#' + sView).empty().html(sContent);
                break;
            case 'current_lookbook_image':
                $('#' + sView).empty().html(sContent);
                $('#current_lookbook_image').show();
                $('#file-uploader').show();
                break;
            case 'tabs-1':
                $('#' + sView).empty().html(sContent);
                break;
            case 'tabs-2':
                $('#' + sView).empty().html(sContent);
                break;
            case 'tabs-3':
                $('#' + sView).empty().html(sContent);
                break;
            case 'tabs-4':
                $('#' + sView).empty().html(sContent);
                createUploader();
                break;
            default:
                window.location.reload();
                break;
        }

        return false;
    };



};

$(document).ready(function() {
    // Instance of the new object LookbookAdminPr()
    inst = new LookbookAdminPr(_MESSAGE_);

    $('#tabs').tabs({
        select: function(event, ui) {
            inst.liveActions('LBViewActions', 'tab', 'tab', ui.index);
        }
    });


    //The following binds on DOM events even if parts of the DOM have been reloaded.

    $('#add_category').live('submit', function() {
        inst.addNewLookbookCategory();
        return false;
    });

    $('#add_lookbook').live('submit', function() {
        inst.addNewLookbook();
        return false;
    });

    $('#category a').live('click', function() {
        inst.liveActions('LBCategoryActions', 'category', $(this).find('img').attr('rel'), $(this).attr('rel'));
    });

    $('#lookbook a').live('click', function() {
        inst.liveActions('LBLookbookActions', 'lookbook', $(this).find('img').attr('rel'), $(this).attr('rel'));
    });

    $('#tabs-3 .selectMenu').live('change', function() {
        inst.liveActions('LBAssignmentsActions', 'assignments', $(this).attr('id'), $(this).find('option:selected').val());
    });

    $('#tabs-3 input[type=button]').live('click', function() {
        inst.buttonActions($(this).attr('id'));
    });

    $('#tabs-4 .selectMenu').live('change', function() {
        inst.liveActions('LBLookbookActions', $(this).attr('id'), 'image', $(this).find('option:selected').val());
    });

    $('#language_current_upload-image').live('click', function() {
        $('#tabs-4 .selectMenu').each(function() {
            $('option', this).eq(0).attr('selected', 'selected');
        })
        $('#file-uploader').hide();
        $('#current_lookbook_image').hide();
    });


});

$(document).ready(function() {
    $('.collapse').collapse();
    $('#collapseOne').collapse('hide');

    $('#manufacturers_block_left').affix({
        offset: $('#manufacturers_block_left').position()
    });
});