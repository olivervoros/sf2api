<?php

namespace Sf2apiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class Sf2apiBundle extends Bundle {

  public function boot() {
	$em = $this->container->get('doctrine')->getEntityManager();
	$platform = $em->getConnection()->getDatabasePlatform();
  }

}
