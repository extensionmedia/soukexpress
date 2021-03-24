<div data-lavel="<?= $lavel ?>" data-parent_id="<?= $parent ?>" data-id="<?= $category["id"] ?>" 
    class="load_sous_category relative flex items-center mb-2 border rounded hover:bg-gray-100 cursor-pointer">
    <div class="p-1 m-1 mr-3 border bg-white relative">
        <img alt="Image" src="<?= $category["image_url"] ?>" class="h-16 w-16">
        <span class="absolute top-0 left-0 -m-1 bg-blue-600 text-white text-xs px-1 rounded"># <?= $category["ord"] ?></span>
    </div>
    <div class="text-xs">
        <div><?= $category["article_category_fr"] ?></div>
        <div><?= $category["article_category_es"] ?></div>
        <div><?= $category["article_category_ar"] ?></div>
    </div>
    <div class="absolute top-0 right-0 m-1 rounded bg-gray-500 text-gray-100 text-xs px-1"><?= $category["id"] ?></div>
    <div class="absolute bottom-0 right-0 m-2">
        <button data-id="<?= $category["id"] ?>" class="category_edit rounded bg-gray-200 text-gray-600 text-xs py-1 pb-2 px-3">تغيير</button>
    </div>
</div>