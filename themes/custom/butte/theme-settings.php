<?php

use Drupal\Component\Utility\Html;
use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\ThemeSettingsForm;
use Drupal\file\Entity\File;
use Drupal\Core\Url;

function butte_form_system_theme_settings_alter(&$form, \Drupal\Core\Form\FormStateInterface $form_state) {
    $form['settings'] = array(
        '#type' => 'details',
        '#title' => t('Theme settings'),
        '#open' => TRUE,
    );


    $form['settings']['general_setting'] = array(
        '#type' => 'details',
        '#title' => t('General Settings'),
        '#open' => FALSE,
    );

    $form['settings']['general_setting']['general_setting_tracking_code'] = array(
        '#type' => 'textarea',
        '#title' => t('Tracking Code'),
        '#default_value' => theme_get_setting('general_setting_tracking_code', 'butte'),
    );


    // custom css
    $form['settings']['custom_css'] = array(
        '#type' => 'details',
        '#title' => t('Custom CSS'),
        '#open' => FALSE,
    );


    $form['settings']['custom_css']['custom_css'] = array(
        '#type' => 'textarea',
        '#title' => t('Custom CSS'),
        '#default_value' => theme_get_setting('custom_css', 'butte'),
        '#description' => t('<strong>Example:</strong><br/>h1 { font-family: \'Metrophobic\', Arial, serif; font-weight: 400; }')
    );
    // Blog settings
    $form['settings']['layout_style'] = array(
        '#type' => 'details',
        '#title' => t('Layout style'),
        '#open' => FALSE,
    );

    $form['settings']['layout_style']['layout_style'] = array(
        '#type' => 'select',
        '#title' => t('Layout style'),
        '#options' => array(
            'style_bakery' => t('Layout style 1'),
            'style_coffee' => t('Layout style 2'),
            'style_pizza' => t('Layout style 3'),
            'style_restaurant' => t('Layout style 4'),
            'style_winery' => t('Layout style 5'),
        ),
        '#default_value' => theme_get_setting('layout_style', 'butte'),
    );

    // Blog settings
    $form['settings']['blog'] = array(
        '#type' => 'details',
        '#title' => t('Blog settings'),
        '#open' => FALSE,
    );

    $form['settings']['blog']['sidebar'] = array(
        '#type' => 'select',
        '#title' => t('Blog sidebar'),
        '#options' => array(
            'left' => t('Left'),
            'right' => t('Right'),
            'none' => t('Full Width')
        ),
        '#default_value' => theme_get_setting('sidebar', 'butte'),
    );

    $form['settings']['blog']['blog_bg_image_file'] = array(
        '#type' => 'textfield',
        '#title' => t('URL of the Header bg image'),
        '#default_value' => theme_get_setting('blog_bg_image_file'),
        '#description' => t('Enter a URL Header bg image.'),
        '#size' => 40,
        '#maxlength' => 512,
    );
    $form['settings']['blog']['blog_bg_image'] = array(
        '#type' => 'file',
        '#title' => t('Upload Header bg image'),
        '#size' => 40,
        '#attributes' => array('enctype' => 'multipart/form-data'),
        '#description' => t('If you don\'t jave direct access to the server, use this field to upload your Header bg image. Uploads limited to .png .gif .jpg .jpeg .apng .svg extensions'),
        '#element_validate' => array('butte_second_image_validate'),
    );


    //footer settings
    $form['settings']['footer'] = array(
        '#type' => 'details',
        '#title' => t('Footer settings'),
        '#open' => FALSE,
    );


  
    $form['settings']['footer']['copyright_text'] = array(
        '#type' => 'textarea',
        '#title' => t('Copyright text'),
        '#default_value' => theme_get_setting('copyright_text', 'butte'),
    );
    $form['settings']['footer']['footer_network'] = array(
        '#type' => 'textarea',
        '#title' => t('Footer network'),
        '#default_value' => theme_get_setting('footer_network', 'butte'),
    );
}

/**
 * Custom submit handler for rainbow settings form.
 */
function butte_second_image_validate($element, FormStateInterface $form_state) {
    global $base_url;

    $validators = array('file_validate_extensions' => array('png gif jpg jpeg apng svg'));
    $file1 = file_save_upload('blog_bg_image', $validators, "public://", NULL, FILE_EXISTS_REPLACE);

    if (!empty($file1)) {
        // change file's status from temporary to permanent and update file database
        if ((is_object($file1[0]) == 1)) {
            $file1[0]->status = FILE_STATUS_PERMANENT;
            $file1[0]->save();
            $uri = $file1[0]->getFileUri();
            $file_url1 = file_create_url($uri);
            $file_url1 = str_ireplace($base_url, '', $file_url1);
            $form_state->setValue('blog_bg_image_file', $file_url1);
        }
    }
        $file3 = file_save_upload('bg_footer_image', $validators, "public://", NULL, FILE_EXISTS_REPLACE);

    if (!empty($file3)) {
        // change file's status from temporary to permanent and update file database
        if ((is_object($file3[0]) == 1)) {
            $file3[0]->status = FILE_STATUS_PERMANENT;
            $file3[0]->save();
            $uri = $file3[0]->getFileUri();
            $file_url3 = file_create_url($uri);
            $file_url3 = str_ireplace($base_url, '', $file_url3);
            $form_state->setValue('bg_footer_image_file', $file_url3);
        }
    }
}

?>