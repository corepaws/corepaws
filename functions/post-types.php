<?php

// WordPress: Removes Placement Meta Taxonomy box from editor view - shown with AFC
add_action('admin_menu', 'remove_custom_taxonomy_pet');
function remove_custom_taxonomy_pet()
{
    remove_meta_box('tagsdiv-reason_for_placement', 'pet', 'side');
}

//WordPress: Registers Custom Post Types
add_action('init', 'register_custom_post_types');
function register_custom_post_types()
{
    $labels = array(
        "name" => "Pets",
        "singular_name" => "Pet",
    );

    $args = array(
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "show_ui" => true,
        "has_archive" => false,
        "show_in_menu" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array("slug" => "adoption-information", "with_front" => true),
        "query_var" => true,
        "menu_icon" => "dashicons-heart",
        "supports" => array("title", "editor", "excerpt", "thumbnail"),
    );
    register_post_type("pet", $args);

}

// WordPress: Registers Custom Taxonomies
add_action('init', 'register_custom_taxonomies');
function register_custom_taxonomies()
{

    $labels = array(
        "name" => "reason_for_placement",
        "label" => "Reasons for Placement",
        "menu_name" => "Reason for Placement",
    );

    $args = array(
        "labels" => $labels,
        "hierarchical" => false,
        "label" => "Reasons for Placement",
        "show_ui" => true,
        "query_var" => true,
        "rewrite" => array('slug' => 'reason_for_placement', 'with_front' => true),
        "show_admin_column" => false,
    );
    register_taxonomy("reason_for_placement", array("pet"), $args);

}

?>
