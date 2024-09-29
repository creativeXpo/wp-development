
/*Post Query*/

<?php
if ( have_posts() ) : 
    while ( have_posts() ) : the_post(); 
        ?>
        <div class="students-movement-entry">
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="students-movement-meta">
                <span class="date"><?php echo get_the_date(); ?></span>
            </div>
            <div class="students-movement-content">
                <?php the_excerpt(); ?>
            </div>
        </div>
        <?php 
    endwhile; 

    // Pagination
    the_posts_pagination( array(
        'mid_size'  => 2,
        'prev_text' => __( '« Previous', 'textdomain' ),
        'next_text' => __( 'Next »', 'textdomain' ),
    ) );

else : 
    ?>
    <p><?php _e( 'No student movements found.', 'textdomain' ); ?></p>
    <?php
endif;
?>

/*Custom Post Type Query*/

<?php
$args = array(
    'post_type'      => 'students_movement', // Your custom post type
    'posts_per_page' => 10,                  // Number of posts per page
    'order'          => 'DESC',              // Order by date
    'orderby'        => 'date',              // Order by date
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) :
    while ( $query->have_posts() ) : $query->the_post();
        ?>
        <div class="students-movement-entry">
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="students-movement-meta">
                <span class="date"><?php echo get_the_date(); ?></span>
            </div>
            <div class="students-movement-content">
                <?php the_excerpt(); ?>
            </div>
        </div>
        <?php
    endwhile;

    // Pagination
    the_posts_pagination( array(
        'mid_size'  => 2,
        'prev_text' => __( '« Previous', 'textdomain' ),
        'next_text' => __( 'Next »', 'textdomain' ),
    ) );

    // Reset post data after custom query
    wp_reset_postdata();

else :
    ?>
    <p><?php _e( 'No student movements found.', 'textdomain' ); ?></p>
    <?php
endif;
?>


/****Single Post*****/

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        while ( have_posts() ) :
            the_post();
        ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                    hello world
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <?php
                    the_content();

                    // If you want to display custom fields created with ACF
                    if ( function_exists('get_field') ) {
                        $field_value = get_field('your_acf_field_name');
                        if ( $field_value ) {
                            echo '<p>' . esc_html($field_value) . '</p>';
                        }
                    }
                    ?>
                </div><!-- .entry-content -->

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail(); ?>
                    </div>
                <?php endif; ?>

                <footer class="entry-footer">
                    <?php
                    // Display categories and tags
                    the_category();
                    the_tags('<span class="tag-links">', '', '</span>');
                    ?>
                </footer><!-- .entry-footer -->
            </article><!-- #post-<?php the_ID(); ?> -->

            <?php
            // If comments are open or there is at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;

        endwhile; // End of the loop.
        ?>
    </main><!-- #main -->
</div><!-- #primary -->


















<div class="row">

    <?php
    // Get current page number
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

    $args = array(
        'post_type'      => 'students_movement', // Your custom post type
        'posts_per_page' => 10,                  // Number of posts per page
        'order'          => 'DESC',              // Order by date
        'orderby'        => 'date',              // Order by date
        'paged'          => $paged,              // Enable pagination
    );

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) :
    while ( $query->have_posts() ) : $query->the_post(); ?>

    <?php
        $placeholder = plugins_url( '/movement24/assets/img/movement-placeholder.jpg');
        $img = get_field("image");
        $img_name = basename( $img );
        $profession = get_field( "profession" );
        $status = get_field( "martyr__cat" );
        $address = get_field( "address" );
    ?>

    <div class="col-lg-3">
        <div class="card">
            <a href="<?php the_permalink(); ?>"><img src=" <?php if( $img ) { echo wp_kses_post( $img ); }
                    else {  echo esc_url( $placeholder ) ; }?>" class="card-img-top" alt="<?php if( $img_name ) { echo wp_kses_post( $img_name ); } else {  echo 'Students Movement 2024'; }?>"></a>
            <div class="card-body">
                <h6 class="card-title"><strong>Name: </strong><?php the_title(); ?></h6>
                <h6 class="card-text"><strong>Profession: </strong>
                <?php if( $profession ) { echo wp_kses_post( $profession ); }?>
                </h6>
                <h6 class="card-text"><strong>Status: </strong>
                <?php if( $status ) { echo wp_kses_post( $status ); }?>
                </h6>
                <p class="card-text"><strong>Address: </strong>
                    <?php if( $address ) { echo wp_kses_post( $address ); }?>
                </p>
                <a href="<?php the_permalink(); ?>" class="btn btn-primary">View Details</a>
            </div>
        </div>
    </div>

    <?php endwhile;

    // Pagination
    the_posts_pagination( array(
        'mid_size'  => 2,
        'prev_text' => __( '« Previous', 'movement24' ),
        'next_text' => __( 'Next »', 'movement24' ),
    ) );

    // Reset post data after custom query
    wp_reset_postdata();
    
    else : 
    ?>
    <p><?php _e( 'No result found.', 'movement24' ); ?></p>
    <?php endif; ?>

</div>




/////////// Category Query 


<?php
get_header(); // Include the header

// Get the current page number
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Get the queried object (the current term being viewed)
$term = get_queried_object();

// Query arguments
$args = array(
    'post_type'      => 'students_movement',
    'posts_per_page' => 10, // Number of posts per page
    'paged'          => $paged, // Current page
    'tax_query'      => array(
        array(
            'taxonomy' => 'status',
            'field'    => 'slug',
            'terms'    => $term->slug, // Use the current term's slug
        ),
    ),
);

// The Query
$query = new WP_Query( $args );

// The Loop
if ( $query->have_posts() ) {
    echo '<div class="students-movement-list">';
    echo '<h1>' . single_term_title('', false) . '</h1>'; // Display the term title
    while ( $query->have_posts() ) {
        $query->the_post();
        echo '<div class="student-movement-item">';
        echo '<h2>' . get_the_title() . '</h2>';
        echo '<div>' . get_the_content() . '</div>';
        echo '</div>';
    }
    echo '</div>';

    // Pagination
    $big = 999999999; // Need an unlikely integer
    echo paginate_links( array(
        'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'  => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total'   => $query->max_num_pages,
    ) );
} else {
    echo '<p>No students found for this status.</p>';
}

// Restore original Post Data
wp_reset_postdata();

get_footer(); // Include the footer
?>









