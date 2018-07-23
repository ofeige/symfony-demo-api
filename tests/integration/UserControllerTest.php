<?php

namespace App\Tests\Integration;

use Api\Dto\UserV1;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @category  symfony-demo-api
 * @copyright Copyright (c) 2018 Dominik Peuscher
 */
class UserControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;
    protected function setup():void
    {
        $this->client = static::createClient([], [
            'PHP_AUTH_USER' => 'basic',
            'PHP_AUTH_PW'   => 'basic',
        ]);
    }

    public function testHasRouteGetV1User(): void
    {
        $this->client->request('GET', '/api/v1/users');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testGetV1UserReturnsJson(): void
    {
        $this->markTestIncomplete('Not possible yet');

        $this->client->request('GET', '/api/v3/users',[],[],['Accept' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertTrue(
            $response->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'the "Content-Type" header is "application/json" (actual: '. $response->headers->get('Content-Type').')'
        );
    }

    public function testGetV1UserIncludesUserArthasMenethil(): void
    {
        $this->markTestIncomplete('Not possible yet');
        $this->client->request('GET', '/api/v3/users',[],[],['Accept' => 'application/json']);

        $expected = (new UserV1())->setId(4)->setEmail('Arthas.Menethil@demo.test')->setUsername('Arthas Menethil');

        /** @var UserV1[] $response */
        $response = json_decode($this->client->getResponse()->getContent());

        $this->assertArraySubset([$expected], $response);
    }

    public function testGetV2User200(): void
    {
        $this->client->request('GET', '/api/v2/users');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testGetV3User200(): void
    {
        $this->client->request('GET', '/api/v3/users');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
