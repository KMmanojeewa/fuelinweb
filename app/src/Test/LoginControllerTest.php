<?php
namespace FuelIn\Test;

use FuelIn\Controller\LoginController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\SapphireTest;

class LoginControllerTest extends SapphireTest
{

    public function randNumber($digits)
    {
        return rand(pow(10, $digits-1), pow(10, $digits)-1);
    }

    public function testRegister()
    {

        $email = $this->randNumber(3).'_test@gmail.com';
        $password = $this->randNumber(8);

        $request = new HTTPRequest('POST', 'login/register', [], [], json_encode([
            'name' => 'Saman_'.$this->randNumber(3),
            'nic' => $this->randNumber(3).'63592v',
            'email' => $email,
            'phone' => '0775869456',
            'address' => 'No:2, main road',
            'password' => $password,
        ]));

        $controller = new LoginController();
        $response = $controller->register($request);

        $this->assertSame('application/json', $response->getHeader('Content-Type'));
        $json = json_decode($response->getBody(), true);

        $this->assertSame(0, $json['status']);
        $this->assertSame('successfully customer created', $json['message']);
    }

    public function testLogin()
    {
        $request = new HTTPRequest('POST', 'login/register', [], [], json_encode([
            'email' => '698_test@gmail.com',
            'password' => '37547455',
        ]));

        $controller = new LoginController();
        $response = $controller->login($request);

        $this->assertSame('application/json', $response->getHeader('Content-Type'));
        $json = json_decode($response->getBody(), true);

        $this->assertSame(0, $json['status']);
        $this->assertSame('successfully logged', $json['message']);
    }
}

