<?php

namespace WPRuby_Str\Core;


class Simple_Table_Rates_Shipping_Method extends \WC_Shipping_Method {

	private $handling_fees = [
		'type'  => 'amount',
		'value' => 0
	];

	private $debug_messages = [];

	public function __construct( $instance_id = 0 ) {
		$this->instance_id        = absint( $instance_id );
		$this->id                 = 'simple_table_rates';
		$this->method_title       = __( 'Simple Table Rates', 'simple-table-rates' );
		$this->method_description = __( 'Offer flexible shipping to your customers based on cart rules.', 'simple-table-rates' );
		$this->title              = __( 'Simple Table Rates', 'simple-table-rates' );

		$this->supports = [
			'shipping-zones',
			'instance-settings',
		];

		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		$this->enabled            = $this->get_option( 'enabled' );
		$this->handling_fees      = $this->get_option( 'handling_fees' );
		$this->rules              = $this->get_option( 'rules' );
		$this->hide_other_methods = $this->get_option( 'hide_other_methods' );
		$this->debug_mode         = $this->get_option( 'debug_mode' );
		$this->tax_status         = $this->get_option( 'tax_status' );

		// Define user set variables
		add_action( 'woocommerce_update_options_shipping_' . $this->id, [ $this, 'process_admin_options' ] );
		add_filter( 'woocommerce_package_rates', [ $this, 'hide_shipping_when_table_rate_is_available' ], 10, 2 );

	}

	public function init_form_fields() {
		$this->instance_form_fields = [
			'title'              => [
				'title'       => __( 'Method Title', 'simple-table-rates' ),
				'type'        => 'text',
				'description' => __( 'Title of the shipping method at the cart and checkout pages.', 'simple-table-rates' ),
				'default'     => __( 'Shipping', 'simple-table-rates' ),
				'desc_tip'    => false,
			],
			'handling_fees'      => [
				'type'    => 'handling_fees',
				'default' => $this->handling_fees,
			],
			'tax_status'         => [
				'title'   => __( 'Tax status', 'woocommerce' ),
				'type'    => 'select',
				'class'   => 'wc-enhanced-select',
				'default' => 'taxable',
				'options' => [
					'taxable' => __( 'Taxable', 'woocommerce' ),
					'none'    => _x( 'None', 'Tax status', 'woocommerce' ),
				],
			],
			'debug_mode'         => [
				'title'       => __( 'Enable Debug Mode', 'simple-table-rates' ),
				'type'        => 'checkbox',
				'label'       => __( 'Enable ', 'simple-table-rates' ),
				'description' => __( 'If debug mode is enabled, the shipping method will be activated just for the administrator. The debug mode will display all the debugging data on the cart and the checkout pages.', 'simple-table-rates' ),
				'desc_tip'    => false,
			],
			'calculation_method' => [
				'type'    => 'calculation_method',
				'default' => [],
			],
			'hide_other_methods' => [
				'title'       => __( 'Hide other shipping methods', 'simple-table-rates' ),
				'type'        => 'checkbox',
				'label'       => __( 'Enable ', 'simple-table-rates' ),
				'default'     => 'no',
				'description' => __( 'If enabled, the plugin will hide other shipping methods if a table rate is available.', 'simple-table-rates' ),
				'desc_tip'    => false,
			],
			'rules'              => [
				'type'    => 'rules',
				'default' => [],
			],
		];
	}

	public function calculate_shipping( $package = [] ) {
		$settings = new Settings( $this->instance_id, $this->instance_settings );

		$this->debug( 'Settings', $this->instance_settings );

		$calculator = new Calculator( $settings );
		$rate       = $calculator->calculate( $package );

		if ( $rate->getCost() === - 1.0 ) {
			$this->debug( "No Rule Matched" );

			return;
		}

		$this->debug( 'Final Rate', $rate->getWoocommerceRate() );
		$this->output_debug();

		$this->add_rate( $rate->getWooCommerceRate() );

	}

