<?php
/**
 * Created by PhpStorm.
 * User: zawert
 * Date: 17.05.18
 * Time: 16:01
 */

namespace App\FireBaseBundle\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use App\BaseBundle\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\FireBaseBundle\Controller\CreateDevice;
use App\BaseBundle\Entity\User;
/**
 * @ORM\Entity()
 * @ApiResource(
 *     attributes={
 *       "normalization_context"={"groups"={"GetDevice","GetBase","GetUser"}},
 *       "denormalization_context"={"groups"={"SetDevice"}}
 *     },
 *     collectionOperations={
 *          "post"={
 *              "method"="POST",
 *              "path"="/devices",
 *              "controller"=CreateDevice::class
 *          },
 *     }
 * )
 */
class Device extends BaseEntity
{
    /**
     * @var string платформа
     * @ORM\Column(name="platform",type="string",nullable=true)
     * @Groups({"GetDevice","GetObjDevice","SetDevice"})
     */
    public $platform;

    /**
     * @var string deviceId
     * @ORM\Column(name="device_id",type="string")
     * @Assert\NotBlank()
     * @Groups({"GetDevice","GetObjDevice","SetDevice"})
     *
     */
    public $deviceId;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="App\BaseBundle\Entity\User")
     * @ORM\JoinColumn(name="user",nullable=true,onDelete="CASCADE")
     *
     */
    public $user;

}