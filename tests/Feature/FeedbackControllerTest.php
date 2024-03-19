<?php

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbackControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_access_feedback_index_route_staff_authenticated()
    {
        // Arrange
        $user = User::factory()->create(['role' => 'staff']);
        // Act
        $response = $this->actingAs($user)->get(route('feedbacks.index'));
        // Assert
        $response->assertStatus(200);
    }

    public function test_access_feedback_index_route_not_staff_authenticated()
    {
        // Arrange
        $user = User::factory()->create();
        // Act
        $response = $this->actingAs($user)->get(route('feedbacks.index'));
        // Assert
        $response->assertStatus(403);
    }

    public function test_access_feedback_destroy_route_staff_authenticated()
    {
        // Arrange
        $user = User::factory()->create(['role' => 'staff']);
        $feedback = Feedback::factory()->create();
        // Act
        $response = $this->actingAs($user)->delete(route('feedbacks.destroy', $feedback));
        // Assert
        $response->assertStatus(200);
    }

    public function test_access_feedback_destroy_route_not_staff_authenticated()
    {
        // Arrange
        $user = User::factory()->create();
        $feedback = Feedback::factory()->create();
        // Act
        $response = $this->actingAs($user)->delete(route('feedbacks.destroy', $feedback));
        // Assert
        $response->assertStatus(403);
    }

    public function test_access_feedback_restore_route_staff_authenticated()
    {
        // Arrange
        $user = User::factory()->create(['role' => 'staff']);
        $feedback = Feedback::factory()->create(['deleted_at' => now()]);
        // Act
        $response = $this->actingAs($user)->patch(route('feedbacks.restore', $feedback));
        // Assert
        $response->assertStatus(200);
    }

    public function test_access_feedback_restore_route_not_staff_authenticated()
    {
        // Arrange
        $user = User::factory()->create();
        $feedback = Feedback::factory()->create(['deleted_at' => now()]);
        // Act
        $response = $this->actingAs($user)->patch(route('feedbacks.restore', $feedback));
        // Assert
        $response->assertStatus(403);
    }

    public function test_create_and_store_feedback()
    {
        // Arrange
        $user = User::factory()->create(['role' => 'member']);
        $feedbackData = Feedback::factory()->raw();
        // Act (access the feedback creation form and save a feedback)
        $response = $this->actingAs($user)->post(route('feedbacks.store'), $feedbackData);
        // Assert (check if the feedback is saved in the database)
        $this->assertDatabaseHas('feedbacks', $feedbackData);
    }

    public function test_delete_feedback()
    {
        // Arrange
        $feedback = Feedback::factory()->create();
        $user = User::factory()->create(['role' => 'staff']);
        // Act
        $response = $this->actingAs($user)->delete(route('feedbacks.destroy', $feedback));
        // Assert
        $this->assertSoftDeleted('feedbacks', ['id' => $feedback->id]);
    }

    public function test_restore_feedback()
    {
        // Arrange
        $feedback = Feedback::factory()->create(['deleted_at' => now()]);
        $user = User::factory()->create(['role' => 'staff']);
        // Act
        $response = $this->actingAs($user)->patch(route('feedbacks.restore', $feedback));
        // Assert
        $this->assertDatabaseHas('feedbacks', ['id' => $feedback->id, 'deleted_at' => null]);
    }
}
