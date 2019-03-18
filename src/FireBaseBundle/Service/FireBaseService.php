<?php
/**
 * Created by PhpStorm.
 * User: vdaron
 * Date: 15.02.16
 * Time: 0:57
 */

namespace App\FireBaseBundle\Service;


use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Filesystem\Filesystem;
use App\BaseBundle\Entity\User;


class FireBaseService
{

    /** @var \Doctrine\ORM\EntityManager */
    private $em;

    /** @var string */
    private $key;

    public function __construct(Container $container)
    {
        $this->em = $container->get('doctrine')->getManager();
        $this->key = $container->getParameter('firebase_token');
    }


    public function sendNotification($deviceId,$messageNotification= [] ,$messageData =[])
    {

        $url = 'https://fcm.googleapis.com/fcm/send';
        $key = $this->key;

        $headers = [
            'Content-Type: application/json',
            "Authorization:key=$key"
        ];

        $data = [
            'to' => $deviceId,
            'priority' => 'high',
            'content_available' => true,
            'notification' => $messageNotification,
            'data' => $messageData
        ];
        $response = $this->makeRequest($url, 'POST', $headers, $data);

        return $response;
    }


    private function sendNotificationRaw($notificationBody)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $key = $this->key;

        $headers = [
            'Content-Type: application/json',
            "Authorization:key=$key"
        ];

        $response = $this->makeRequest($url, 'POST', $headers, $notificationBody);

        return $response;
    }


    /**
     * @param string $url
     * @param string $method
     * @param array $headers
     * @param string|array $body
     * @return mixed
     */
    private function makeRequest($url, $method = 'GET', $headers = [], $body = null)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if (is_string($body)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }

        if (is_array($body)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        }

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }

}