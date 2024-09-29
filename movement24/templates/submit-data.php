<?php
/* Template Name: Submit Data */

ob_start(); // Start output buffering
get_header();

// Include necessary WordPress files for handling media uploads
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['acf'])) {
        // Create a new post
        $post_data = array(
            'post_title'   => sanitize_text_field($_POST['acf']['post_title']),
            'post_status'  => 'publish',
            'post_type'    => 'students_movement',  // Custom post type
        );
    
        // Insert the post into the database
        $post_id = wp_insert_post($post_data);
    
        if ($post_id) {
            // Set the featured image
            if (!empty($_FILES['featured_image']['name'])) {
                $attachment_id = media_handle_upload('featured_image', $post_id);
                set_post_thumbnail($post_id, $attachment_id);
            }
    
            // Update ACF fields
            update_field('age', sanitize_text_field($_POST['acf']['age']), $post_id);
            update_field('division', sanitize_text_field($_POST['acf']['division']), $post_id);
            update_field('address', sanitize_textarea_field($_POST['acf']['address']), $post_id);
            update_field('contact_num', sanitize_text_field($_POST['acf']['contact_num']), $post_id);
            update_field('date_of_occ', sanitize_text_field($_POST['acf']['date_of_occ']), $post_id);
            update_field('description', sanitize_textarea_field($_POST['acf']['description']), $post_id);
    
            // Assign the selected status term (custom taxonomy) using term ID
            if (!empty($_POST['status_category'])) {
                $status_term_id = intval($_POST['status_category']);
                wp_set_post_terms($post_id, array($status_term_id), 'status', false);
            }

            // Redirect to avoid form resubmission on page refresh
            wp_redirect(esc_url(add_query_arg('submission', 'success', $_SERVER['REQUEST_URI'])));
            exit;
        } else {
            wp_redirect(esc_url(add_query_arg('submission', 'error', $_SERVER['REQUEST_URI'])));
            exit;
        }
    }
}

// Handle the redirect and display a success or error message based on the query parameter
if (isset($_GET['submission']) && $_GET['submission'] === 'success') {
    echo '<div class="alert alert-success text-center" style="margin-top: ">Thank you for your submission!</div>';
} elseif (isset($_GET['submission']) && $_GET['submission'] === 'error') {
    echo '<div class="alert alert-danger text-center">There was an error with your submission. Please try again.</div>';
}

?>

<div class="container my-5">
    
    <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" id="frontend-submission-form" method="POST" enctype="multipart/form-data" class="submit-data">
        <div class="row gy-3">
            <div class="col-sm-6">
                <label for="post_title" class="form-label">Name:</label>
                <input type="text" id="post_title" name="acf[post_title]" class="form-control" required>
            </div>

            <div class="col-sm-6">
                <label for="status_category" class="form-label">Status:</label>
                <select id="status_category" name="status_category" class="form-select" required>
                    <option value="">Select One</option>
                    <?php
                    $terms = get_terms(array(
                        'taxonomy' => 'status',
                        'hide_empty' => false,
                    ));

                    foreach ($terms as $term) {
                        echo '<option value="' . esc_attr($term->term_id) . '">' . esc_html(ucwords($term->name)) . '</option>';
                    }
                    
                    ?>
                </select>
            </div>



            <div class="col-sm-6">
                <label for="age" class="form-label">Age:</label>
                <input type="text" id="age" name="acf[age]" class="form-control">
            </div>

            <div class="col-sm-6">
                <label for="contact_num" class="form-label">Contact Number:</label>
                <input type="text" id="contact_num" name="acf[contact_num]" class="form-control">
            </div>

            <div class="col-sm-6">
                <label for="date_of_occ" class="form-label">Date of Occurrence:</label>
                <input type="date" id="date_of_occ" name="acf[date_of_occ]" class="form-control">
            </div>
                    
             <div class="col-sm-6">
                <label for="division" class="form-label">Division:</label>
                <select id="division" name="acf[division]" class="form-select">
                <option value="Select One">Select One</option>
                <option value="Barishal">Barishal</option>
                <option value="Chattogram">Chattogram</option>
                <option value="Dhaka">Dhaka</option>
                <option value="Khulna">Khulna</option>
                <option value="Rajshahi">Rajshahi</option>
                <option value="Rangpur">Rangpur</option>
                <option value="Mymensingh">Mymensingh</option>
                <option value="Sylhet">Sylhet</option>
                </select>
            </div>
            
            <div class="col-sm-6">
                <label for="address" class="form-label">Address:</label>
                <textarea id="address" name="acf[address]" class="form-control" rows="3"></textarea>
            </div>

            <div class="col-sm-6">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="acf[description]" class="form-control" rows="3"></textarea>
            </div>

            <div class="col-12">
                <label for="featured_image" class="form-label">Image:</label>
                <input type="file" id="featured_image" name="featured_image" class="form-control" accept="image/*">
            </div>

            <div class="submit-btn">
                <button type="submit" class="submit-btn-btn">Submit</button>
            </div>
        </div>
    </form>
    
</div>

<?php
get_footer();
ob_end_flush(); // End output buffering and send output