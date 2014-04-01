<!-- Block longlistview -->
<div id="longlistview_block_middle" class="block">
    <div class="block_content">
        {foreach $categoryMap as $category => $catArray}
               <div class="row padded">
               <div id="a{$category|upper}" class="productListBlockHeader col-lg-4">
                   <div class="innerTable">
                        <div class="categorySpanner">
                            <span class="categoryText"> {$category} </span>
                        </div>
                   </div>
               </div>
                {foreach $catArray as $product}
                    <div class="productListBlock col-lg-4">
                        <a href="{$product.prodLink|escape:'htmlall':'UTF-8'}" class="product_img_link" title="{$product.name|escape:'htmlall':'UTF-8'}">
                            <img src="{$product.imgLink}"/><br/><br/>
                            <span class="prod_name">{$product['name']}</span><br/>
		            <span class="manufacturer">
                            {$product['manufacturerName']}</span><br/>
                            <span class="price">${$product['price']}</span>
                        </a>
                    </div>
                {/foreach}
                {if isset($product['catLink'])}
                    </div>
                    <div class="row">
                        <div class="dividerImage col-lg-12">
                            <img src="{$product['catLink']}"/>
                        </div>
                    </div>
                {/if}


        {/foreach}
        </div>
</div>
<!-- /Block longlistview -->
