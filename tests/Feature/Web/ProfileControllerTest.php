<?php

namespace Tests\Feature\Web;

use Tests\TestCase;

class ProfileControllerTest extends TestCase
{

    public function testOrders()
    {
        $response = $this->signInFromWeb()->get(route('profile.orders'));
        $response->assertSuccessful()->assertViewIs('profile.orders');
    }

    public function testCredentials()
    {
        $response = $this->signInFromWeb()->get(route('profile.credentials.update'));
        $response->assertSuccessful()->assertViewIs('profile.credentials');
    }

    public function testWishlist()
    {
        $response = $this->signInFromWeb()->get(route('profile.wishlist'));
        $response->assertSuccessful()->assertViewIs('profile.wishlist');
    }

    public function testTickets()
    {
        $response = $this->signInFromWeb()->get(route('profile.tickets'));
        $response->assertSuccessful()->assertViewIs('profile.tickets');
    }

    public function testAddresses()
    {
        $response = $this->signInFromWeb()->get(route('profile.addresses'));
        $response->assertSuccessful()->assertViewIs('profile.addresses');
    }

    public function testChats()
    {
        $response = $this->signInFromWeb()->get(route('profile.chats'));
        $response->assertSuccessful()->assertViewIs('profile.chats');
    }

    public function testCart()
    {
        $response = $this->signInFromWeb()->get(route('profile.cart'));
        $response->assertSuccessful()->assertViewIs('profile.cart');
    }

    public function testInfo()
    {
        $response = $this->signInFromWeb()->get(route('profile.info'));
        $response->assertSuccessful()->assertViewIs('profile.info');
    }

}