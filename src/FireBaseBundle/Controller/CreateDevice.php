<?php
/**
 * Created by PhpStorm.
 * User: zawert
 * Date: 14.05.18
 * Time: 18:34
 */

namespace App\FireBaseBundle\Controller;

use App\FireBaseBundle\Entity\Device;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;

class CreateDevice
{
    private $token;
    private $em;
    public function __construct(TokenStorageInterface $tokenStorage,EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->token = $tokenStorage;
    }

    public function __invoke(Device $data): Device
    {
        $user = $this->token->getToken()->getUser();
        if (isset($user)){
            $data->user = $user;
        }
        $devices = $this->em->getRepository(Device::class)->findBy(["deviceId"=>$data->deviceId]);
        foreach ($devices as $device){
            if ($device->user !=$user){
                $device->user = $user;
                return $device;
            }
        }
        return $data;
    }
}