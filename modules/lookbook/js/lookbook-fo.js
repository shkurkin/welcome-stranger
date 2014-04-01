var attributeManipulation = function(jsonAttributes)
{

	//global variables

	var amThis = this;
	amThis.combinations = [];
	amThis.globalQuantity = new Number;
	amThis.selectedCombination = new Array();
	
	amThis.productAvailableForOrder;
	amThis.allowBuyWhenOutOfStock;
	amThis.productReference;
	amThis.default_eco_tax;
	amThis.availableNowValue;
	amThis.maxQuantityToAllowDisplayOfLastQuantityMessage;
	amThis.quantitiesDisplayAllowed;
	amThis.productShowPrice;
	amThis.displayPrice;
	amThis.productPriceTaxExcluded;
	amThis.group_reduction;
	amThis.taxRate;
	amThis.specific_price;
	amThis.currencyRate;
	amThis.noTaxForThisProduct;
	amThis.reduction_percent;
	amThis.reduction_price;
	amThis.specific_currency;
	amThis.ecotaxTax_rate;
	amThis.currencyFormat;
	amThis.currencyBlank;
	amThis.currencySign;
	amThis.productUnitPriceRatio;
	
	amThis.arrayKey;
	
	
	
	
	
	//verify if value is in the array
	this.in_array = function(value, array)
	{
		for (var i in array)
			if (array[i] == value)
				return true;
		return false;
	};
	
	//return a formatted price
	this.formatCurrency = function(price, currencyFormat, currencySign, currencyBlank)
	{
		// if you modified this function, don't forget to modify the PHP function displayPrice (in the Tools.php class)
		blank = '';
		price = parseFloat(price.toFixed(6));
		price = ps_round(price, priceDisplayPrecision);
		if (currencyBlank > 0)
			blank = ' ';
		if (currencyFormat == 1)
			return currencySign + blank + amThis.formatNumber(price, priceDisplayPrecision, ',', '.');
		if (currencyFormat == 2)
			return (amThis.formatNumber(price, priceDisplayPrecision, ' ', ',') + blank + currencySign);
		if (currencyFormat == 3)
			return (currencySign + blank + amThis.formatNumber(price, priceDisplayPrecision, '.', ','));
		if (currencyFormat == 4)
			return (amThis.formatNumber(price, priceDisplayPrecision, ',', '.') + blank + currencySign);
		return price;
	}
	
	//return a formatted number
	this.formatNumber = function(value, numberOfDecimal, thousenSeparator, virgule)
	{
		value = value.toFixed(numberOfDecimal);
		var val_string = value+'';
		var tmp = val_string.split('.');
		var abs_val_string = (tmp.length == 2) ? tmp[0] : val_string;
		var deci_string = ('0.' + (tmp.length == 2 ? tmp[1] : 0)).substr(2);
		var nb = abs_val_string.length;

		for (var i = 1 ; i < 4; i++)
			if (value >= Math.pow(10, (3 * i)))
				abs_val_string = abs_val_string.substring(0, nb - (3 * i)) + thousenSeparator + abs_val_string.substring(nb - (3 * i));

		if (parseInt(numberOfDecimal) == 0)
			return abs_val_string;
		return abs_val_string + virgule + (deci_string > 0 ? deci_string : '00');
	}
	
	//add a combination of attributes in the global JS sytem
	this.addCombination = function(arrayKey)
	{
		amThis.arrayKey = arrayKey;
		
		if(typeof(jsonAttributes[arrayKey]) == 'object')
		{
			for(var attribute in jsonAttributes[arrayKey].combinations)
			{
			
				amThis.globalQuantity += jsonAttributes[arrayKey].combinations[attribute].quantity
				var combination = [];
				combination['idCombination'] = attribute;
				combination['quantity'] = jsonAttributes[arrayKey].combinations[attribute].quantity;
				combination['idsAttributes'] = [];
				combination['idsAttributes'] = jsonAttributes[arrayKey].combinations[attribute].list.split(',');
				combination['price'] = jsonAttributes[arrayKey].combinations[attribute].price;
				combination['ecotax'] = jsonAttributes[arrayKey].combinations[attribute].ecotax;
				combination['image'] = jsonAttributes[arrayKey].combinations[attribute].id_image;
				combination['reference'] = jsonAttributes[arrayKey].combinations[attribute].reference;
				combination['unit_price'] = jsonAttributes[arrayKey].combinations[attribute].unit_price;
				combination['minimal_quantity'] = jsonAttributes[arrayKey].combinations[attribute].minimal_quantity;
				amThis.combinations.push(combination);
			}
		}
		amThis.findCombination();
	};

	// search the combinations' case of attributes and update displaying of availability, prices, ecotax, and image
	this.findCombination = function()
	{
			$('#minimal_quantity_wanted_p'+'_'+amThis.arrayKey).fadeOut();
			$('#quantity_wanted'+'_'+amThis.arrayKey).val(1);

			//create a temporary 'choice' array containing the choices of the customer
			var choice = new Array();
			$('div#attributes'+'_'+amThis.arrayKey+' select').each(function(){
				choice.push($(this).val());
			});
			
			//testing every combination to find the conbination's attributes' case of the user
			for (var combination = 0; combination < amThis.combinations.length; ++combination)
			{
				//verify if this combinaison is the same that the user's choice
				var combinationMatchForm = true;
				$.each(amThis.combinations[combination]['idsAttributes'], function(key, value)
				{
					if (!amThis.in_array(value, choice))
					{
						combinationMatchForm = false;
					}
				})

				if (combinationMatchForm)
				{
					if (amThis.combinations[combination]['minimal_quantity'] > 1)
					{
						$('#minimal_quantity_label'+'_'+amThis.arrayKey).html(amThis.combinations[combination]['minimal_quantity']);
						$('#minimal_quantity_wanted_p'+'_'+amThis.arrayKey).fadeIn();
						$('#quantity_wanted'+'_'+amThis.arrayKey).val(amThis.combinations[combination]['minimal_quantity']);
						$('#quantity_wanted'+'_'+amThis.arrayKey).bind('keyup', function() {checkMinimalQuantity(amThis.combinations[combination]['minimal_quantity'])});
					}
					//combination of the user has been found in our specifications of this.combinations (created in back office)
					amThis.selectedCombination['unavailable'] = false;
					amThis.selectedCombination['reference'] = amThis.combinations[combination]['reference'];
					$('#idCombination'+'_'+amThis.arrayKey).val(amThis.combinations[combination]['idCombination']);

					//get the data of product with these attributes
					quantityAvailable = amThis.combinations[combination]['quantity'];
					amThis.selectedCombination['price'] = amThis.combinations[combination]['price'];
					amThis.selectedCombination['unit_price'] = amThis.combinations[combination]['unit_price'];
					if (amThis.combinations[combination]['ecotax'])
						amThis.selectedCombination['ecotax'] = amThis.combinations[combination]['ecotax'];
					else
						amThis.selectedCombination['ecotax'] = amThis.default_eco_tax;

					//show the large image in relation to the selected combination
//					if (amThis.combinations[combination]['image'] && amThis.combinations[combination]['image'] != -1)
//						displayImage( $('#thumb_'+amThis.combinations[combination]['image']).parent() );

					//update the display
					amThis.updateDisplay();
		/*
					if(typeof(firstTime) != 'undefined' && firstTime)
						refreshProductImages(0);
					else
						refreshProductImages(amThis.combinations[combination]['idCombination']);
					//leave the function because combination has been found
		*/
					return;
				}
			}
			//this combination doesn't exist (not created in back office)
			amThis.selectedCombination['unavailable'] = true;
			amThis.updateDisplay();
	};
	//update display of the availability of the product AND the prices of the product
	this.updateDisplay = function()
	{
		if (!amThis.selectedCombination['unavailable'] && quantityAvailable > 0 && amThis.productAvailableForOrder == 1)
		{
			//show the choice of quantities
			$('#quantity_wanted_p'+'_'+amThis.arrayKey+':hidden').show('slow');

			//show the "add to cart" button ONLY if it was hidden
			$('#add_to_cart'+'_'+amThis.arrayKey+':hidden').fadeIn(600);

			//hide the hook out of stock
			$('#oosHook'+'_'+amThis.arrayKey).hide();

			//availability value management
			if (amThis.availableNowValue != '')
			{
				//update the availability statut of the product
				$('#availability_value'+'_'+amThis.arrayKey).removeClass('warning_inline');
				$('#availability_value'+'_'+amThis.arrayKey).text(amThis.availableNowValue);
				$('#availability_statut'+'_'+amThis.arrayKey+':hidden').show();
			}
			else
			{
				//hide the availability value
				$('#availability_statut'+'_'+amThis.arrayKey+':visible').hide();
			}

			//'last quantities' message management
			if (!amThis.allowBuyWhenOutOfStock)
			{
				if (quantityAvailable <= amThis.maxQuantityToAllowDisplayOfLastQuantityMessage)
					$('#last_quantities'+'_'+amThis.arrayKey).show('slow');
				else
					$('#last_quantities'+'_'+amThis.arrayKey).hide('slow');
			}

			if (amThis.quantitiesDisplayAllowed)
			{
				$('#pQuantityAvailable'+'_'+amThis.arrayKey+':hidden').show('slow');
				$('#quantityAvailable'+'_'+amThis.arrayKey).text(quantityAvailable);

				if (quantityAvailable < 2) // we have 1 or less product in stock and need to show "item" instead of "items"
				{
					$('#quantityAvailableTxt'+'_'+amThis.arrayKey).show();
					$('#quantityAvailableTxtMultiple'+'_'+amThis.arrayKey).hide();
				}
				else
				{
					$('#quantityAvailableTxt'+'_'+amThis.arrayKey).hide();
					$('#quantityAvailableTxtMultiple'+'_'+amThis.arrayKey).show();
				}
			}
		}
		else
		{
			//show the hook out of stock
			if (amThis.productAvailableForOrder == 1)
			{
				$('#oosHook'+'_'+amThis.arrayKey).show();
				if ($('#oosHook'+'_'+amThis.arrayKey).length > 0 && function_exists('oosHookJsCode'))
					oosHookJsCode();
			}

			//hide 'last quantities' message if it was previously visible
			$('#last_quantities'+'_'+amThis.arrayKey+':visible').hide('slow');

			//hide the quantity of pieces if it was previously visible
			$('#pQuantityAvailable'+'_'+amThis.arrayKey+':visible').hide('slow');

			//hide the choice of quantities
			if (!amThis.allowBuyWhenOutOfStock)
				$('#quantity_wanted_p'+'_'+amThis.arrayKey+':visible').hide('slow');

			//display that the product is unavailable with theses attributes
			if (!amThis.selectedCombination['unavailable'])
				$('#availability_value'+'_'+amThis.arrayKey).text(doesntExistNoMore + (amThis.globalQuantity > 0 ? ' ' + doesntExistNoMoreBut : '')).addClass('warning_inline');
			else
			{
				$('#availability_value'+'_'+amThis.arrayKey).text(doesntExist).addClass('warning_inline');
				$('#oosHook'+'_'+amThis.arrayKey).hide();
			}
			$('#availability_statut'+'_'+amThis.arrayKey+':hidden').show();


			//show the 'add to cart' button ONLY IF it's possible to buy when out of stock AND if it was previously invisible
			if(amThis.allowBuyWhenOutOfStock && !amThis.selectedCombination['unavailable'] && amThis.productAvailableForOrder == 1)
			{
				$('#add_to_cart'+'_'+amThis.arrayKey+':hidden').fadeIn(600);

				if (availableLaterValue != '')
				{
					$('#availability_value'+'_'+amThis.arrayKey).text(availableLaterValue);
					$('p#availability_statut'+'_'+amThis.arrayKey+':hidden').show('slow');
				}
				else
					$('p#availability_statut'+'_'+amThis.arrayKey+':visible').hide('slow');
			}
			else
			{
				$('#add_to_cart'+'_'+amThis.arrayKey+':visible').fadeOut(600);
				$('p#availability_statut'+'_'+amThis.arrayKey+':hidden').show('slow');
			}

			if (amThis.productAvailableForOrder == 0)
				$('p#availability_statut'+'_'+amThis.arrayKey+':visible').hide();
		}

		if (amThis.selectedCombination['reference'] || amThis.productReference)
		{
			if (amThis.selectedCombination['reference'])
				$('#product_reference'+'_'+amThis.arrayKey+' span').text(amThis.selectedCombination['reference']);
			else if (amThis.productReference)
				$('#product_reference'+'_'+amThis.arrayKey+' span').text(amThis.productReference);
			$('#product_reference'+'_'+amThis.arrayKey+':hidden').show('slow');
		}
		else
			$('#product_reference'+'_'+amThis.arrayKey+':visible').hide('slow');

		//update display of the the prices in relation to tax, discount, ecotax, and currency criteria
		if (!amThis.selectedCombination['unavailable'] && amThis.productShowPrice == 1)
		{
			// retrieve price without group_reduction in order to compute the group reduction after
			// the specific price discount (done in the JS in order to keep backward compatibility)
			if (!amThis.displayPrice && !amThis.noTaxForThisProduct)
			{
				var priceTaxExclWithoutGroupReduction = ps_round(amThis.productPriceTaxExcluded, 6) * (1 / amThis.group_reduction);
			} else {
				var priceTaxExclWithoutGroupReduction = ps_round(amThis.productPriceTaxExcluded, 6) * (1 / amThis.group_reduction);
			}
			var combination_add_price = amThis.selectedCombination['price'] * amThis.group_reduction;

			var tax = (amThis.taxRate / 100) + 1;
			
			var taxExclPrice = (amThis.specific_price ? (amThis.specific_currency ? amThis.specific_price : amThis.specific_price * amThis.currencyRate) : priceTaxExclWithoutGroupReduction) + amThis.selectedCombination['price'] * amThis.currencyRate;


			if (amThis.specific_price)
				var productPriceWithoutReduction = priceTaxExclWithoutGroupReduction + amThis.selectedCombination['price'] * amThis.currencyRate;

			if (!amThis.displayPrice && !amThis.noTaxForThisProduct)
			{
				var productPrice = taxExclPrice * tax;
				if (amThis.specific_price)
					productPriceWithoutReduction = ps_round(productPriceWithoutReduction * tax, 2);
			}
			else
			{
				var productPrice = ps_round(taxExclPrice, 2);
				if (amThis.specific_price)
					productPriceWithoutReduction = ps_round(productPriceWithoutReduction, 2);
			}

			var reduction = 0;
			if (amThis.reduction_price || amThis.reduction_percent)
			{
	            amThis.reduction_price = (amThis.specific_currency ? amThis.reduction_price : amThis.reduction_price * amThis.currencyRate);
				reduction = productPrice * (parseFloat(amThis.reduction_percent) / 100) + amThis.reduction_price;
				if (amThis.reduction_price && (amThis.displayPrice || amThis.noTaxForThisProduct))
					reduction = ps_round(reduction / tax, 6);
			}

			if (!amThis.specific_price)
				productPriceWithoutReduction = productPrice * amThis.group_reduction;


			productPrice -= reduction;
			var tmp = productPrice * amThis.group_reduction;
			productPrice = ps_round(productPrice * amThis.group_reduction, 2);

			var ecotaxAmount = !amThis.displayPrice ? ps_round(amThis.selectedCombination['ecotax'] * (1 + amThis.ecotaxTax_rate / 100), 2) : amThis.selectedCombination['ecotax'];
			productPrice += ecotaxAmount;
			productPriceWithoutReduction += ecotaxAmount;
			//productPrice = ps_round(productPrice * currencyRate, 2);

			if (productPrice > 0)
				$('#our_price_display'+'_'+amThis.arrayKey).text(amThis.formatCurrency(productPrice, amThis.currencyFormat, amThis.currencySign, amThis.currencyBlank));
			else
				$('#our_price_display'+'_'+amThis.arrayKey).text(amThis.formatCurrency(0, amThis.currencyFormat, amThis.currencySign, amThis.currencyBlank));

			$('#old_price_display'+'_'+amThis.arrayKey).text(amThis.formatCurrency(productPriceWithoutReduction, amThis.currencyFormat, amThis.currencySign, amThis.currencyBlank));

			/* Special feature: "Display product price tax excluded on product page" */
			if (!amThis.noTaxForThisProduct)
				var productPricePretaxed = productPrice / tax;
			else
				var productPricePretaxed = productPrice;
			$('#pretaxe_price_display'+'_'+amThis.arrayKey).text(amThis.formatCurrency(productPricePretaxed, amThis.currencyFormat, amThis.currencySign, amThis.currencyBlank));
			/* Unit price */
	        amThis.productUnitPriceRatio = parseFloat(amThis.productUnitPriceRatio);
			if (amThis.productUnitPriceRatio > 0 )
			{
	        	newUnitPrice = (productPrice / parseFloat(amThis.productUnitPriceRatio)) + amThis.selectedCombination['unit_price'];
				$('#unit_price_display'+'_'+amThis.arrayKey).text(amThis.formatCurrency(newUnitPrice, amThis.currencyFormat, amThis.currencySign, amThis.currencyBlank));
			}

			/* Ecotax */
			var ecotaxAmount = !amThis.displayPrice ? ps_round(amThis.selectedCombination['ecotax'] * (1 + amThis.ecotaxTax_rate / 100), 2) : amThis.selectedCombination['ecotax'];
			$('#ecotax_price_display'+'_'+amThis.arrayKey).text(amThis.formatCurrency(ecotaxAmount, amThis.currencyFormat, amThis.currencySign, amThis.currencyBlank));
		}
	};
	
	
	
};
