<?php

namespace spbhlpr\Notices;

use spbhlpr\Notices\NoticeData;

use Exception;

if (!defined('WPINC')) {
    die;
}

class NoticeController
{
    private $db;
    private $spbhlpr_notices;
    private $disable = false;
    private static $theme_rec_identity = 'spbrecommendedtheme-notice';

    public function __construct()
    {
        add_action('admin_notices', array($this, 'superbhelper_notices'));
        add_action('wp_ajax_spbtic_dismiss_notice', array(__CLASS__, 'MaybeDismissNotice'));
    }

    public function superbhelper_notices()
    {
        $this->recommended_notices(true);
    }

    private function recommended_notices($recommended_theme_notice = false)
    {
        try {
            $start = filemtime(__FILE__);
            if (strtotime("+1 days", $start) > time()) {
                return false;
            }

            if ($recommended_theme_notice) {
                $display = $this->recommended_theme_notice();
                if ($display) {
                    return;
                }
            }

            $this->spbhlpr_notices = NoticeData::GetData();
        } catch (Exception $ex) {
            return false;
        }

        try {
            $current_notice_idx = 0;

            $default_link = 'https://superbthemes.com/redirect-to/?SPR=%s&SPK=%s';
            $current_notice = $this->spbhlpr_notices[$current_notice_idx];
            $current_identity = $current_notice['Identity'];
            if (isset($_COOKIE['spbhlpr-notice-never'])) {
                $never_cookie = json_decode(stripslashes($_COOKIE['spbhlpr-notice-never']));
                if (isset($never_cookie->$current_identity) && $never_cookie->$current_identity === true) {
                    return false;
                }
            }
            if (isset($_COOKIE['spbhlpr-notice-later'])) {
                $later_cookie = json_decode(stripslashes($_COOKIE['spbhlpr-notice-later']));
                if (isset($later_cookie->$current_identity) && is_numeric($later_cookie->$current_identity) && strtotime("+2 days", $later_cookie->$current_identity) > time()) {
                    return false;
                }
            }
            $slug = explode('-notice', $current_notice['Identity'])[0];
        } catch (Exception $ex) {
            return false;
        }
        $key = "helperfree";
        $current_notice['Link'] = sprintf($default_link, $slug, $key); ?>
        <div class="spbhlpr-notice-notice" id="spbhlpr-notice-notice">
            <style>
                <?php echo $current_notice['CSS']; ?>
            </style>
            <div class="spbhlpr-notice-message">
                <p>
                    <span><?php echo esc_html($current_notice['Title']); ?></span>
                    <?php echo esc_html($current_notice['Description']); ?>
                </p>
                <?php
                foreach ($current_notice['Buttons'] as &$button) { ?>
                    <a href="<?php echo esc_url($current_notice['Link']); ?>" target="_blank" rel="nofollow noopener"><?php echo esc_html($button['Title']); ?></a>
                <?php }
                unset($button); ?>
                <button type="button" id="spbhlpr_notice_later" data-element="<?php echo esc_attr($current_notice['Identity']); ?>" data-time="<?php echo esc_attr(time()); ?>">Ask me later</button>
                <button type="button" id="spbhlpr_notice_never" data-element="<?php echo esc_attr($current_notice['Identity']); ?>">Don't show me this again</button>
            </div>
        </div>
    <?php
    }

