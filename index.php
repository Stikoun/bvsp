<?php
$latte = new Latte\Engine;
$finder = function (Latte\Runtime\Template $template) {
    if (!$template->getReferenceType()) {
        // vrací cestu k souboru s layoutem
        return __DIR__.'/templates/@layout.latte';
    }
};
$latte->addProvider('coreParentFinder', $finder);
$latte->setTempDirectory(__DIR__.'/temp/cache');

$params = [
    'items' => ['one', 'two', 'three'],
];

$dir = "Page";
$file = "page";

if (is_front_page()) {
    $file = "home";
} elseif (is_page()) {
    $slug = get_post_field('post_name', get_post());
    if (file_exists(__DIR__. "/templates/$dir/$slug.latte")) {
        $file = $slug;
    }
} elseif (is_post_type_archive("blog") || is_tax("rubrika") || is_tax("stitek")) {
    $dir = "Blog";
    $file = "list";
} elseif (is_singular("blog")) {
    $dir = "Blog";
    $file = "article";
} elseif (is_post_type_archive("training_group")) {
    $dir = "Groups";
    $file = "list";
} elseif (is_singular("training_group")) {
    $dir = "Groups";
    $file = "post";
} elseif (is_singular("facility")) {
    $dir = "Facilities";
    $file = "post";
} elseif (is_404()) {
    $dir = "Error";
    $file = "404";
} elseif (is_home() || is_category() || is_date() || is_tag() || is_tax("arealy")) {
    $dir = "News";
    $file = "list";
} elseif (is_singular("product")) {
 //Get here path of single-product.php from WooCommerce plugin
    $dir = "Product";
    $file = "single-product";
} elseif (is_single()) {
    $dir = "News";
    $file = "post";
}

bdump($dir, $file);
$latte->render(__DIR__. "/templates/$dir/$file.latte", $params);
