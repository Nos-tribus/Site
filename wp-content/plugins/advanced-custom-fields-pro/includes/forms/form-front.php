<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'acf_form_front' ) ) :
	#[AllowDynamicProperties]
	class acf_form_front {

		/** @var array An array of registered form settings */
		private $forms = array();

		/** @var array An array of default fields */
		public $fields = array();


		/**
		 * This function will setup the class functionality
		 *
		 * @type    function
		 * @date    5/03/2014
		 * @since   5.0.0
		 *
		 * @param   n/a
		 * @return  n/a
		 */
		function __construct() {

			// vars
			$this->fields = array(

				'_post_title'     => array(
					'prefix'   => 'acf',
					'name'     => '_post_title',
					'key'      => '_post_title',
					'label'    => __( 'Title', 'acf' ),
					'type'     => 'text',
					'required' => true,
				),

				'_post_content'   => array(
					'prefix' => 'acf',
					'name'   => '_post_content',
					'key'    => '_post_content',
					'label'  => __( 'Content', 'acf' ),
					'type'   => 'wysiwyg',
				),

				'_validate_email' => array(
					'prefix'  => 'acf',
					'name'    => '_validate_email',
					'key'     => '_validate_email',
					'label'   => __( 'Validate Email', 'acf' ),
					'type'    => 'text',
					'value'   => '',
					'wrapper' => array( 'style' => 'display:none !important;' ),
				),

			);

			// actions
			add_action( 'acf/validate_save_post', array( $this, 'validate_save_post' ), 1 );

			// filters
			add_filter( 'acf/pre_save_post', array( $this, 'pre_save_post' ), 5, 2 );
		}


		/**
		 * description
		 *
		 * @type    function
		 * @date    28/2/17
		 * @since   5.5.8
		 *
		 * @param   $post_id (int)
		 * @return  $post_id (int)
		 */
		function validate_form( $args ) {

			// defaults
			// Todo: Allow message and button text to be generated by CPT settings.
			$args = wp_parse_args(
				$args,
				array(
					'id'                    => 'acf-form',
					'post_id'               => false,
					'new_post'              => false,
					'field_groups'          => false,
					'fields'                => false,
					'post_title'            => false,
					'post_content'          => false,
					'form'                  => true,
					'form_attributes'       => array(),
					'return'                => add_query_arg( 'updated', 'true', acf_get_current_url() ),
					'html_before_fields'    => '',
					'html_after_fields'     => '',
					'submit_value'          => __( 'Update', 'acf' ),
					'updated_message'       => __( 'Post updated', 'acf' ),
					'label_placement'       => 'top',
					'instruction_placement' => 'label',
					'field_el'              => 'div',
					'uploader'              => 'wp',
					'honeypot'              => true,
					'html_updated_message'  => '<div id="message" class="updated"><p>%s</p></div>', // 5.5.10
					'html_submit_button'    => '<input type="submit" class="acf-button button button-primary button-large" value="%s" />', // 5.5.10
					'html_submit_spinner'   => '<span class="acf-spinner"></span>', // 5.5.10
					'kses'                  => true, // 5.6.5
				)
			);

			$args['form_attributes'] = wp_parse_args(
				$args['form_attributes'],
				array(
					'id'     => $args['id'],
					'class'  => 'acf-form',
					'action' => '',
					'method' => 'post',
				)
			);

			// filter post_id
			$args['post_id'] = acf_get_valid_post_id( $args['post_id'] );

			// new post?
			if ( $args['post_id'] === 'new_post' ) {
				$args['new_post'] = wp_parse_args(
					$args['new_post'],
					array(
						'post_type'   => 'post',
						'post_status' => 'draft',
					)
				);
			}

			// filter
			$args = apply_filters( 'acf/validate_form', $args );

			// return
			return $args;
		}


		/**
		 * description
		 *
		 * @type    function
		 * @date    28/2/17
		 * @since   5.5.8
		 *
		 * @param   $post_id (int)
		 * @return  $post_id (int)
		 */
		function add_form( $args = array() ) {

			// validate
			$args = $this->validate_form( $args );

			// append
			$this->forms[ $args['id'] ] = $args;
		}


		/**
		 * description
		 *
		 * @type    function
		 * @date    28/2/17
		 * @since   5.5.8
		 *
		 * @param   $post_id (int)
		 * @return  $post_id (int)
		 */
		function get_form( $id = '' ) {

			// bail early if not set
			if ( ! isset( $this->forms[ $id ] ) ) {
				return false;
			}

			// return
			return $this->forms[ $id ];
		}

		function get_forms() {
			return $this->forms;
		}

		/**
		 * This function will validate fields from the above array
		 *
		 * @type    function
		 * @date    7/09/2016
		 * @since   5.4.0
		 *
		 * @param   $post_id (int)
		 * @return  $post_id (int)
		 */
		function validate_save_post() {

			// register field if isset in $_POST
			foreach ( $this->fields as $k => $field ) {

				// bail early if no in $_POST
				if ( ! isset( $_POST['acf'][ $k ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Verified elsewhere.
					continue;
				}

				// register
				acf_add_local_field( $field );
			}

			// honeypot
			if ( ! empty( $_POST['acf']['_validate_email'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Data not used; presence indicates spam.

				acf_add_validation_error( '', __( 'Spam Detected', 'acf' ) );
			}
		}


		/**
		 * description
		 *
		 * @type    function
		 * @date    7/09/2016
		 * @since   5.4.0
		 *
		 * @param   $post_id (int)
		 * @return  $post_id (int)
		 */
		function pre_save_post( $post_id, $form ) {

			// vars
			$save = array(
				'ID' => 0,
			);

			// determine save data
			if ( is_numeric( $post_id ) ) {

				// update post
				$save['ID'] = $post_id;
			} elseif ( $post_id == 'new_post' ) {

				// merge in new post data
				$save = array_merge( $save, $form['new_post'] );
			} else {

				// not post
				return $post_id;
			}

			// phpcs:disable WordPress.Security.NonceVerification.Missing -- Verified in check_submit_form().
			// save post_title
			if ( isset( $_POST['acf']['_post_title'] ) ) {
				$save['post_title'] = acf_extract_var( $_POST['acf'], '_post_title' ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitized by WP when saved.
			}

			// save post_content
			if ( isset( $_POST['acf']['_post_content'] ) ) {
				$save['post_content'] = acf_extract_var( $_POST['acf'], '_post_content' ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitized by WP when saved.
			}
			// phpcs:enable WordPress.Security.NonceVerification.Missing

			// honeypot
			if ( ! empty( $_POST['acf']['_validate_email'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Data not used; presence indicates spam.
				return false;
			}

			// validate
			if ( count( $save ) == 1 ) {
				return $post_id;
			}

			// save
			if ( $save['ID'] ) {
				wp_update_post( $save );
			} else {
				$post_id = wp_insert_post( $save );
			}

			// return
			return $post_id;
		}


		/**
		 * This function will enqueue a form
		 *
		 * @type    function
		 * @date    7/09/2016
		 * @since   5.4.0
		 *
		 * @param   $post_id (int)
		 * @return  $post_id (int)
		 */
		function enqueue_form() {

			// check
			$this->check_submit_form();

			// load acf scripts
			acf_enqueue_scripts();
		}


		/**
		 * This function will maybe submit form data
		 *
		 * @type    function
		 * @date    3/3/17
		 * @since   5.5.10
		 *
		 * @param   n/a
		 * @return  n/a
		 */
		function check_submit_form() {

			// Verify nonce.
			if ( ! acf_verify_nonce( 'acf_form' ) ) {
				return false;
			}

			// Confirm form was submit.
			if ( ! isset( $_POST['_acf_form'] ) ) {
				return false;
			}

			// Load registered form using id.
			$form = $this->get_form( acf_sanitize_request_args( $_POST['_acf_form'] ) );

			// Fallback to encrypted JSON.
			if ( ! $form ) {
				$form = json_decode( acf_decrypt( sanitize_text_field( $_POST['_acf_form'] ) ), true );
				if ( ! $form ) {
					return false;
				}
			}

			// Run kses on all $_POST data.
			if ( $form['kses'] && isset( $_POST['acf'] ) ) {
				$_POST['acf'] = wp_kses_post_deep( $_POST['acf'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- False positive.
			}

			// Validate data and show errors.
			// Todo: Return WP_Error and show above form, keeping input values.
			acf_validate_save_post( true );

			// Submit form.
			$this->submit_form( $form );
		}


		/**
		 * This function will submit form data
		 *
		 * @type    function
		 * @date    3/3/17
		 * @since   5.5.10
		 *
		 * @param   n/a
		 * @return  n/a
		 */
		function submit_form( $form ) {

			// filter
			$form = apply_filters( 'acf/pre_submit_form', $form );

			// vars
			$post_id = acf_maybe_get( $form, 'post_id', 0 );

			// add global for backwards compatibility
			$GLOBALS['acf_form'] = $form;

			// allow for custom save
			$post_id = apply_filters( 'acf/pre_save_post', $post_id, $form );

			// save
			acf_save_post( $post_id );

			// restore form (potentially modified)
			$form = $GLOBALS['acf_form'];

			// action
			do_action( 'acf/submit_form', $form, $post_id );

			// vars
			$return = acf_maybe_get( $form, 'return', '' );

			// redirect
			if ( $return ) {

				// update %placeholders%
				$return = str_replace( '%post_id%', $post_id, $return );
				$return = str_replace( '%post_url%', get_permalink( $post_id ), $return );

				// redirect
				wp_redirect( $return ); //phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect -- unsafe redirects allowed.
				exit;
			}
		}


		/**
		 * description
		 *
		 * @type    function
		 * @date    7/09/2016
		 * @since   5.4.0
		 *
		 * @param   $post_id (int)
		 * @return  $post_id (int)
		 */
		function render_form( $args = array() ) {

			// Vars.
			$is_registered = false;
			$field_groups  = array();
			$fields        = array();

			// Allow form settings to be directly provided.
			if ( is_array( $args ) ) {
				$args = $this->validate_form( $args );

				// Otherwise, lookup registered form.
			} else {
				$is_registered = true;
				$args          = $this->get_form( $args );
				if ( ! $args ) {
					return false;
				}
			}

			// Extract vars.
			$post_id = $args['post_id'];

			// Prevent ACF from loading values for "new_post".
			if ( $post_id === 'new_post' ) {
				$post_id = false;
			}

			// Set uploader type.
			acf_update_setting( 'uploader', $args['uploader'] );

			// Register local fields.
			foreach ( $this->fields as $k => $field ) {
				acf_add_local_field( $field );
			}

			// Append post_title field.
			if ( $args['post_title'] ) {
				$_post_title          = acf_get_field( '_post_title' );
				$_post_title['value'] = $post_id ? get_post_field( 'post_title', $post_id ) : '';
				$fields[]             = $_post_title;
			}

			// Append post_content field.
			if ( $args['post_content'] ) {
				$_post_content          = acf_get_field( '_post_content' );
				$_post_content['value'] = $post_id ? get_post_field( 'post_content', $post_id ) : '';
				$fields[]               = $_post_content;
			}

			// Load specific fields.
			if ( $args['fields'] ) {

				// Lookup fields using $strict = false for better compatibility with field names.
				foreach ( $args['fields'] as $selector ) {
					$fields[] = acf_maybe_get_field( $selector, $post_id, false );
				}

				// Load specific field groups.
			} elseif ( $args['field_groups'] ) {
				foreach ( $args['field_groups'] as $selector ) {
					$field_groups[] = acf_get_field_group( $selector );
				}

				// Load fields for the given "new_post" args.
			} elseif ( $args['post_id'] == 'new_post' ) {
				$field_groups = acf_get_field_groups( $args['new_post'] );

				// Load fields for the given "post_id" arg.
			} else {
				$field_groups = acf_get_field_groups(
					array(
						'post_id' => $args['post_id'],
					)
				);
			}

			// load fields from the found field groups.
			if ( $field_groups ) {
				foreach ( $field_groups as $field_group ) {
					$_fields = acf_get_fields( $field_group );
					if ( $_fields ) {
						foreach ( $_fields as $_field ) {
							$fields[] = $_field;
						}
					}
				}
			}

			// Add honeypot field.
			if ( $args['honeypot'] ) {
				$fields[] = acf_get_field( '_validate_email' );
			}

			// Display updated_message
			if ( ! empty( $_GET['updated'] ) && $args['updated_message'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Used as a flag; data not used.
				printf( $args['html_updated_message'], $args['updated_message'] ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- designed to contain potentially unsafe HTML, set by developers.
			}

			// display form
			if ( $args['form'] ) : ?>
		<form <?php echo acf_esc_attrs( $args['form_attributes'] ); ?>>
				<?php
		endif;

			// Render hidde form data.
			acf_form_data(
				array(
					'screen'  => 'acf_form',
					'post_id' => $args['post_id'],
					'form'    => $is_registered ? $args['id'] : acf_encrypt( json_encode( $args ) ),
				)
			);

			?>
			<div class="acf-fields acf-form-fields -<?php echo esc_attr( $args['label_placement'] ); ?>">
				<?php echo $args['html_before_fields']; ?><?php //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- designed to contain potentially unsafe HTML, set by developers. ?>
				<?php acf_render_fields( $fields, $post_id, $args['field_el'], $args['instruction_placement'] ); ?>
				<?php echo $args['html_after_fields']; ?><?php //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- designed to contain potentially unsafe HTML, set by developers. ?>
			</div>
			<?php if ( $args['form'] ) : ?>
			<div class="acf-form-submit">
				<?php printf( $args['html_submit_button'], $args['submit_value'] ); ?><?php //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- designed to contain potentially unsafe HTML, set by developers. ?>
				<?php echo $args['html_submit_spinner']; ?><?php //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- designed to contain potentially unsafe HTML, set by developers. ?>
			</div>
		</form>
		<?php endif;
		}
	}

	// initialize
	acf()->form_front = new acf_form_front();
endif; // class_exists check


/**
 * Functions
 *
 * alias of acf()->form->functions
 *
 * @type    function
 * @date    11/06/2014
 * @since   5.0.0
 *
 * @param   n/a
 * @return  n/a
 */
function acf_form_head() {

	acf()->form_front->enqueue_form();
}

function acf_form( $args = array() ) {

	acf()->form_front->render_form( $args );
}

function acf_get_form( $id = '' ) {

	return acf()->form_front->get_form( $id );
}

function acf_get_forms() {
	return acf()->form_front->get_forms();
}

function acf_register_form( $args ) {

	acf()->form_front->add_form( $args );
}

?>
