<?php

namespace Tests\Feature;

use App\Models\Category;
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
        $category_one = Category::factory()->create(['name' => 'Category 1']);
        $category_two = Category::factory()->create(['name' => 'Category 2']);

        $idea_one = Idea::factory()->create([
            'title' => 'My First Idea',
            'category_id' => $category_one->id,
            'description' => 'Description of my first idea.',
        ]);

        $idea_two = Idea::factory()->create([
            'title' => 'My Second Idea',
            'category_id' => $category_two->id,
            'description' => 'Description of my second idea.',
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee($idea_one->title);
        $response->assertSee($idea_one->description);
        $response->assertSee($category_one->name);
        $response->assertSee($idea_two->title);
        $response->assertSee($idea_two->description);
        $response->assertSee($category_two->name);
    }

    /** @test */
    public function single_idea_shows_correctly_on_the_show_page()
    {
        $category = Category::factory()->create(['name' => 'Category 1']);

        $idea = Idea::factory()->create([
            'title' => 'My First Idea',
            'category_id' => $category->id,
            'description' => 'Description of my first idea.',
        ]);

        $response = $this->get(route('idea.show', $idea));

        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertSee($category->name);
    }

    /** @test */
    public function ideas_pagination_works()
    {
        Idea::factory(Idea::PAGINATION_COUNT + 1)->create([
            'category_id' => Category::factory(),
        ]);

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
            'category_id' => Category::factory(),
            'description' => 'Description of my first idea.',
        ]);

        $idea_two = Idea::factory()->create([
            'title' => 'My First Idea',
            'category_id' => Category::factory(),
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
