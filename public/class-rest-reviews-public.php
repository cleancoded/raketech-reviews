<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       james.biz
 * @since      1.0.0
 *
 * @package    Rest_Reviews
 * @subpackage Rest_Reviews/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Rest_Reviews
 * @subpackage Rest_Reviews/public
 * @author     James Bregenzer <james@james.biz>
 */
class Rest_Reviews_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_shortcode('james_reviews', array($this, 'display_reviews'));

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rest_Reviews_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rest_Reviews_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rest-reviews-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rest_Reviews_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rest_Reviews_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rest-reviews-public.js', array( 'jquery' ), $this->version, false );

	}

	public function display_reviews($atts)
	{
		
		$a = shortcode_atts(array(
			'id' => 'rest_reviews',
			'count' => 0, // for unlimited
			'url' => ''
		), $atts);
		# code...

		$api_url = $a['url'];

		$reviews_html = '<section class="rest_reviews" id="'.$a['id'].'">';

		//curl to get json data

		$ch = curl_init();

		curl_setopt_array($ch, array(
		  CURLOPT_URL => 'https://bestwebsite.com/data-1.json',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		));

		$response = curl_exec($ch);

		if ($response) {
			$reviews = json_decode($response);
			$reviews = (array)( (array)$reviews )['toplists'];
			if ($reviews && count((array)$reviews) > 0) {
				$reviews_list = (array)$reviews;
				foreach ($reviews_list as $key => $value) {
					$__reviews = (array)$reviews_list[$key];
					foreach ($__reviews as $review) {
						$review = (array)$review;
						$review_info = (array)($review['info']);
						echo 'Bonus:' . ' => ' . $review_info['bonus'];
					}
				}
			}
		}

		$reviews_html .= '</section>';


		return $reviews_html;

	}

}
