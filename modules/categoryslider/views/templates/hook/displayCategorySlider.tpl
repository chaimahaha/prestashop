<div class="category-slider-container">
    <div class="category-slider">
        {foreach from=$subcategories item=subcategory}
            <div class="slider-item">
                {assign var='defaultImage' value=$link->getMediaLink($module_dir|cat:'views/img/default-category.jpeg')}

                {if isset($subcategory.image) && $subcategory.image}
                    {assign var='subcategoryImage' value=$subcategory.image}
                {else}
                    {assign var='subcategoryImage' value=$defaultImage}
                {/if}

                <a href="{$link->getCategoryLink($subcategory.id_category)}">
                    <img src="{$subcategoryImage}" alt="{$subcategory.name}" class="subcategory-image" />
                    <h6>{$subcategory.name}</h6>
                </a>
            </div>
        {/foreach}
    </div>
</div>