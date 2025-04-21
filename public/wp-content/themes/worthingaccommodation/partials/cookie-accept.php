<dialog id="cookie-accept" class="cookie-accept">
    <div class="cookie-accept__container cookie-accept__preface">
        <div class="cookie-accept__content">
            <h3><?php _e('We respect your privacy', 'pragmatic'); ?></h3>

            <p><?php _e('Some of these cookies are essential, while others help us to improve your experience by providing insights into how the site is being used. For more information visit our <a href="/privacy-policy/">privacy and cookie policy</a>.', 'pragmatic'); ?></p>
        </div>
        <div class="cookie-accept__controls">
            <button class="cookie-accept__button cookie-accept__manage-button"><?php _e('Manage cookies', 'pragmatic'); ?></button>
            <button class="cookie-accept__button cookie-accept__accept-cookies-button"><?php _e('Accept cookies', 'pragmatic'); ?></button>
        </div>
    </div>
    <div class="cookie-accept__container cookie-accept__manage">
        <div class="cookie-accept__content">
            <h3><?php _e('Manage cookie settings', 'pragmatic'); ?></h3>

            <h5><?php _e('Necessary cookies:', 'pragmatic'); ?></h5>
            <p><?php _e('Necessary cookies enable core functionality. The website cannot function properly without these cookies, and can only be disabled by changing your browser preferences.', 'pragmatic'); ?></p>

            <h5><?php _e('Optional cookies:', 'pragmatic'); ?></h5>
            <p><?php _e('We\'d also like to use cookies to provide optional features, improve our website and support our marketing.', 'pragmatic'); ?></p>

            <div class="cookie-accept__checkbox-group">
                <input id="cookie-accept-enable-analytics" type="checkbox" name="cookie-accept-enable-analytics">
                <label for="cookie-accept-enable-analytics"><?php _e('<span>Analytics Cookies:</span> Analytical cookies help us to improve our website by collecting and reporting information on its usage.', 'pragmatic'); ?></label>
            </div>

            <div class="cookie-accept__checkbox-group">
                <input id="cookie-accept-enable-marketing" type="checkbox" name="cookie-accept-enable-marketing">
                <label for="cookie-accept-enable-marketing"><?php _e('<span>Marketing Cookies:</span> We use marketing cookies to help us improve the relevancy of advertising campaigns you receive.', 'pragmatic'); ?></label>
            </div>
        </div>
        <div class="cookie-accept__controls">
            <button class="cookie-accept__button cookie-accept__accept-cookies-button"><?php _e('Accept all cookies', 'pragmatic'); ?></button>
            <button class="cookie-accept__button cookie-accept__confirm-selection-button"><?php _e('Confirm current selection', 'pragmatic'); ?></button>
        </div>
    </div>
</dialog>