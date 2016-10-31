<?php

namespace Sf2apiBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sf2apiBundle\Entity\User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Sf2apiBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable {

  /**
   * @var integer
   */
  protected $id;

  /**
   * @var string
   */
  protected $name;

  /**
   * @var string
   */
  protected $email;

  /**
   * @var string
   */
  protected $password;

  /**
   * @var string
   */
  protected $salt;
  
  /**
   * Get id
   *
   * @return integer 
   */
  public function getId() {
	return $this->id;
  }

  /**
   * Set name
   *
   * @param string $name
   * @return User
   */
  public function setName($name) {
	$this->name = $name;

	return $this;
  }

  /**
   * Get name
   *
   * @return string 
   */
  public function getName() {
	return $this->name;
  }

  /**
   * Set email
   *
   * @param string $email
   * @return User
   */
  public function setEmail($email) {
	$this->email = $email;

	return $this;
  }

  /**
   * Get email
   *
   * @return string 
   */
  public function getEmail() {
	return $this->email;
  }

  /**
   * Set password
   *
   * @param string $password
   * @return User
   */
  public function setPassword($password) {
	$this->password = $password;

	return $this;
  }

  /**
   * Get password
   *
   * @return string 
   */
  public function getPassword() {
	return $this->password;
  }

  /**
   * @inheritDoc
   */
  public function eraseCredentials() {
	
  }

  /**
   * @see \Serializable::serialize()
   */
  public function serialize() {
	return serialize(
			array(
				$this->id,
			)
	);
  }
  
  /**
   * @see \Serializable::unserialize()
   */
  public function unserialize($serialized) {
	list (
			$this->id,
			) = unserialize($serialized);
  }

  /**
   * @inheritDoc
   */
  public function getSalt() {
	return $this->salt;
  }

  public function setSalt($salt) {
	$this->salt = $salt;
  }

  /**
   * @inheritDoc
   */
  public function getRoles() {
	return array('ROLE_USER');
  }

  /**
   * @inheritDoc
   */
  public function getUsername() {
	return $this->email;
  }

  /**
   * @inheritDoc
   */
  public function setUsername($username) {
	$this->email = $username;
  }
  
}
