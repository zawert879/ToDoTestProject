<?php
/**
 * Created by PhpStorm.
 * User: zawert
 * Date: 10.05.18
 * Time: 11:32
 */


namespace App\BaseBundle\Entity;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;



/**
 * @ORM\Entity
 * @ORM\Table(name="client")
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"GetClient"}},
 *     "denormalization_context"={"groups"={"SetClient"}}
 * })
 */
class Client extends BaseClient
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"GetClient"})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     * @Groups({"GetClient","SetClient"})
     */
    protected $name;

    /**
     * @var string
     * @Groups({"GetClient"})
     */
    protected $randomId;

    /**
     * @var string
     * @Groups({"GetClient"})
     */
    protected $secret;

    /**
     * @var string
     * @Groups({"GetClient","SetClient"})
     */
    protected $allowedGrantTypes;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return string
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}