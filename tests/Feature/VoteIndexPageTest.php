<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeaIndex;
use App\Http\Livewire\IdeasIndex;
use App\Models\Category;
use App\Models\Idea;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class VoteIndexPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_page_contains_indea_index_livewire_component()
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

        $this->get(route('idea.index'))
            ->assertSeeLivewire('idea-index');
    }

    /** @test */
    public function ideas_index_livewire_component_correctly_receive_votes_count()
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

        Livewire::test(IdeasIndex::class)
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->first()->votes_count == 2;
            });
    }

    /** @test */
    public function votes_count_shows_correctly_on_index_page_livewire_component()
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

        Livewire::test(IdeaIndex::class, [
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

        $idea->votes_count = 1;
        $idea->voted_by_user = 1;

        Livewire::actingAs($user)
            ->test(IdeaIndex::class, [
                'idea' => $idea,
                'votes_count' => 5,
            ])
            ->assertSet('has_voted', true)
            ->assertSee('Voted');
    }

    /** @test */
    public function user_who_is_not_logged_in_is_redirected_to_login_page_when_trying_to_vote()
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

        Livewire::test(IdeaIndex::class, [
                'idea' => $idea,
                'votes_count' => 5,
            ])
            ->call('vote')
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_who_is_logged_in_can_vote_for_idea()
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

        $this->assertDatabaseMissing('votes', [
            'user_id' => $user->id,
            'idea_id' => $idea->id,
        ]);

        Livewire::actingAs($user)
            ->test(IdeaIndex::class, [
                'idea' => $idea,
                'votes_count' => 5,
            ])
            ->call('vote')
            ->assertSet('votes_count', 6)
            ->assertSet('has_voted', true)
            ->assertSee('Voted');

        $this->assertDatabaseHas('votes', [
            'user_id' => $user->id,
            'idea_id' => $idea->id,
        ]);
    }

    /** @test */
    public function user_who_is_logged_in_can_remove_vote_for_idea()
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

        $idea->votes_count = 1;
        $idea->voted_by_user = 1;

        $this->assertDatabaseHas('votes', [
            'user_id' => $user->id,
            'idea_id' => $idea->id,
        ]);

        Livewire::actingAs($user)
            ->test(IdeaIndex::class, [
                'idea' => $idea,
                'votes_count' => 5,
            ])
            ->call('vote')
            ->assertSet('votes_count', 4)
            ->assertSet('has_voted', false)
            ->assertSee('Vote');

        $this->assertDatabaseMissing('votes', [
            'user_id' => $user->id,
            'idea_id' => $idea->id,
        ]);
    }
}