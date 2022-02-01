<?php
/**
 * Video Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$block_name = explode('/',$block['name'])[1];
$latte = new Latte\Engine;
$latte->setTempDirectory(__DIR__.'/temp/cache');
$latte->render(__DIR__. "/templates/blocks/$block_name.latte", $block);
