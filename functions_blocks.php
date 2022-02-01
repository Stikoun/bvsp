<?php
add_action('acf/init', 'my_acf_init_block_types');
function my_acf_init_block_types()
{
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'video',
            'title'             => __('Úvodní video'),
            'description'       => __('Blok s úvodním videem.'),
            'render_template'   => 'block_templates.php',
            'category'          => 'bvsp',
            'icon'              => 'format-video',
            'keywords'          => array( 'bvsp', 'video' ),
            'enqueue_style'     => get_template_directory_uri() . '/dist/app.css'
        ));
        acf_register_block_type(array(
            'name'              => 'video-2',
            'title'             => __('Video, seznam'),
            'description'       => __('Blok s videem, listem, tlačítkem a odkazy videem.'),
            'render_template'   => 'block_templates.php',
            'category'          => 'bvsp',
            'icon'              => 'format-video',
            'keywords'          => array( 'bvsp', 'video' ),
            'enqueue_style'     => get_template_directory_uri() . '/dist/app.css'
        ));
        acf_register_block_type(array(
            'name'              => 'testimonial',
            'title'             => __('Slovo trenéra'),
            'description'       => __('Blok s citací a seznamem výhod.'),
            'render_template'   => 'block_templates.php',
            'category'          => 'bvsp',
            'icon'              => 'format-quote',
            'keywords'          => array( 'bvsp', 'slovo', 'citace','trenér' ),
            'enqueue_style'     => get_template_directory_uri() . '/dist/app.css',
            'supports'          => array(
                'jsx' => true
            )
        ));
        acf_register_block_type(array(
            'name'              => 'partners',
            'title'             => __('Partneři'),
            'description'       => __('Blok se seznamem partnerů včetně jejich log a prokliku.'),
            'render_template'   => 'block_templates.php',
            'category'          => 'bvsp',
            'icon'              => 'format-quote',
            'keywords'          => array( 'bvsp', 'partněři' ),
            'enqueue_style'     => get_template_directory_uri() . '/dist/app.css',
            'supports'          => array(
                'jsx' => true
            )
        ));
        acf_register_block_type(array(
            'name'              => 'cta-person',
            'title'             => __('CTA - Kontakt na osobu'),
            'description'       => __('Blok s fotografií a kontaktními údaji jedné osoby.'),
            'render_template'   => 'block_templates.php',
            'category'          => 'bvsp',
            'icon'              => 'format-quote',
            'keywords'          => array( 'bvsp', 'kontakt' ,'trenér' ),
            'enqueue_style'     => get_template_directory_uri() . '/dist/app.css',
            'supports'          => array(
                'jsx' => true
            )
        ));
        acf_register_block_type(array(
            'name'              => 'cta-person-2',
            'title'             => __('CTA - Osoba s textem a tlačítky'),
            'description'       => __('Blok s fotografií, textem a tlačítky.'),
            'render_template'   => 'block_templates.php',
            'category'          => 'bvsp',
            'icon'              => 'format-quote',
            'keywords'          => array( 'bvsp' ),
            'enqueue_style'     => get_template_directory_uri() . '/dist/app.css',
            'supports'          => array(
                'jsx' => true
            )
        ));
        acf_register_block_type(array(
            'name'              => 'list-pluses',
            'title'             => __('Seznam plusů'),
            'description'       => __('Blok tvořící seznam plusů/výhod.'),
            'render_template'   => 'block_templates.php',
            'category'          => 'bvsp',
            'icon'              => 'format-quote',
            'keywords'          => array( 'bvsp', 'seznam' ,'list' ),
            'enqueue_style'     => get_template_directory_uri() . '/dist/app.css',
            'supports'          => array(
                'jsx' => true
            )
        ));
        acf_register_block_type(array(
            'name'              => 'group-links',
            'title'             => __('Skupina odkazů'),
            'description'       => __('Blok tvořící skupinu odkazů.'),
            'render_template'   => 'block_templates.php',
            'category'          => 'bvsp',
            'icon'              => 'format-quote',
            'keywords'          => array( 'bvsp', 'seznam' ,'odkazy' ),
            'enqueue_style'     => get_template_directory_uri() . '/dist/app.css',
            'supports'          => array(
                'jsx' => true
            )
        ));
        acf_register_block_type(array(
            'name'              => 'table',
            'title'             => __('Tabulka'),
            'description'       => __('Blok tvořící tabulku s obsahem.'),
            'render_template'   => 'block_templates.php',
            'category'          => 'bvsp',
            'icon'              => 'format-quote',
            'keywords'          => array( 'bvsp', 'tabulka' ),
            'enqueue_style'     => get_template_directory_uri() . '/dist/app.css',
            'supports'          => array(
                'jsx' => true
            )
        ));
        acf_register_block_type(array(
            'name'              => 'icons',
            'title'             => __('Ikonky'),
            'description'       => __('Blok generující ikonky s nadpisem či bez.'),
            'render_template'   => 'block_templates.php',
            'category'          => 'bvsp',
            'icon'              => 'format-quote',
            'keywords'          => array( 'bvsp', 'ikonky' ),
            'enqueue_style'     => get_template_directory_uri() . '/dist/app.css',
            'supports'          => array(
                'jsx' => true
            )
        ));
        acf_register_block_type(array(
            'name'              => 'blue-stain',
            'title'             => __('Text - skvrna'),
            'description'       => __('Text s pozadím modré skvrny.'),
            'render_template'   => 'block_templates.php',
            'category'          => 'bvsp',
            'icon'              => 'format-quote',
            'keywords'          => array( 'bvsp', 'skvrna' ),
            'enqueue_style'     => get_template_directory_uri() . '/dist/app.css',
            'supports'          => array(
                'jsx' => true
            )
        ));
        acf_register_block_type(array(
            'name'              => 'button',
            'title'             => __('Tlačítko - červené/žluté'),
            'description'       => __('Tlačítko šablony'),
            'render_template'   => 'block_templates.php',
            'category'          => 'bvsp',
            'icon'              => 'format-quote',
            'keywords'          => array( 'bvsp', 'skvrna' ),
            'enqueue_style'     => get_template_directory_uri() . '/dist/app.css',
            'supports'          => array(
                'jsx' => true
            )
        ));
    }
}
