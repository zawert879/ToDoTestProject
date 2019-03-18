<?php

namespace App\BaseBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

use App\BaseBundle\Controller\CurrentUser;
use App\BaseBundle\Controller\CreateUser;
use App\BaseBundle\Controller\DecisionCaptcha;
use App\BaseBundle\Controller\UpdateUser;
use App\BaseBundle\Controller\ActivateUser;
use App\BaseBundle\Controller\ResetUser;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\BaseBundle\Repository\UserRepository")
 * @ApiResource(
 *     collectionOperations={
 *          "get",
 *          "post"={
 *              "method"="POST",
 *              "path"="/users",
 *              "controller"=CreateUser::class
 *          },
 *          "current"={
 *              "method"="GET",
 *              "path"="/users/current",
 *              "controller"=CurrentUser::class
 *          },
 *     },
 *     itemOperations={
 *          "get",
 *          "delete"={
 *              "access_control"="is_granted('ROLE_ADMIN') or object == user",
 *          },
 *          "put"={
 *           "method"="PUT",
 *           "path"="/users/{id}",
 *           "controller"=UpdateUser::class
 *       }
 *     },
 *     attributes={
 *     "normalization_context"={"groups"={"GetUser", "GetObjBase"}},
 *     "denormalization_context"={"groups"={"SetUser"}}
 * })
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"GetUser","GetObjUser","SetUser"})
     */
    protected $id;

    /**
     * @var bool
     * @Groups({"GetUser","GetObjUser","SetUser"})
     */
    protected $enabled;

    /**
     * @Groups({"GetUser","GetObjUser","SetUser"})
     * @Assert\Email()
     */
    protected $email;

    /**
     * @var string Имя
     * @ORM\Column(name="first_name",type="string",nullable=true)
     * @Groups({"GetUser","GetObjUser","SetUser"})
     */
    public $firstName;

    /**
     * @var string Фамилия
     * @ORM\Column(name="last_name",type="string",nullable=true)
     * @Groups({"GetUser","GetObjUser","SetUser"})
     */
    public $lastName;

    /**
     * @var string Отчество
     * @ORM\Column(name="second_name",type="string",nullable=true)
     * @Groups({"GetUser","GetObjUser","SetUser"})
     */
    public $secondName;

    /**
     * @var
     * @Groups({"SetUser"})
     * @Assert\Regex("/(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z].*?[A-Z])[0-9a-zA-Z!@#$%^&*]{8,}/s")
     */
    protected $password;


    /**
     * @Groups({"GetUser","SetUser","SetObjUser","GetObjUser"})
     */
    protected $username;
    /**
     * @Groups({"GetUser","SetUser"})
     */
    protected $roles;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     */
    protected $dateCreate;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     */
    protected $dateUpdate;

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDateCreate(): \DateTimeInterface
    {
        return $this->dateCreate;
    }

    /**
     * @param \DateTimeInterface $dateCreate
     */
    public function setDateCreate(\DateTimeInterface $dateCreate): void
    {
        $this->dateCreate = $dateCreate;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDateUpdate(): \DateTimeInterface
    {
        return $this->dateUpdate;
    }

    /**
     * @param \DateTimeInterface $dateUpdate
     */
    public function setDateUpdate(\DateTimeInterface $dateUpdate): void
    {
        $this->dateUpdate = $dateUpdate;
    }


    public function __construct()
    {
        parent::__construct();

        try {
            $this->dateCreate = new DateTimeImmutable();
            $this->dateUpdate = new DateTimeImmutable();
        } catch (\Exception $e) {

        }
    }

    public function isUser(?UserInterface $user = null): bool
    {
        return $user instanceof self && $user->id === $this->id;
    }

    /**
     *
     * {@inheritdoc}
     */
    public function setRolesRaw(array $roles)
    {
        $this->roles = array();

        foreach ($roles as $role) {
            $this->roles[] = strtoupper($role);
        }
        $this->roles = array_unique($this->roles);
        $this->roles = array_values($this->roles);

        return $this;
    }


}