<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;

class IdeaShow extends Component
{
    public $idea;
    public $votes_count;
    public $has_voted;

    public function mount(Idea $idea, $votes_count)
    {
        $this->idea = $idea;
        $this->votes_count = $votes_count;
        $this->has_voted = $idea->isVotedByUser(auth()->user());
    }

    public function render()
    {
        return view('livewire.idea-show');
    }
}
