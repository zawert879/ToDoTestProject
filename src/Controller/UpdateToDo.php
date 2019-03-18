<?php
/**
 * Created by PhpStorm.
 * User: zawert
 * Date: 14.05.18
 * Time: 18:34
 */
namespace App\Controller;

use App\BaseBundle\Entity\User;
use App\Entity\ToDoList;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Security;

/**
 * Class CurrentUser
 * @package App\Controller
 */
class UpdateToDo
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function __invoke(ToDoList $data): ?ToDoList
    {
        /** @var User $user */
        $user = $this->security->getUser();
        if (!$this->security->isGranted('ROLE_ADMIN')){
            if ($data->user != $user){
                throw new HttpException(403,'Forbidden');
            }
        }
        return $data;

    }
}