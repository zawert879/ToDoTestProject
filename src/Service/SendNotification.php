<?php
/**
 * Created by PhpStorm.
 * User: zawert
 * Date: 18.03.19
 * Time: 21:29
 */

namespace App\Service;


use App\Entity\ToDoList;
use Doctrine\ORM\EntityManagerInterface;

class SendNotification
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function send(){

    }
}