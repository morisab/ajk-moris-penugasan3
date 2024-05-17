<?php

namespace Tests\Feature;

use Tests\TestCase;

class EndpointTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testEndpointUsers()
    {
        $response = $this->get('/users');
        $response->assertStatus(200);

        $response = $this->get('/auth/register');
        $response->assertStatus(200);

        $response = $this->get('/auth/login');
        $response->assertStatus(200);
    }

    public function testEndpointSeris()
    {
        $response = $this->get('/seri');
        $response->assertStatus(200);

        $response = $this->get('/seri/1');
        $response->assertStatus(200);

        $response = $this->get('/seri/create');
        $response->assertStatus(200);
    }

    // public function testEndpointPeminjamans()
    // {
    //     $response = $this->get('/peminjaman');
    //     $response->assertStatus(200);
    // }

    // public function testEndpointCarts()
    // {
    //     $response = $this->get('/cart');
    //     $response->assertStatus(200);
    // }
}