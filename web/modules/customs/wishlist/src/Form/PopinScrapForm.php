<?php declare(strict_types = 1);

namespace Drupal\wishlist\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides a Wishlist form.
 */
final class PopinScrapForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'wishlist_popin_scrap';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['entete'] = [
      "#markup" => "<h3>Voulez-vous ajouter un produit depuis une page web externe ?</h3>"
    ];

    $form['url'] = [
      '#type' => 'textfield',
      '#title' => "URL",
      '#description' => "Merci de saisir une url au format : https://www.exemple.com/produit",
    ];

    $form['actions']["yes"] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => "Oui",
        '#submit' => ['::yesScrap'],
      ],
    ];

    $form['actions']["no"] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => "Non",
        '#submit' => ['::noScrap'],
      ],
    ];


    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    // @todo Validate the form here.
    // Example:
    // @code
    //   if (mb_strlen($form_state->getValue('message')) < 10) {
    //     $form_state->setErrorByName(
    //       'message',
    //       $this->t('Message should be at least 10 characters.'),
    //     );
    //   }
    // @endcode
  }

  /**
   * {@inheritdoc}
   */
public function submitForm(array &$form, FormStateInterface $form_state): void {
  $this->messenger()->addStatus($this->t('The message has been sent.'));
  $form_state->setRedirect('<front>');
}

  public function yesScrap(array &$form, FormStateInterface $form_state): void {
    $this->messenger()->addStatus("Ok");
    $url = $form_state->getValue('url');
    $uid = \Drupal::request()->query->get('wid');
    $form_state->setRedirectUrl(Url::fromRoute(
      'node.add', 
      ['node_type' => 'wishlist_item'], 
      ['query' => ['wid' => $uid, 'urlToScrap' => $url]]
    ));
  }
  
  public function noScrap(array &$form, FormStateInterface $form_state): void {
    $this->messenger()->addStatus("NOT Ok");
    $uid = \Drupal::request()->query->get('wid');
    $form_state->setRedirectUrl(Url::fromRoute(
      'node.add', 
      ['node_type' => 'wishlist_item'], 
      ['query' => ['wid' => $uid]]
    ));
  }
}