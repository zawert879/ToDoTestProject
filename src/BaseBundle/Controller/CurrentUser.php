<?php
/**
 * Created by PhpStorm.
 * User: zawert
 * Date: 14.05.18
 * Time: 18:34
 */
namespace App\BaseBundle\Controller;

use App\BaseBundle\Entity\User;
use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Security;

/**
 * Class CurrentUser
 * @package App\Controller
 */
class CurrentUser
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function __invoke(): ?User
    {
        /** @var User $user */
        $user = $this->security->getUser();
        if (!isset($user)){
            throw new HttpException(401,"Not Authorized");
        }

        if (!$user->isEnabled()){
            throw new HttpException(409,'you not enabled');
        }
        return $user;

    }
}