    private function recommended_theme_notice()
    {
        try {
            $current_identity = self::$theme_rec_identity;
            // Check if the notice has been dismissed.
            if (get_user_meta(get_current_user_id(), $current_identity, true)) {
                return false;
            }

            if (get_stylesheet() === 'idea-flow' || get_template() === 'idea-flow') {
                return false;
            }
        } catch (Exception $ex) {
            return false;
        }

    ?>
        <div class="notice notice-info is-dismissible <?= esc_attr($current_identity); ?>">
            <h2 class="notice-title">Idea Flow – The Ultimate WordPress Theme</h2>
            <span class="st-notification-wrapper">
                <span class="st-notification-column-wrapper">
                    <span class="st-notification-column">
                        <img src="<?= esc_url(SUPERBHELPER_PATH . '/assets/img/preview.png'); ?>" width="150" height="177" />
                    </span>

                    <span class="st-notification-column">
                        <h2>Why Idea Flow</h2>
                        <ul class="st-notification-column-list">
                            <li>Easy to Use & Customize</li>
                            <li>Search Engine Optimized</li>
                            <li>Lightweight and Fast</li>
                            <li>Top-notch Customer Support</li>
                        </ul>
                        <a href="https://superbthemes.com/idea-flow/" target="_blank" class="button">View Landing Page <span aria-hidden="true" class="dashicons dashicons-external"></span></a>

                    </span>
                    <span class="st-notification-column">
                        <h2>Get Started with Idea Flow</h2>
                        <ul>
                            <li><a href="https://superbthemes.com/demo/idea-flow/" class="button button-primary">View Demo</a></li>
                            <li><a href="<?= esc_url(admin_url('theme-install.php?search=%22idea%20flow%22')); ?>" class="button button-primary">Install For Free</a></li>
                            <li><a href="https://superbthemes.com/customer-support/" target="_blank" class="button">Contact Support <span aria-hidden="true" class="dashicons dashicons-external"></span></a> </li>
                        </ul>
                    </span>
                </span>
                <span class="st-notification-footer">
                    Idea Flow is created by SuperbThemes. We have 100.000+ users and are rated <strong>Excellent</strong> on Trustpilot <img src="<?= esc_url(SUPERBHELPER_PATH . '/assets/img/stars.svg'); ?>" width="87" height="16" />
                </span>
            </span>

            <style>
                .st-notification-column-wrapper {
                    width: 100%;
                    display: -webkit-box;
                    display: -ms-flexbox;
                    display: flex;
                    border-top: 1px solid #eee;
                    padding-top: 20px;
                    margin-top: 3px
                }

                .st-notification-column-wrapper h2 {
                    margin: 0
                }

                .st-notification-footer img {
                    margin-bottom: -3px;
                    margin-left: 10px
                }

                .st-notification-column-wrapper .button {
                    min-width: 180px;
                    text-align: center;
                    margin-top: 10px
                }

                .st-notification-column {
                    margin-right: 10px;
                    padding: 0 10px;
                    max-width: 250px;
                    width: 100%
                }

                .st-notification-column img {
                    border: 1px solid #eee
                }

                .st-notification-footer {
                    display: inline-block;
                    width: 100%;
                    padding: 15px 0;
                    border-top: 1px solid #eee;
                    margin-top: 10px
                }

                .st-notification-column:first-of-type {
                    padding-left: 0;
                    max-width: 160px
                }

                .st-notification-column-list li {
                    list-style-type: circle;
                    margin-left: 15px;
                    font-size: 14px
                }

                @media only screen and (max-width:1000px) {
                    .st-notification-column {
                        max-width: 33%
                    }
                }

                @media only screen and (max-width:800px) {
                    .st-notification-column {
                        max-width: 50%
                    }

                    .st-notification-column:first-of-type {
                        display: none
                    }
                }

                @media only screen and (max-width:600px) {
                    .st-notification-column-wrapper {
                        display: block
                    }

                    .st-notification-column {
                        width: 100%;
                        max-width: 100%;
                        display: inline-block;
                        padding: 0;
                        margin: 0
                    }

                    span.st-notification-column:last-of-type {
                        margin-top: 30px
                    }
                }
            </style>
            <script>
                window.addEventListener("load", function() {
                    setTimeout(function() {
                        var notice_id = "<?= esc_attr($current_identity); ?>";
                        var nonce = "<?php echo esc_attr(wp_create_nonce('spbtic_dismiss_notice')); ?>";
                        var ajaxurl = "<?php echo esc_url(admin_url('admin-ajax.php')); ?>";
                        var dismissBtn = document.querySelector(
                            "." + notice_id + " .notice-dismiss"
                        );

                        if (!dismissBtn) return;

                        // Add an event listener to the dismiss button.
                        dismissBtn.addEventListener("click", function(event) {
                            var httpRequest = new XMLHttpRequest(),
                                postData = "";

                            // Build the data to send in our request.
                            // Data has to be formatted as a string here.
                            postData += "id=" + notice_id;
                            postData += "&action=spbtic_dismiss_notice";
                            postData += "&nonce=" + nonce;

                            httpRequest.open("POST", ajaxurl);
                            httpRequest.setRequestHeader(
                                "Content-Type",
                                "application/x-www-form-urlencoded"
                            );
                            httpRequest.send(postData);
                        });
                    }, 0);
                });
            </script>
        </div>
<?php
        return true;
    }

    public static function MaybeDismissNotice()
    {
        // Sanity check: Early exit if we're not on a spbtic_dismiss_notice action.
        if (!isset($_POST['action']) || 'spbtic_dismiss_notice' !== $_POST['action']) {
            return;
        }

        // Sanity check: Early exit if the ID of the notice does not exist.
        if (!isset($_POST['id']) || $_POST['id'] !== self::$theme_rec_identity) {
            return;
        }

        // Security check: Make sure nonce is OK. check_ajax_referer exits if it fails.
        check_ajax_referer('spbtic_dismiss_notice', 'nonce', true);

        update_user_meta(get_current_user_id(), self::$theme_rec_identity, true);
        exit();
    }

    public static function CleanUp()
    {
        delete_user_meta(get_current_user_id(), self::$theme_rec_identity);
    }
}
