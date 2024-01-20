<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketAuthorizationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     use RefreshDatabase;
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_cannot_view_ticket_not_associated_with_queue()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a ticket with a queue that the user is not associated with
        $ticket = Ticket::factory()->create();

        // Attempt to view the ticket
        $response = $this->actingAs($user)->json('GET', "/api/tickets/{$ticket->id}");

        // Assert that the response is a 403 (Forbidden) status
        $response->assertStatus(403);

        // Optionally, you can assert a specific message in the response
        $response->assertJson(['message' => 'Unauthorized']);
    }
}
