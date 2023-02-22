<?php

namespace Tests\Feature;

use App\Http\Livewire\IdeaIndex;
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
    public function index_page_correctly_receive_votes_count()
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

        $this->get(route('idea.index', $idea))
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
            ->assertSet('votes_count', 5)
            ->assertSeeHtml('<div class="text-sm font-bold leading-none">
                            5
                        </div>')
            ->assertSeeHtml('<div class="font-semibold text-2xl">5</div>');
    }
}
