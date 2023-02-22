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

    public function vote()
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        if ($this->has_voted) {
            $this->idea->removeVote(auth()->user());
            $this->votes_count--;
            $this->has_voted = false;
        } else {
            $this->idea->vote(auth()->user());
            $this->votes_count++;
            $this->has_voted = true;
        }
    }

    public function render()
    {
        return view('livewire.idea-show');
    }
}
