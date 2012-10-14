<?php

namespace Chitanka\LibBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Chitanka\LibBundle\Entity\SiteRepository")
 * @ORM\Table(name="site",
 *	indexes={
 *		@ORM\Index(name="name_idx", columns={"name"})}
 * )
 * @UniqueEntity(fields="url")
 */
class Site extends Entity
{
	/**
	* @var integer
	* @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue
	*/
	private $id;

	/**
	* @var string
	* @ORM\Column(type="string", length=60)
	*/
	private $name;

	/**
	* @var string
	* @ORM\Column(type="string", length=100, unique=true)
	*/
	private $url;

	/**
	* @var string
	* @ORM\Column(type="text")
	*/
	private $description;


	public function getId() { return $this->id; }

	public function setName($name) { $this->name = $name; }
	public function getName() { return $this->name; }

	public function setUrl($url) { $this->url = $url; }
	public function getUrl() { return $this->url; }

	public function getDescription() { return $this->description; }
	public function setDescription($description)
	{
		$this->description = ltrim($description, ' ,—');
	}
}
