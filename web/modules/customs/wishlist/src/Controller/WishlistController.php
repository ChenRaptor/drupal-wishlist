<?php
namespace Drupal\wishList\Controller;

use Drupal\Core\Controller\ControllerBase;


class WishlistController extends ControllerBase {

  public function content() {
    $build['nouveau-template'] = [
      '#theme' => 'wishlist_custom_template',
      '#test_var' => "yo yo yo yo yo yo yo, c'est les ratz qui font le rap",
    ];
    return $build;
  }

}

?>