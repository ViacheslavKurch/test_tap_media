<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;

class ClickControllerTest extends TestCase
{
    /**
     * @return array
     */
    private function getTestHeaders() : array
    {
        $faker = \Faker\Factory::create();

        return [
            'User-Agent'  => $faker->userAgent,
            'referer'     => $faker->url,
            'REMOTE_ADDR' => $faker->ipv4,
        ];
    }

    public function testStore()
    {
        $headers = $this->getTestHeaders();

        $server = $this->transformHeadersToServerVars($headers);

        $response = $this->call('GET', '/click', ['param1' => '1', 'param2' => '2'], [], [], $server);

        $response->assertRedirect();
    }

    public function testStoreFailedWhenEmptyParameters()
    {
        $headers = $this->getTestHeaders();

        $server = $this->transformHeadersToServerVars($headers);

        $response = $this->call('GET', '/click', [], [], [], $server);

        $response->assertSuccessful();

        $response->assertSee('Invalid input data');
    }

    public function testStoreFailedWhenRefererIsNotEmpty()
    {
        $headers = $this->getTestHeaders();

        unset($headers['headers']['referer']);

        $server = $this->transformHeadersToServerVars($headers);

        $response = $this->call('GET', '/click', [], [], [], $server);

        $response->assertSuccessful();

        $response->assertSee('Invalid input data');
    }
}