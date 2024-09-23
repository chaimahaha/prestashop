{if $subcategories}
    <div class="category-slider">
        {foreach from=$subcategories item=subcategory}
            <div class="subcategory-item">
                <img src="{$subcategory.image}" alt="{$subcategory.name}" class="subcategory-image">
                <p>{$subcategory.name}</p>
                <p>{$subcategory.product_count} produits</p>
            </div>
        {/foreach}
    </div>
{else}
    <p>Aucune sous-catégorie trouvée.</p>
{/if}
