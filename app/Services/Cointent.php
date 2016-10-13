<?php
/**
 * Created by PhpStorm.
 * User: daltongibbs
 * Date: 7/13/16
 * Time: 2:38 PM
 */

namespace App\Services;

use GuzzleHttp\Client;
use \Exception;

class Cointent {

    const HOST = "https://api.cointent.com"; //TODO: Change to production
    const PUBLISHER_ID = 457;
    const PUB_TOKEN = 'fbc7cb50b459953be336e5840dab8bc161b3e6d6b494beb19aad868171a684c8';
    protected $client;

    public function __construct()
    {
        //
    }

    public function lookUpPrice($articleId)
    {
        $url = "/price/publisher/" . self::PUBLISHER_ID . "/article/{$articleId}";

        return $this->request('get', $url);
    }

    public function checkUnlockStatus($articleId, $email)
    {
        $url = "/gating/publisher/" . self::PUBLISHER_ID . "/article/{$articleId}";
        
        $args = array(
            'pubtoken' => self::PUB_TOKEN,
            'email' => $email
        );

        return $this->request('get', $url, [], $args);
    }

    public function createUser($email)
    {
        try {

            $url = "/user/create";

            $data = array(
                'publisher' => self::PUBLISHER_ID,
                'pubtoken' => self::PUB_TOKEN,
                'email' => $email
            );

            return $this->request('post', $url, $data);

        } catch (Exception $e) {

            if ($e->getCode() == 409) {

                return $this->getUserPasscode($email);

            }

            throw $e;
        }
    }

    public function getUserPasscode($email)
    {
        $url = "/user/passwordCode";

        $args = array(
            'publisher' => self::PUBLISHER_ID,
            'pubtoken' => self::PUB_TOKEN,
            'email' => $email
        );

        return $this->request('get', $url, [], $args);
    }

    public function getUserLinkToken($email)
    {
        $url = "/user/linkToken";

        $args = array(
            'publisher' => self::PUBLISHER_ID,
            'pubtoken' => self::PUB_TOKEN,
            'email' => $email
        );

        return $this->request('get', $url, [], $args);
    }

    public function grantUserSubscription($email, $plan, $cycles)
    {
        $url = "/subscription/grant/publisher/" . self::PUBLISHER_ID . "/plan/" . $plan;

        $data = array(
            'pubtoken' => self::PUB_TOKEN,
            'email' => $email,
            'cycles' => $cycles
        );

        return $this->request('post', $url, $data);
    }

    public function cancelUserSubscription($email, $plan)
    {
        $url = "/subscription/cancel/publisher/" . self::PUBLISHER_ID . "/plan/" . $plan;

        $data = array(
            'pubtoken' => self::PUB_TOKEN,
            'email' => $email
        );

        return $this->request('post', $url, $data);
    }

    public function cutoffUserSubscription($email, $plan)
    {
        $url = "/subscription/cutoff/publisher/" . self::PUBLISHER_ID . "/plan/" . $plan;

        $data = array(
            'pubtoken' => self::PUB_TOKEN,
            'email' => $email
        );

        return $this->request('post', $url, $data);
    }

    private function request($method, $url, $data = [], $args = [])
    {
        try {

            $client = $this->getHttpClient();

            $response = $client->{$method}($url, [
                'form_params' => $data,
                'query' => $args,
            ]);

            $json = json_decode((string)$response->getBody());

            return $json;

        } catch (Exception $e) {

            throw $e;

        }
    }

    private function getHttpClient()
    {
        if (!empty($this->client)) {

            return $this->client;

        }

        $this->client = new Client([
            'base_uri' => self::HOST,
            'timeout' => 5.0
        ]);

        return $this->client;
    }
    
}