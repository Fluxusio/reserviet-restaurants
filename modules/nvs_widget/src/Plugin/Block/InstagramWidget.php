<?php

namespace Drupal\nvs_widget\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 *
 *
 * @Block(
 *   id = "instagramwidget",
 *   admin_label = @Translation("[NVS] Instagram widget"),
 *   category = @Translation("Naviteam widget")
 * )
 */

class InstagramWidget extends BlockBase {

  /**
   * Overrides \Drupal\block\BlockBase::blockForm().
   */

  public function blockForm($form, FormStateInterface $form_state) {
    $form['user_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('User name'),
      '#description' => $this->t('Eg: <em>saatchi_gallery</em>'),
      '#required' => TRUE,
      '#default_value' => isset($this->configuration['user_name']) ? $this->configuration['user_name'] : '',
    ];
    $form['record'] = [
      '#type' => 'select',
      '#title' => $this->t('Number of recent photos items to display'),
      '#required' => TRUE,
      '#options' => 
        array(
          2 => $this->t('2'),
          3 => $this->t('3'),
          4 => $this->t('4'),
          5 => $this->t('5'),
          6 => $this->t('6'),
          7 => $this->t('7'),
          8 => $this->t('8'),
          9 => $this->t('9'),
          10 => $this->t('10'),
          11 => $this->t('11'),
          12 => $this->t('12'),
          13 => $this->t('13'),
          14 => $this->t('14'),
          15 => $this->t('15'),
          16 => $this->t('16'),
          17 => $this->t('17'),
          18 => $this->t('18'),
          19 => $this->t('19'),
          20 => $this->t('20'),
          25 => $this->t('25'),
          30 => $this->t('30'),
        ),
      '#default_value' => isset($this->configuration['record']) ? $this->configuration['record'] : '',
    ];
    return $form;
  }

  /**
   * Overrides \Drupal\block\BlockBase::blockSubmit().
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['user_name'] = $form_state->getValue('user_name');
    $this->configuration['record'] = $form_state->getValue('record');
  }
  public function build() {
    $config = $this->getConfiguration();
    $flickr_id = $config['user_name'];
    $flickr_photos_count = $config['record'];

    $username = $config['user_name']; // your username
    //username sirdoan94
    $access_token = '2248030459.e5ba5a7.ceb77030446040d09f3f2e2734491dfa'; // put your access token here
    $count = $config['record']; // number of images to show
    include 'instagram.php'; 

    $ins_media = $insta->userMedia(); 
    $i = 0; 
    $out = '<ul class="footer_photostream clearfix">';
    print_r($ins_media['data']);
    foreach ($ins_media['data'] as $vm): 
        if($count == $i){ break;}
        $i++;
        $img = $vm['images']['low_resolution']['url'];
        $link = $vm["link"];
        $out .= '<li><a target="_blank" href="'.$link.'"><img src="'.$img.'" alt="image"/></a></li>';
    endforeach;
    $out .= '</ul>';
    return [
      '#markup' => $out,
    ];
  }
}
