<?php

namespace Chapa;

require_once __DIR__ . '/../../../autoload.php';

use Chapa\Exception\InvalidPostDataException;

/**
 * The Util class serves as a helper class for the main {@link Chapa} class.
 */
class Util
{

    /**
     *  @param PostData  $postData Instance of PostData class that contains post
     *                             fields to be validated.
     * @return void
     */
    public static function validate($postData)
    {
        if(!preg_match("/^([0-9]{1,3},([0-9]{3},)*[0-9]{3}|[0-9]+)(.[0-9][0-9])?$/", $postData->getAMount())){
            throw new InvalidPostDataException('Invalid amount value. Amount must be in numerical format.');
        }

        if(!preg_match('/^([A-Za-z]{3})$/', $postData->getCurrency())){
            throw new InvalidPostDataException('Invalid currency value. Currency should match the following regex: ^([A-Z]{3})$');
        }

        if(!preg_match("/^[A-ZÀ-ÿa-z-,']*$/",  $postData->getFirstName()) || !preg_match("/^[A-ZÀ-ÿa-z-,']*$/",  $postData->getLastName())){
            throw new InvalidPostDataException('Invalid name format. Name should match the following regex: ' . "^[A-ZÀ-ÿa-z-,']*$" );
        }
        
        if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $postData->getEmail())){
            throw new InvalidPostDataException("Invalid email address.");
        }

        $callBackUrl = $postData->getCallbackUrl();
        if(!is_null($callBackUrl)) {
            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $callBackUrl)) {
                throw new InvalidPostDataException("Invalid callback url.");
            }
        }
    }

    /**
     * @param string    $prefix Prefix for transaction reference token e.g. company initials.
     * @return string           Generated token which contains $prefix, some random string
     *                          and a timestamp.
     * @throws \Exception
     */
    public static function generateToken($prefix = 'cp')
    {
        return $prefix . '_' . bin2hex(random_bytes(5)) . '_' .  date('d-m-y_h-i-s');
    }
}
