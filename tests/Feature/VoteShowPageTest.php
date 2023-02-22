<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeaShow;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class VoteShowPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function show_page_contains_idea_show_livewire_component()
    {
        $category = Category::factory()->create(['name' => 'Category 1']);
        $status_open = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        $idea = Idea::factory()->create([
            'user_id' => User::factory(),
            'title' => 'My First Idea',
            'category_id' => $category->id,
            'status_id' => $status_open->id,
            'description' => 'Description of my first idea.',
        ]);

        $this->get(route('idea.show', $idea))
            ->assertSeeLivewire('idea-show');
    }

    /** @test */
    public function show_page_correctly_receive_votes_count()
    {
        $user_a = User::factory()->create();
        $user_b = User::factory()->create();

        $category = Category::factory()->create(['name' => 'Category 1']);
        $status_open = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        $idea = Idea::factory()->create([
            'user_id' => $user_a->id,
            'title' => 'My First Idea',
            'category_id' => $category->id,
            'status_id' => $status_open->id,
            'description' => 'Description of my first idea.',
        ]);

        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user_a->id,
        ]);
        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user_b->id,
        ]);

        $this->get(route('idea.show', $idea))
            ->assertViewHas('votes_count', 2);
    }

    /** @test */
    public function votes_count_shows_correctly_on_show_page_livewire_component()
    {
        $user = User::factory()->create();

        $category = Category::factory()->create(['name' => 'Category 1']);
        $status_open = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'category_id' => $category->id,
            'status_id' => $status_open->id,
            'description' => 'Description of my first idea.',
        ]);

        Livewire::test(IdeaShow::class, [
            'idea' => $idea,
            'votes_count' => 5,
        ])
            ->assertSet('votes_count', 5);
    }

    /** @test */
    public function user_who_is_logged_in_shows_voted_if_idea_already_voted_for()
    {
        $user = User::factory()->create();

        $category = Category::factory()->create(['name' => 'Category 1']);
        $status_open = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
            'category_id' => $category->id,
            'status_id' => $status_open->id,
            'description' => 'Description of my first idea.',
        ]);

        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
        ]);

        Livewire::actingAs($user)
            ->test(IdeaShow::class, [
                'idea' => $idea,
                'votes_count' => 5,
            ])
            ->assertSet('has_voted', true)
            ->assertSee('Voted');
    }
}
