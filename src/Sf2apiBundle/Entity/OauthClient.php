<?php

namespace Sf2apiBundle\Entity;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table("oauthclient")
 * @ORM\Entity
 */
class OauthClient extends BaseClient {

  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  public function __construct() {
	parent::__construct();
  }
  

}
