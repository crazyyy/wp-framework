<div class="wbcr-factory-feedback-117-modal wbcr-factory-feedback-117-modal-deactivation-feedback no-confirmation-message" id="wbcr-factory-feedback-117-deactivate-form" data-nonce="<?php echo wp_create_nonce( 'wbcr_factory_send_feedback' ) ?>">
    <div class="wbcr-factory-feedback-117-modal-dialog">
        <div class="wbcr-factory-feedback-117-modal-header">
            <h4><?php _e( 'Quick Feedback', 'wbcr_factory_feedback_117' ) ?></h4></div>
        <div class="wbcr-factory-feedback-117-modal-body">
            <div class="wbcr-factory-feedback-117-modal-panel active" data-panel-id="reasons">
                <h3>
                    <strong><?php _e( 'If you have a moment, please let us know why you are deactivating', 'wbcr_factory_feedback_117' ) ?>
                        :</strong></h3>
                <ul id="reasons-list">
                    <li class="reason has-input" data-input-type="textfield" data-input-placeholder="Название плагина">
                        <label>
                        <span>
                            <input type="radio" name="wbcr_factory_feedback_reason" value="2">
                        </span>
                            <span><?php _e( 'I found a better plugin', 'wbcr_factory_feedback_117' ) ?></span>
                        </label>
                        <div class="internal-message"></div>
                    </li>
                    <li class="reason" data-input-type="" data-input-placeholder="">
                        <label>
                        <span>
                            <input type="radio" name="wbcr_factory_feedback_reason" value="5">
                        </span>
                            <span><?php _e( 'The plugin suddenly stopped working', 'wbcr_factory_feedback_117' ) ?></span>
                        </label>
                        <div class="internal-message"></div>
                    </li>
                    <li class="reason" data-input-type="" data-input-placeholder="">
                        <label>
                        <span>
                            <input type="radio" name="wbcr_factory_feedback_reason" value="3">
                        </span>
                            <span><?php _e( 'I only needed the plugin for a short period', 'wbcr_factory_feedback_117' ) ?></span>
                        </label>
                        <div class="internal-message"></div>
                    </li>
                    <li class="reason" data-input-type="" data-input-placeholder="">
                        <label>
                        <span>
                            <input type="radio" name="wbcr_factory_feedback_reason" value="1">
                        </span>
                            <span><?php _e( 'I no longer need the plugin', 'wbcr_factory_feedback_117' ) ?></span>
                        </label>
                        <div class="internal-message"></div>
                    </li>
                    <li class="reason" data-input-type="" data-input-placeholder="">
                        <label>
                        <span>
                            <input type="radio" name="wbcr_factory_feedback_reason" value="4">
                        </span>
                            <span><?php _e( 'The plugin broke my site', 'wbcr_factory_feedback_117' ) ?></span>
                        </label>
                        <div class="internal-message"></div>
                    </li>
                    <li class="reason" data-input-type="" data-input-placeholder="">
                        <label>
                        <span>
                            <input type="radio" name="wbcr_factory_feedback_reason" value="15">
                        </span>
                            <span><?php _e( "It's a temporary deactivation. I'm just debugging an issue.", 'wbcr_factory_feedback_117' ) ?></span>
                        </label>
                        <div class="internal-message"></div>
                    </li>
                    <li class="reason has-input" data-input-type="textfield" data-input-placeholder="">
                        <label>
                        <span>
                            <input type="radio" name="wbcr_factory_feedback_reason" value="7">
                        </span>
                            <span><?php _e( 'Other', 'wbcr_factory_feedback_117' ) ?></span>
                        </label>
                        <div class="internal-message"></div>
                    </li>
                </ul>
                <p><?php _e( 'We will receive the following information from you: site address, php version, Wordpress version, version of our plugin, this will help us better understand the causes of the problem. If you don\'t want to send this data, click the "Anonymous" checkbox.', 'wbcr_factory_feedback_117' ) ?></p>
            </div>
        </div>
        <div class="wbcr-factory-feedback-117-modal-footer">
            <label for="wbcr-factory-feedback-117-anonymous-checkbox" class="wbcr-factory-feedback-117-anonymous-feedback-label" style="display: block;">
                <input type="checkbox" id="wbcr-factory-feedback-117-anonymous-checkbox"> <?php _e( 'Anonymous feedback', 'wbcr_factory_feedback_117' ) ?>
            </label>
            <a href="#" class="button button-secondary button-deactivate allow-deactivate"><?php _e( 'Skip & Deactivate', 'wbcr_factory_feedback_117' ) ?></a>
            <a href="#" class="button button-primary button-close"><?php _e( 'Cancel', 'wbcr_factory_feedback_117' ) ?></a>
        </div>
    </div>
</div>