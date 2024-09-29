<?php
/* Template Name: Submit Data */
get_header();

// Include necessary WordPress files for handling media uploads
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

if (isset($_POST['acf'])) {
    // Create a new post
    $post_data = array(
        'post_title'   => sanitize_text_field($_POST['acf']['post_title']),
        'post_status'  => 'publish',
        'post_type'    => 'students_movement',  // Or your custom post type
    );

    // Insert the post into the database
    $post_id = wp_insert_post($post_data);

    if ($post_id) {
        // Set the featured image using WordPress default post thumbnail
        if (!empty($_FILES['featured_image']['name'])) {
            $attachment_id = media_handle_upload('featured_image', $post_id);
            set_post_thumbnail($post_id, $attachment_id);
        }

        // Update ACF fields
        update_field('cates', sanitize_text_field($_POST['acf']['cates']), $post_id);
        update_field('age', sanitize_text_field($_POST['acf']['age']), $post_id);
        update_field('division', sanitize_text_field($_POST['acf']['division']), $post_id);
        update_field('address', sanitize_textarea_field($_POST['acf']['address']), $post_id);
        update_field('contact_num', sanitize_text_field($_POST['acf']['contact_num']), $post_id);
        update_field('date_of_occ', sanitize_text_field($_POST['acf']['date_of_occ']), $post_id);
        update_field('description', sanitize_textarea_field($_POST['acf']['description']), $post_id);

        // Redirect to a thank you page or display a success message
        echo '<div class="alert alert-success">Thank you for your submission!</div>';
    } else {
        echo '<div class="alert alert-danger">There was an error with your submission. Please try again.</div>';
    }
}
?>


<div class="container my-5">
    <form id="frontend-submission-form" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="post_title" class="form-label">Name:</label>
            <input type="text" id="post_title" name="acf[post_title]" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="cates" class="form-label">Status:</label>
            <select id="cates" name="acf[cates]" class="form-select" required>
            <option value="select one">Select One</option>
            <option value="martyr">Martyr</option>
            <option value="injured">Injured</option>
            <option value="missing">Missing</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Age:</label>
            <input type="text" id="age" name="acf[age]" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="division" class="form-label">Division:</label>
            <select id="division" name="acf[division]" class="form-select" required>
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

        <div class="mb-3">
            <label for="address" class="form-label">Address:</label>
            <textarea id="address" name="acf[address]" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="contact_num" class="form-label">Contact Number:</label>
            <input type="text" id="contact_num" name="acf[contact_num]" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="date_of_occ" class="form-label">Date of Occurrence:</label>
            <input type="text" id="date_of_occ" name="acf[date_of_occ]" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea id="description" name="acf[description]" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="featured_image" class="form-label">Featured Image:</label>
            <input type="file" id="featured_image" name="featured_image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php
get_footer();
?>