	/**
	 * Output a message
	 *
	 * @param string $title
	 * @param mixed $data
	 * @param string $type
	 */
	protected function debug( $title, $data = null ) {
		if ( $this->debug_mode !== 'yes' ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( ! $data ) {
			$message = $title;
		} else {
			$message = sprintf( '%s: <pre>%s</pre>', $title, json_encode( $data ) );
		}
		$this->debug_messages[ $title ] = $message;

	}

	protected function output_debug() {

		if ( count( $this->debug_messages ) === 0 ) {
			return;
		}

		$message = implode( '', $this->debug_messages );

		$message = 'Debug Info for Simple Table Rates <br><br>' . $message;

		wc_add_notice( $message, 'notice' );
	}

	public function generate_calculation_method_html() {
		ob_start();
		?>
        <tr style="vertical-align: top;">
            <th class="titledesc">
                <label><?php _e( 'Calculation Method', 'simple-table-rates' ) ?></label>
            </th>
            <td class="forminp">
                <fieldset>
                    <legend class="screen-reader-text"><span>Calculation Method</span></legend>
                    <select class="select wc-enhanced-select" name="woocommerce_simple_table_rates_calculation_method" id="woocommerce_simple_table_rates_calculation_method" style="">
                        <option value="sum" selected="selected">Sum</option>
                        <option value="break" disabled>[Pro] Break on first match</option>
                        <option value="cheapest" disabled>[Pro] Cheapest</option>
                        <option value="highest" disabled>[Pro] Most Expensive</option>
                    </select>
                    <p class="description">
                    <ul>
                        <li><strong>Sum</strong>: the plugin will add the price of shipping for all of the matching rules.</li>
                        <li><strong>Break on first match</strong>: The plugin will stop the calculations on the first matching rule.</li>
                        <li><strong>Cheapest</strong>: The plugin will choose the lowest price from the matched rules.</li>
                        <li><strong>Most Expensive</strong>: The plugin will choose the highest price from the matched rules.</li>
                    </ul>
                    </p>
                </fieldset>
            </td>
        </tr>
		<?php
		return ob_get_clean();
	}

	public function generate_rules_html() {
        $rules = [];
        foreach ($this->instance_settings['rules'] as $rule) {
            if ($rule['type'] !== 'product') {
                $rules[] = $rule;
                continue;
            }

            foreach ($rule['value'] as $key => $value) {
                $value = json_decode( stripslashes($value));
                $rule['value'][$key] = $value;
            }
            $rules[] = $rule;
        }
		wp_localize_script( 'wpruby-str-app', 'str_rules', $rules );
		ob_start();
		require_once( dirname( __FILE__ ) . '/app/frontend/views/app.php' );

		return ob_get_clean();
	}

	/**
	 * validate_rules_field function.
	 *
	 * @access public
	 * @return array
	 * @internal param mixed $key
	 */
	public function validate_rules_field() {
		$posted_rules = [];
		if ( isset( $_POST['str_rule'] ) ) {
			$posted_rules = $this->sanitize_array( $_POST['str_rule'] );
		}

		$rules = [];
		foreach ( $posted_rules as $key => $rule ) {
			if ( $rule['type'] === 'product' ) {
				$posted_rules[ $key ]['value'] = array_map( function ( $val ) {
					return json_decode( stripslashes( $val ), true );
				}, $rule['value'] );
			}


			if ( ! isset( $rule['value'] ) ) {
				continue;
			}

			if ( empty( $rule['value'] ) ) {
				continue;
			}

			if ( empty( $rule['price'] ) ) {
				$rule['price'] = 0;
			}

			$rules[ $key ] = $rule;
		}

		return $rules;
	}

	private function sanitize_array( array $data ): array {
		return array_map( function ( $value ) {
			if ( is_array( $value ) ) {
				return $this->sanitize_array( $value );
			}

			return sanitize_text_field( $value );

		}, $data );
	}

	/**
	 * @return string
	 */
	public function generate_handling_fees_html() {
		$value = ( isset( $this->instance_settings['handling_fees']['value'] ) ) ? $this->instance_settings['handling_fees']['value'] : 0;
		$type  = ( isset( $this->instance_settings['handling_fees']['type'] ) ) ? $this->instance_settings['handling_fees']['type'] : 'amount';
		ob_start(); ?>
        <tr style="vertical-align: top;">
            <th class="titledesc">
                <label><?php _e( 'Handling Fees', 'simple-table-rates' ) ?></label>
            </th>
            <td class="forminp">
                <fieldset id="str_handling_fees">
                    <input type="text" id="str_handling_fees_value" name="str_handling_fees_value" value="<?php echo esc_attr( $value ); ?>" style="width:70px"/>

                    <select id="str_handling_fees_type" name="str_handling_fees_type" style="width:50px; line-height: 28px;">
                        <option value="amount" <?php selected( $type, 'amount' ) ?>><?php echo get_woocommerce_currency_symbol(); ?></option>
                        <option value="percent" <?php selected( $type, 'percent' ) ?>>%</option>
                    </select>
                </fieldset>
            </td>
        </tr>
		<?php
		return ob_get_clean();
	}

	/**
	 * validate_handling_fees_field function.
	 *
	 * @access public
	 * @return array
	 * @internal param mixed $key
	 */
	public function validate_handling_fees_field() {
		$handling_fees = [];
		if ( isset( $_POST['str_handling_fees_value'] ) ) {
			$handling_fees['value'] = round( floatval( $_POST['str_handling_fees_value'] ), 2 );
		}
		if ( isset( $_POST['str_handling_fees_type'] ) ) {
			$handling_fees['type'] = sanitize_text_field( $_POST['str_handling_fees_type'] );
		}

		return $handling_fees;
	}

	/**
	 * Hide shipping rates when free shipping is available
	 *
	 * @param array $rates Array of rates found for the package
	 * @param array $package The package array/object being shipped
	 *
	 * @return array of modified rates
	 */
	public function hide_shipping_when_table_rate_is_available( $rates, $package ) {
		if ( $this->hide_other_methods !== 'yes' ) {
			return $rates;
		}

		if ( ! $this->is_available( $package ) ) {
			return $rates;
		}

		$new_rates = Helper::filter_table_rates( $rates );

		if ( count( $new_rates ) > 0 ) {
			return $new_rates;
		}

		return $rates;
	}

	public function is_available( $package ) {
		if ( $this->debug_mode === 'yes' && ! current_user_can( 'manage_options' ) ) {
			return false;
		}

		return true;
	}

	public function admin_options() {
		require_once( dirname( __FILE__ ) . '/views/admin-options.php' );
	}
}
