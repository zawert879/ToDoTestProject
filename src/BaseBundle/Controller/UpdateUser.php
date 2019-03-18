<?php
/**
 * Created by PhpStorm.
 * User: zawert
 * Date: 14.05.18
 * Time: 18:34
 */

namespace App\BaseBundle\Controller;

use App\BaseBundle\Entity\User;
use Symfony\Component\Security\Core\Security;

class UpdateUser
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function __invoke(User $data): User
    {
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            $data->setRolesRaw(['ROLE_USER']);
        } else {
            $data->setRolesRaw($data->getRoles());
        }
        /** @var User $user */
        return $data;
    }
}