<?php

namespace App\Admin;

/**
 * Class LoadAdminFunctionality
 */
class LoadAdminFunctionality
{
    /**
     * @var
     */
    private $themeName;

    /**
     * @var
     */
    private $version;

    /**
     * @var
     */
    private $cssSettings;

    /**
     * Admin constructor.
     * @param $themeName
     * @param $version
     */
    public function __construct($themeName, $version)
    {
        $this->themeName = $themeName;
        $this->version = $version;
    }

    /**
     * @param $hook
     */
    public function enqueueStyles($hook)
    {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_style('admin-css', ASSETS . '/dist/admin.css', false, $this->version);
        if (!in_array($hook, ['post.php', 'post-new.php', 'settings_page_transformations-options'])) {
            return;
        }

        $customPostTypes = [
            'light_box, staff_modal',
            'tabbed_content',
            'slider',
            'settings_page_transformations-options'
        ];
        $screen = get_current_screen();

        if (!is_object($screen)) {
            return;
        }

        if (!in_array($screen->post_type, $customPostTypes) && !in_array($screen->base, $customPostTypes)) {
            return;
        }

        wp_enqueue_style('admin-vue', ASSETS . '/dist/adminVue.css', false, $this->version);
    }

    /**
     * @param $hook
     */
    public function enqueueScripts($hook)
    {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_media();
        wp_enqueue_script('admin', ASSETS . '/dist/admin.js', ['jquery', 'wp-color-picker'], $this->version, true);
        if (!in_array($hook, [
            'post.php',
            'post-new.php',
            'settings_page_transformations-options',
            'toplevel_page_transformations-treatment-theme-options'
        ])) {
            return;
        }

        $customPostTypes = [
            'light_box',
            'staff_modal',
            'tabbed_content',
            'slider',
            'settings_page_transformations-options',
            'transformations-treatment-theme-options',
            'toplevel_page_transformations-treatment-theme-options'
        ];

        $screen = get_current_screen();
        if (!is_object($screen)) {
            return;
        }

        if (!in_array($screen->post_type, $customPostTypes) && !in_array($screen->base, $customPostTypes)) {
            return;
        }


        wp_enqueue_script('admin-vue', ASSETS . '/dist/adminVue.js', [], $this->version, true);

        wp_localize_script('admin-vue', 'ajaxObject', [
            'url' => admin_url('admin-ajax.php')
        ]);
    }

    /**
     * @param $input
     * @return array
     */
    public function sanitize($input)
    {
        $newInput = [];
        $newThemeVariables = [];


        if (isset($input['pi_menu_picker'])) {
            $newInput['pi_menu_picker'] = sanitize_text_field($input['pi_menu_picker']);
        }

        if (isset($input['css_value'])) {
            $newInput['css_value'] = $input['css_value'];
        }

        if (count($newThemeVariables)) {
            $content = '';
            foreach ($newThemeVariables as $key => $scssVariable) {
                if (empty($scssVariable)) {
                    continue;
                }

                $content .= "$$key: $scssVariable;" . PHP_EOL;
            }
            file_put_contents(get_template_directory() . '/assets/scss/_theme-variables.scss', $content);
        }


        return $newInput;
    }


    /**
     * CSS Code area render
     * @param $value
     */
    public function cssTextArea($value)
    {
        printf(
            '<textarea type="text" id="' . $value . '" name="' . $this->cssSettingsKey . '[' . $value . ']" class="pi-textarea">%s</textarea>',
            isset($this->cssSettings[$value]) ? esc_attr($this->cssSettings[$value]) : ''
        );
    }

    /**
     *
     */
    public function showExtraRegisterFields()
    {
        ?>
        <p>
            <label for="password">Password<br/>
                <input id="password" class="input" type="password" tabindex="30" size="25" value="" name="password"/>
            </label>
        </p>
        <p>
            <label for="repeat_password">Repeat password<br/>
                <input id="repeat_password" class="input" type="password" tabindex="40" size="25" value=""
                       name="repeat_password"/>
            </label>
        </p>
        <?php
    }

    /**
     * @param $login
     * @param $email
     * @param $errors
     */
    public function checkExtraRegisterFields($login, $email, $errors)
    {
        if ($_POST['password'] !== $_POST['repeat_password']) {
            $errors->add('passwords_not_matched', "<strong>ERROR</strong>: Passwords must match");
        }
        if (strlen($_POST['password']) < 6) {
            $errors->add('password_too_short',
                "<strong>ERROR</strong>: Passwords must be at least six characters long");
        }
    }

    /**
     * @param $user_id
     */
    public function registerExtraFields($user_id)
    {
        $userData = [];

        $userData['ID'] = $user_id;
        if ($_POST['password'] !== '') {
            $userData['user_pass'] = $_POST['password'];
        }
        wp_update_user($userData);
    }

    /**
     * @param $text
     * @return string
     */
    public function editPasswordEmailText($text)
    {
        if ($text == 'Registration confirmation will be e-mailed to you.') {
            $text = 'If you leave password fields empty one will be generated for you. Password must be at least 6 characters long.';
        }
        return $text;
    }
    
    public function resourceCategoryField($tag)
    {
        $tagId = $tag->term_id;
        $termMeta = get_option("taxonomy_term_$tagId");
        $fileId = $termMeta['featured_image'] ?? null;
        $url = '';

        if ($fileId) {
            $attachment = wp_get_attachment_image_src($fileId, 'full');
            $url = esc_url($attachment[0]);
        }

        $templateData = [];
        $templateData['imageSrc'] = $url;
        $templateData['name'] = 'featured_image';
        $templateData['value'] = $fileId;

        ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="presenter_id"><?php _e('Featured Image'); ?></label>
            </th>
            <td>
                <?= getTemplate('partials/upload-field.php', $templateData); ?>
                <span class="description"><?php _e('Upload a featured image'); ?></span>
            </td>
        </tr>
        <?php
    }

    public function saveResourceCategoryTaxonomy($termId)
    {
        $key = 'featured_image';
        if (!isset($_POST[$key])) {
            return;
        }

        $termMeta = get_option("taxonomy_term_$termId");
        $termMeta[$key] = $_POST[$key];

        update_option("taxonomy_term_$termId", $termMeta);
    }
}