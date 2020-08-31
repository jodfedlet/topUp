<?php
namespace App\Helpers;

class Stripe
{
    private $api_key;
    const STRIPE_URL = 'https://api.stripe.com/v1/';

    public function __construct(string $api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * @param string $endpoint
     * @param array $data
     * @return \stdClass
     * @throws \Exception
     */
    public function api(string $endpoint, array $data): \stdClass
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => self::STRIPE_URL . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => $this->api_key,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_POSTFIELDS => http_build_query($data)
        ]);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);
        if (isset($response->error)) {
            throw new \Exception($response->error->message);
        }
        return $response;
    }
}