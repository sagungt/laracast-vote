<?php

namespace Tests\Feature\Filters;

use App\Http\Livewire\IdeasIndex;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OtherFiltersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function top_voted_filter_works()
    {
        $user = User::factory()->create();
        $userB = User::factory()->create();
        $userC = User::factory()->create();

        $ideaOne = Idea::factory()->create();
        $ideaTwo = Idea::factory()->create();

        Vote::factory()->create([
            'idea_id' => $ideaOne->id,
            'user_id' => $user->id,
        ]);

        Vote::factory()->create([
            'idea_id' => $ideaOne->id,
            'user_id' => $userB->id,
        ]);

        Vote::factory()->create([
            'idea_id' => $ideaTwo->id,
            'user_id' => $userC->id,
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('filter', 'Top Voted')
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 2
                    && $ideas->first()->votes()->count() === 2
                    && $ideas->get(1)->votes()->count() === 1;
            });
    }

    /** @test */
    public function my_ideas_filter_works_correctly_when_user_logged_in()
    {
        $user = User::factory()->create();
        $userB = User::factory()->create();

        Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
        ]);

        Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My Second Idea',
        ]);

        Idea::factory()->create([
            'user_id' => $userB->id,
            'title' => 'My Third Idea',
        ]);

        Livewire::actingAs($user)
            ->test(IdeasIndex::class)
            ->set('filter', 'My Ideas')
            ->assertViewHas('ideas', function ($ideas) use ($user) {
                return $ideas->count() === 2
                    && $ideas->first()->user->id === $user->id
                    && $ideas->first()->title === 'My First Idea'
                    && $ideas->get(1)->title === 'My Second Idea';
            });
    }

    /** @test */
    public function my_ideas_filter_works_correctly_when_user_is_not_logged_in()
    {
        Idea::factory()->create();
        Idea::factory()->create();
        Idea::factory()->create();

        Livewire::test(IdeasIndex::class)
            ->set('filter', 'My Ideas')
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function my_ideas_filter_works_correctly_with_categories_filter()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'title' => 'My First Idea',
        ]);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'title' => 'My Second Idea',
        ]);

        Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryTwo->id,
            'title' => 'My Third Idea',
        ]);

        Livewire::actingAs($user)
            ->test(IdeasIndex::class)
            ->set('category', 'Category 1')
            ->set('filter', 'My Ideas')
            ->assertViewHas('ideas', function ($ideas) use ($user) {
                return $ideas->count() === 2
                    && $ideas->first()->user->id === $user->id
                    && $ideas->first()->title === 'My First Idea'
                    && $ideas->get(1)->title === 'My Second Idea';
            });
    }

    /** @test */
    public function no_filters_works_correctly()
    {
        $user = User::factory()->create();
        
        Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My First Idea',
        ]);

        Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My Second Idea',
        ]);

        Idea::factory()->create([
            'user_id' => $user->id,
            'title' => 'My Third Idea',
        ]);

        Livewire::test(IdeasIndex::class)
            ->set('filter', 'No Filter')
            ->assertViewHas('ideas', function ($ideas) use ($user) {
                return $ideas->count() === 3
                    && $ideas->first()->user->id === $user->id
                    && $ideas->first()->title === 'My First Idea'
                    && $ideas->get(1)->title === 'My Second Idea';
            });
    }

    /** @test */
    public function spam_ideas_filter_works()
    {
        $user = User::factory()->admin()->create();
        
        Idea::factory()->create([
            'spam_reports' => 1,
            'title' => 'My First Idea',
        ]);

        Idea::factory()->create([
            'spam_reports' => 2,
            'title' => 'My Second Idea',
        ]);

        Idea::factory()->create([
            'spam_reports' => 3,
            'title' => 'My Third Idea',
        ]);
        
        Idea::factory()->create();

        Livewire::actingAs($user)
            ->test(IdeasIndex::class)
            ->set('filter', 'Spam Ideas')
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 3
                    && $ideas->first()->title === 'My Third Idea'
                    && $ideas->get(1)->title === 'My Second Idea'
                    && $ideas->get(2)->title === 'My First Idea';
            });
    }

    /** @test */
    public function spam_comments_filter_works()
    {
        $user = User::factory()->admin()->create();
        
        $ideaOne = Idea::factory()->create([
            'title' => 'My First Idea',
        ]);
        $ideaTwo = Idea::factory()->create([
            'title' => 'My Second Idea',
        ]);
        $ideaThree = Idea::factory()->create([
            'title' => 'My Third Idea',
        ]);
        Idea::factory()->create();

        Comment::factory()->create([
            'idea_id' => $ideaOne->id,
            'spam_reports' => 1,
        ]);
        Comment::factory()->create([
            'idea_id' => $ideaTwo->id,
            'spam_reports' => 3,
        ]);
        Comment::factory()->create([
            'idea_id' => $ideaThree->id,
            'spam_reports' => 2,
        ]);

        Livewire::actingAs($user)
            ->test(IdeasIndex::class)
            ->set('filter', 'Spam Comments')
            ->assertViewHas('ideas', function ($ideas) {
                return $ideas->count() === 3
                    && $ideas->first()->title === 'My First Idea'
                    && $ideas->get(1)->title === 'My Second Idea'
                    && $ideas->get(2)->title === 'My Third Idea';
            });
    }
}
