<?php

namespace Tests\Feature;

use App\Models\Idea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowIdeasTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function list_of_ideas_shows_on_main_page()
    {
        $idea_one = Idea::factory()->create([
            'title' => 'My First Idea',
            'description' => 'Description of my first idea.',
        ]);

        $idea_two = Idea::factory()->create([
            'title' => 'My Second Idea',
            'description' => 'Description of my second idea.',
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee($idea_one->title);
        $response->assertSee($idea_one->description);
        $response->assertSee($idea_two->title);
        $response->assertSee($idea_two->description);
    }

    /** @test */
    public function single_idea_shows_correctly_on_the_show_page()
    {
        $idea = Idea::factory()->create([
            'title' => 'My First Idea',
            'description' => 'Description of my first idea.',
        ]);

        $response = $this->get(route('idea.show', $idea));

        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
    }

    /** @test */
    public function ideas_pagination_works()
    {
        Idea::factory(Idea::PAGINATION_COUNT + 1)->create();

        $idea_one = Idea::find(1);
        $idea_one->title = 'My First Idea';
        $idea_one->save();

        $idea_eleven = Idea::find(Idea::PAGINATION_COUNT + 1);
        $idea_eleven->title = 'My Eleventh Idea';
        $idea_eleven->save();

        $response = $this->get('/');

        $response->assertSee($idea_one->title);
        $response->assertDontSee($idea_eleven->title);

        $response = $this->get('/?page=2');

        $response->assertSee($idea_eleven->title);
        $response->assertDontSee($idea_one->title);
    }

    /** @test */
    public function same_idea_title_different_slugs()
    {
        $idea_one = Idea::factory()->create([
            'title' => 'My First Idea',
            'description' => 'Description of my first idea.',
        ]);

        $idea_two = Idea::factory()->create([
            'title' => 'My First Idea',
            'description' => 'Another description of my first idea.',
        ]);

        $response = $this->get(route('idea.show', $idea_one));

        $response->assertSuccessful();
        $this->assertTrue(request()->path() === 'ideas/my-first-idea');

        $response = $this->get(route('idea.show', $idea_two));

        $response->assertSuccessful();
        $this->assertTrue(request()->path() === 'ideas/my-first-idea-2');
    }
}
