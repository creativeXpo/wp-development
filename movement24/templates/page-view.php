<?php 
/*
Template Name: Page View
*/
?>

<?php get_header(); ?>

<div class="container-fluid stu_movement_home">

    <div class="page-header">
        <div class="page_title"><h4>The list of Martyrs, Injured, and Missing occurred during the Students Movement 2024</h4></div>
    </div>

</div>

<div class="container">
    <div class="row gx-2 gx-md-4">
        <div class="col-lg-4 col-sm-4 col-4">
            <?php
            $term_slug = 'martyr';
            $term = get_term_by('slug', $term_slug, 'status');
            $term_link = get_term_link($term);
            ?>
            <a href="<?php echo esc_url($term_link); ?>" class="status_link one">
                <div class="martyrs mim_col">
                    <span class="martyrs_title">Martyrs:</span>
                    <span class="martyrs_count">
                    <?php
                    if ($term && !is_wp_error($term)) {
                        // Get the count of posts associated with this term.
                        $post_count = $term->count;

                        // Output the post count.
                        echo esc_html($post_count);
                    } else {
                        echo '0';
                    }
                    ?>
                    </span>
                </div>
            </a>
        </div>

        <div class="col-lg-4 col-sm-4 col-4">
            <?php
            $term_slug = 'injured';
            $term = get_term_by('slug', $term_slug, 'status');
            $term_link = get_term_link($term);
            ?>

            <a href="<?php echo esc_url($term_link); ?>" class="status_link two">
                <div class="injured mim_col">
                    <span class="injured_title">Injured:</span>
                    <span class="injured_count">
                    <?php
                    if ($term && !is_wp_error($term)) {
                        // Get the count of posts associated with this term.
                        $post_count = $term->count;

                        // Output the post count.
                        echo esc_html($post_count);
                    } else {
                        echo '0';
                    }
                    ?>
                    </span>
                </div>
            </a>
        </div> 

        <div class="col-lg-4 col-sm-4 col-4">
            <?php
            $term_slug = 'missing';
            $term = get_term_by('slug', $term_slug, 'status');
            $term_link = get_term_link($term);
            ?>
            <a href="<?php echo esc_url($term_link); ?>" class="status_link three">
                <div class="missing mim_col">
                    <span class="missing_title">Missing:</span>
                    <span class="missing_count">
                    <?php
                    if ($term && !is_wp_error($term)) {
                        // Get the count of posts associated with this term.
                        $post_count = $term->count;

                        // Output the post count.
                        echo esc_html($post_count);
                    } else {
                        echo '0';
                    }
                    ?>
                    </span>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="container">

    <div class="row gx-3 gx-md-4 gy-3 gy-md-4 persons-wrapper">

        <?php

        $args = array(
            'post_type'      => 'students_movement', // Your custom post type
            'posts_per_page' => -1,
            'order'          => 'DESC',              // Order by date
            'orderby'        => 'date',              // Order by date
        );

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post();

                $placeholder = plugins_url('/movement24/assets/img/movement-placeholder.jpg');
                $division = get_field("division");

                // Assuming you are inside the loop, or you have the post ID.
                $post_id = get_the_ID();
                // Get the terms associated with the 'status' taxonomy for this post.
                $terms = wp_get_post_terms($post_id, 'status');
        ?>

        <div class="col-lg-3 col-6 person-item">
            <div class="card">
                <a href="<?php the_permalink(); ?>">
                    <?php 
                        if (has_post_thumbnail()) {
                            $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'red-featured-img');
                            echo '<img src="' . $featured_image . '" alt="' . get_the_title() . '" class="card-img-top">';
                        } else {
                            echo '<img src="' . $placeholder . '" alt="' . get_the_title() . '" class="card-img-top">';
                        }
                    ?>
                </a>
                
                <div class="card-body">
                    <p class="card-title"><strong>Name: </strong><?php the_title(); ?></p>
                    <p class="card-text"><strong>Status: </strong>
                        <?php 
                        if (!is_wp_error($terms) && !empty($terms)) {
                            foreach ($terms as $term) {
                                // Output the term name.
                                echo esc_html($term->name) . '<br>';
                            }
                        } else {
                            echo 'Will be updated';
                        }
                        ?>
                    </p>
                    <p class="card-text"><strong>Division: </strong>
                        <?php if( $division ) { echo wp_kses_post( $division ); } else {echo 'Will be updated'; }?>
                    </p>
                    <a href="<?php the_permalink(); ?>" class="person_details">View Details</a>
                </div>
            </div>
        </div>

        <?php endwhile; ?>        

        <?php else : ?>

        <p><?php _e('No results found.', 'movement24'); ?></p>

        <?php 
        endif;
        // Reset post data after custom query
        wp_reset_postdata();
        ?>

    </div>
</div>

<?php get_footer(); ?>