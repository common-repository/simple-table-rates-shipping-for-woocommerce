=== Simple Table Rates Shipping For WooCommerce ===
Contributors: waseem_senjer, wprubyplugins
Donate link: https://wpruby.com
Tags: woocommerce, shipping, table rates
Requires at least: 4.0
Tested up to: 6.5
Stable tag: 1.0.7
Requires PHP: 7.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Offer flexible shipping to your customers based on many rules.

== Description ==

WooCommerce Simple Table Rates Pro is a WooCommerce extension which allows you to set shipping prices based on many rules such as weight, price, dimensions, user roles and much more.

[Upgrade to Pro](https://wpruby.com/plugin/woocommerce-simple-table-rates-pro/?utm_source=str-lite&utm_medium=readme&utm_campaign=freetopro) | [Documentation](https://wpruby.com/knowledgebase_category/woocommerce-simple-table-rates-pro/)

[youtube https://www.youtube.com/watch?v=FRdOS-qIT0Q]

### Features
#### Handling Fees
If you need to add a handling fee for your shipping order, we set an option for that where you can add an amount of value to increase the shipping cost. The value can be either a number or a percentage.

#### Condition Types
* **Weight** Set shipping cost based on the total weight of the cart’s items.
* **Cart Total** Add shipping costs based on the total cart amount.
* **Products** You can set the shipping cost for one or many products.
* **Quantity** Shipping is based on the total quantities of the items in the cart.
* **Volume** Shipping is based on the total volume of all items in the cart.

#### Hide Other Methods
You can hide other shipping methods if one of the table rates is available.

#### Duplicate Rules
For easier data entry, you can duplicate any rule.


== Installation ==

1. Upload `simple-table-rates-shipping-for-woocommerce` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to WooCommerce -> Settings -> Shipping.
4. Add `Simple Table Rates` to the shipping zones.

== Frequently Asked Questions ==
= Where can I find the plugin's settings page? =

After activating the plugin, please go to **WooCommerce** => **Settings** => **Shipping**. Assign **Simple Table Rates** to one of your shipping zones, and then click again on **Simple Table Rates**. You will be redirected to the settings page.

= Which rules are available for table rate shipping? =

At the moment, the following rules are available:
* Weight
* Cart Total
* Volume
* Products
* Quantity


== Screenshots ==
1. Settings
2. Rules
3. Cart page

== Changelog ==

= 1.0.7 =
* Added: HPOS Support.
* Added: WordPress 6.4 compatibility.
* Added: WooCommerce 6.4 compatibility.

= 1.0.6 =
* Added: WordPress 6.3 compatibility.

= 1.0.5 =
Fixed: Handling fees were only applied as integer value.

= 1.0.4 =
Fixed: only integer numbers were allowed in the price field.

= 1.0.3 =
* Fixed: add support for products with variations.

= 1.0.2 =
* Fixed: correctly save the product rule.

= 1.0.1 =
* Add check if WooCommerce is active.

= 1.0.0 =
* Initial Release

== Upgrade Notice ==

= 1.0.0 =
* Initial Release
