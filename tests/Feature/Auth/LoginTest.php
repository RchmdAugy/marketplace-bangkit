<?php

namespace Tests\Feature\Auth;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    // use RefreshDatabase; 

    /**
     * Tes untuk memastikan halaman login dapat ditampilkan.
     */
    public function test_render_page()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /**
     * Tes untuk memastikan pengguna dapat login dengan kredensial yang valid.
     */
    public function test_user_can_login_successfully()
    {

        $response = $this->post('/login', [
            'email'    => 'rachaugy123@gmail.com',
            'password' => 'augyaugy123', 
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect('/');
    }
}