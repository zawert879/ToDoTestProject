<?php
/**
 * Created by PhpStorm.
 * User: zawert
 * Date: 14.05.18
 * Time: 18:34
 */

namespace App\BaseBundle\Controller;

use App\BaseBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CreateUser
{
    public $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    /**
     * @param User $data
     * @return User|JsonResponse
     * @throws \Exception
     */
    public function __invoke(User $data)
    {
        if (trim($data->getUsername()) == "") {
            throw new HttpException(400, "bad request");
        }
        $data->setPlainPassword($data->getPassword());
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            $data->setRolesRaw(['ROLE_USER']);
        } else {
            $data->setRolesRaw($data->getRoles());
        }
        $data->setEnabled(true);
        /** @var User $user */
        return $data;
    }
}