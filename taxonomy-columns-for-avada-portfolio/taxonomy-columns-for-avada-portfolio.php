<?php
/*
Plugin Name: Taxonomy Columns for Avada Portfolio
Description: Adds custom taxonomy columns for Avada Portfolio post type.
Version: 1.0
Author: Muhammad Hassan
Author URI: https://mhassan.pro
*/

// Add custom columns for taxonomies
function custom_portfolio_columns( $columns ) {
    $columns['portfolio_category'] = 'Portfolio Category';
    $columns['portfolio_skills'] = 'Portfolio Skills';
    $columns['portfolio_tags'] = 'Portfolio Tags';
    return $columns;
}
add_filter( 'manage_avada_portfolio_posts_columns', 'custom_portfolio_columns' );

// Populate custom columns with taxonomy data
function custom_portfolio_column_data( $column, $post_id ) {
    switch ( $column ) {
        case 'portfolio_category':
            custom_portfolio_display_taxonomy_column( $post_id, 'portfolio_category', 'Portfolio Category' );
            break;
        case 'portfolio_skills':
            custom_portfolio_display_taxonomy_column( $post_id, 'portfolio_skills', 'Portfolio Skills' );
            break;
        case 'portfolio_tags':
            custom_portfolio_display_taxonomy_column( $post_id, 'portfolio_tags', 'Portfolio Tags' );
            break;
    }
}
add_action( 'manage_avada_portfolio_posts_custom_column', 'custom_portfolio_column_data', 10, 2 );

// Function to display taxonomy data in custom columns
function custom_portfolio_display_taxonomy_column( $post_id, $taxonomy, $taxonomy_name ) {
    $terms = get_the_terms( $post_id, $taxonomy );
    if ( !empty( $terms ) ) {
        $output = array();
        foreach ( $terms as $term ) {
            $term_link = admin_url( 'edit.php?post_type=avada_portfolio&' . $taxonomy . '=' . $term->slug );
            $output[] = '<a href="' . esc_url( $term_link ) . '">' . $term->name . '</a>';
        }
        echo implode( ', ', $output );
    } else {
        echo 'No ' . $taxonomy_name;
    }
}
