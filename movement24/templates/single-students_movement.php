<?php get_header(); ?>

<div class="container single_container">

    <div class="row gy-4">

        <?php
            while ( have_posts() ) :
                the_post(); 
                
        ?>

        <?php
            $placeholder = plugins_url( '/movement24/assets/img/movement-placeholder.jpg');
            $age = get_field( "age" );
            $division = get_field( "division" );
            $address = get_field( "address" );
            $contact = get_field( "contact_num" );
            $date = get_field("date_of_occ");
            $description = get_field("description");

            // Assuming you are inside the loop, or you have the post ID.
            $post_id = get_the_ID();
            // Get the terms associated with the 'status' taxonomy for this post.
            $terms = wp_get_post_terms($post_id, 'status');
        ?>

        <div class="col-lg-4">
            <div class="card">
                
                <?php 
                    if (has_post_thumbnail()) {
                        $featured_image = get_the_post_thumbnail_url();
                        echo '<img src="' . $featured_image . '" alt="' . get_the_title() . '" class="card-img-top">';
                    } else {
                        echo '<img src="' . $placeholder . '" alt="' . get_the_title() . '" class="card-img-top">';
                    }
                ?>

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
                    <p class="card-text"><strong>Age: </strong>
                        <?php if( $age ) { echo wp_kses_post( $age ); } else {echo 'Will be updated'; } ?>
                    </p>
                    <p class="card-text"><strong>Address: </strong>
                        <?php if( $address ) { echo wp_kses_post( $address ); } else {echo 'Will be updated'; } ?>
                    </p>
                    <p class="card-text"><strong>Division: </strong>
                        <?php if( $division ) { echo wp_kses_post( $division ); } else {echo 'Will be updated'; } ?>
                    </p>
                    <p class="card-text"><strong>Contact: </strong>
                        <?php if( $contact ) { echo wp_kses_post( $contact ); } else {echo 'Will be updated'; } ?>
                    </p>
                </div>
            </div>
        
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5>Date of <?php 
                        if (!is_wp_error($terms) && !empty($terms)) {
                            foreach ($terms as $term) {
                                // Output the term name.
                                echo esc_html($term->name) . '<br>';
                            }
                        } else {
                            echo 'Will be updated';
                        }
                        ?></h5>
                    <p>
                        <?php if( $date ) { echo wp_kses_post( $date ); }
                        else {  echo 'Data will be updated soon.'; }?>
                    </p>
					<span style="height: 15px; display: block;"></span>
                    <h5>Description</h5>
                    <p>
                        <?php if( $description ) { echo wp_kses_post( $description ); }
                        else {  echo 'Data will be updated soon.'; }?>
                    </p>

                </div>
            </div>
        </div>

        <?php
            // If comments are open or there is at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;

        endwhile; // End of the loop. ?>


    </div>

</div>



<?php get_footer(); ?>