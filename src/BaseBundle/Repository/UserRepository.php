<?php
/**
 * Created by PhpStorm.
 * User: zawert
 * Date: 11.05.18
 * Time: 11:08
 */
namespace App\BaseBundle\Repository;

use App\BaseBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository{

}