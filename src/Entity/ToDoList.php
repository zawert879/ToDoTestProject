<?php

/**
 * Created by PhpStorm.
 * User: zawert
 * Date: 18.03.19
 * Time: 19:40
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use App\BaseBundle\Entity\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\CreateToDo;
use App\Controller\UpdateToDo;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
/**
 *
 * @ORM\Entity
 * @ApiResource(
 *     collectionOperations={
 *          "get",
 *          "post"={
 *              "method"="POST",
 *              "path"="/to_do_lists",
 *              "controller"=CreateToDo::class
 *          },
 *     },
 *     itemOperations={
 *          "get",
 *          "delete",
 *          "put"={
 *              "method"="PUT",
 *              "path"="/to_do_lists/{id}",
 *              "controller"=UpdateToDo::class
 *          },
 *     },
 *     normalizationContext={"groups"={"GetToDoList","GetObjUser", "GetBase"}},
 *     denormalizationContext={"groups"={"SetToDoList"}},
 *
 * )
 * @ApiFilter(BooleanFilter::class)
 * @ApiFilter(DateFilter::class)
 * @ApiFilter(NumericFilter::class)
 * @ApiFilter(OrderFilter::class)
 */
class ToDoList extends BaseEntity
{

    /**
     * @var
     * @ORM\Column(type="string", name="title")
     * @Assert\NotBlank()
     * @Groups({"SetToDoList", "GetToDoList", "GetObjToDoList"})
     */
    public $title;


    /**
     * @var
     * @ORM\Column(type="text", name="description")
     * @Assert\NotBlank()
     * @Groups({"SetToDoList", "GetToDoList", "GetObjToDoList"})
     */
    public $description;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="App\BaseBundle\Entity\User")
     * @Groups({"GetToDoList"})
     */
    public $user;

    /**
     * @var \DateTimeInterface
     * @Assert\NotBlank()
     * @Assert\DateTime()
     * @ORM\Column(type="datetime",nullable=true)
     * @Groups({"SetToDoList", "GetToDoList","GetObjToDoList"})
     */
    public $dueDate;

    
    /**
     * @var integer (высокий - красный - 3, средний - желтый- 2, низкий - синий -1 ,нет - 0
     * @ORM\Column(type="integer", name="priority")
     * @Groups({"SetToDoList", "GetToDoList", "GetObjToDoList"})
     */
    public $priority = 0;


    /**
     * @var integer за сколько минут напомнить
     * @ORM\Column(type="integer", name="notification_time",nullable=true)
     * @Groups({"SetToDoList", "GetToDoList", "GetObjToDoList"})
     */
    public $notificationTime;
    
    /**
     * @var boolean
     * @ORM\Column(type="boolean", name="is_complete")
     * @Groups({"SetToDoList", "GetToDoList", "GetObjToDoList"})
     */
    public $isComplete = false;


}