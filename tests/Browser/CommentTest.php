<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CommentTest extends DuskTestCase
{    
    /**
     * @test
     */

    public function visitPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
            ->assertSee('Comments');
        });
    }
    
    /**
     * @test
     */
    public function addComment()
    {
        $name = 'Test name '.rand();
        $comment = 'This is a rand comment by test '.rand();
        $this->browse(function (Browser $browser) use ($name, $comment) {
            $response = $browser->visit('/')
            ->assertSee('Comments')
            ->assertSee('Name')
            ->type('name', $name)
            ->assertSee('My Comment')
            ->type('comment_text', $comment)
            ->assertSee('Submit')
            ->assertPathIs('/');

            $response->element('.submit')->submit();

        });
        sleep(1);
        $this->assertDatabaseHas('comments',['name'=>$name, 'comment_text' => $comment]);
    }
}
