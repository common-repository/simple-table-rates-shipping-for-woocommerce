<h3><?php _e('Simple Table Rates Settings', 'simple-table-rates');?></h3>
<?php if ($this->debug_mode == 'yes'): ?>
    <div class="updated woocommerce-message">
        <p><?php _e('Simple Table Rates debug mode is activated, only administrators can use it.', 'simple-table-rates');?></p>
    </div>
<?php endif;?>
<div id="poststuff" class="str_settings">
    <div id="post-body" class="metabox-holder columns-2">
        <div id="post-body-content">
            <table class="form-table">
				<?php echo $this->get_admin_options_html(); ?>
            </table><!--/.form-table-->
        </div>
        <div id="postbox-container-1" class="postbox-container wpruby-widgets">
            <div id="side-sortables" class="meta-box-sortables ui-sortable">
                <div class="postbox ">
                    <h2 class="hndle"><span><i class="dashicons dashicons-update"></i>&nbsp;&nbsp;Upgrade to Pro</span></h2>
                    <hr>
                    <div class="inside">
                        <div class="support-widget">
                            <ul>
                                <li>» Break on first match, Cheapest, and Most Expensive calculation methods</li>
                                <li>» Import/Export Rules</li>
                            </ul>

                            <strong>Extra Rules</strong>
                            <ul>
                                <li>» Total Dimensions</li>
                                <li>» Product Category, Tag</li>
                                <li>» Shipping Class</li>
                                <li>» Coupon</li>
                                <li>» User Role</li>
                                <li>» Time</li>
                                <li>» Day</li>
                            </ul>
                            <strong>Actions</strong>
                            <ul>
                                <li>» Cancel, Stop Calculations</li>
                                <li>» Show Custom Message</li>
                                <li>» Rename Shipping Title</li>
                                <li>» Add Shipping Subtitle</li>
                                <li>» Hide Other Shipping Methods</li>
                            </ul>
                            <a href="https://wpruby.com/plugin/woocommerce-simple-table-rates-pro/?utm_source=str-lite&utm_medium=widget&utm_campaign=freetopro" class="button wpruby_button" target="_blank"><span class="dashicons dashicons-star-filled"></span> Upgrade Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
<style type="text/css">
    #postbox-container-1 .note{
        background: #ffba00;
        color:#ffffe0;
    }
    .wpruby-widgets .hndle {
        padding: 10px 0 5px 10px !important;
    }
    .support-widget p{
        text-align: center;
    }
    .str_settings .form-table th {
        width:150px;
    }
    .wpruby_button{
        background-color:#4CAF50 !important;
        border-color:#4CAF50 !important;
        color:#ffffff !important;
        width:100%;
        padding:5px !important;
        text-align:center;
        height:35px !important;
        font-size:12pt !important;
        line-height: 22px !important;
    }
</style>
