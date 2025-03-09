<?php

namespace Chapa\Tests;
require_once __DIR__ . "/../vendor/autoload.php";

use Chapa\Exception\InvalidPostDataException;
use Chapa\Model\PostData;
use Chapa\Util;
use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{

    public function testValidate()
    {
        $this->expectNotToPerformAssertions();

        $postData = new PostData();
        $postData->amount('100')
            ->currency('ETB')
            ->email('testuser@example.com')
            ->firstname('test')
            ->lastname('user')
            ->transactionRef("random-string")
            ->callbackUrl('https://testsite.com')
            ->customizations(
                array(
                    'customization[title]' => 'title',
                    'customization[description]' => 'It is time to pay'
                )
            );
        Util::validate($postData);
    }

    public function testValidate_Throw_Exception_For_Invalid_Amount_Value()
    {
        $this->expectException(InvalidPostDataException::class);

        $postData = new PostData();
        $postData->amount('100L') // invalid amount value
            ->currency('ETB')
            ->email('testuser@example.com')
            ->firstname('test')
            ->lastname('user')
            ->transactionRef("random-string")
            ->callbackUrl('https://testsite.com')
            ->customizations(
                array(
                    'customization[title]' => 'title',
                    'customization[description]' => 'It is time to pay'
                )
            );
        Util::validate($postData);
    }

    public function testValidate_Throw_Exception_For_Invalid_Currency_Value()
    {
        $this->expectException(InvalidPostDataException::class);

        $postData = new PostData();
        $postData->amount('100')
            ->currency('ETB1') // invalid currency value
            ->email('testuser@example.com')
            ->firstname('test')
            ->lastname('user')
            ->transactionRef("random-string")
            ->callbackUrl('https://testsite.com')
            ->customizations(
                array(
                    'customization[title]' => 'title',
                    'customization[description]' => 'It is time to pay'
                )
            );
        Util::validate($postData);
    }

    public function testValidate_Throw_Exception_For_Invalid_Email_Address()
    {
        $this->expectException(InvalidPostDataException::class);

        $postData = new PostData();
        $postData->amount('100')
            ->currency('ETB')
            ->email('testuser@example') // invalid email address
            ->firstname('test')
            ->lastname('user')
            ->transactionRef("random-string")
            ->callbackUrl('https://testsite.com')
            ->customizations(
                array(
                    'customization[title]' => 'title',
                    'customization[description]' => 'It is time to pay'
                )
            );
        Util::validate($postData);
    }

    public function testValidate_Throw_Exception_For_Invalid_Name_Format()
    {
        $this->expectException(InvalidPostDataException::class);

        $postData = new PostData();
        $postData->amount('100')
            ->currency('ETB')
            ->email('testuser@example.com')
            ->firstname('test1') // invalid name format
            ->lastname('user')
            ->transactionRef("random-string")
            ->callbackUrl('https://testsite.com')
            ->customizations(
                array(
                    'customization[title]' => 'title',
                    'customization[description]' => 'It is time to pay'
                )
            );
        Util::validate($postData);
    }

    public function testValidate_Throw_Exception_For_Invalid_Callback_Url()
    {
        $this->expectException(InvalidPostDataException::class);

        $postData = new PostData();
        $postData->amount('100')
            ->currency('ETB')
            ->email('testuser@example.com')
            ->firstname('test')
            ->lastname('user')
            ->transactionRef("random-string")
            ->callbackUrl('https//testsite') // invalid callback url
            ->customizations(
                array(
                    'customization[title]' => 'title',
                    'customization[description]' => 'It is time to pay'
                )
            );
        Util::validate($postData);
    }

    public function testGenerateToken(){
        $token = Util::generateToken('test');

        $this->assertIsString($token);
        $this->stringStartsWith('test');
    }


}