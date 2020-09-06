<?php
/**
 *  Explorer Cash
 *
 *  @author    explorer.cash <support@explorer.cash>
 *  @copyright 2020 explorer.cash. All rights reserved.
 *  @license   LGPL-3.0 https://www.gnu.org/licenses/lgpl-3.0.en.html
 */

namespace ExplorerCash;

class Api
{

    protected static $endpoints = [
        'production' => 'https://api.explorer.cash/paymentrequests',
        'testing' => 'https://api.explorer.cash/testing/paymentrequests',
        'rates' => 'https://api.explorer.cash/rates'
    ];
    
    public static function paymentRequest($data, $mode = 'production')
    {
        if (!in_array($mode, ['production', 'testing'])) {
            $mode = 'production';
        }
        
        $result = self::request(static::$endpoints[$mode], $data);
        
        return $result['payment_id'] ?? false;
    }
    
    public static function subscribeRates($data)
    {        
        return self::request(static::$endpoints['rates'], $data);
    }

    public static function request($url, $data)
    {
        $context_options = array(
            'http' => array(
                'ignore_errors' => true,
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => json_encode($data)
            )
        );
        
        $context = stream_context_create($context_options);
        
        $result = json_decode(file_get_contents($url, false, $context), true);
        
        if (!empty($result['error'])) {
            throw new \Exception($result['message']);
        }
        
        return $result;
    }

}
