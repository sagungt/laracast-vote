<?php

namespace App\Http\Livewire;

use App\Exceptions\DuplicateVoteException;
use App\Exceptions\VoteNotFoundException;
use App\Models\Idea;
use Livewire\Component;

class IdeaShow extends Component
{
    public $idea;
    public $votes_count;
    public $has_voted;

    protected $listeners = [
        'statusWasUpdated',
        'ideaWasUpdated',
        'ideaWasMarkedAsSpam',
        'ideaWasMarkedAsNotSpam',
        'commentWasAdded'
    ];

    public function commentWasAdded()
    {
        $this->idea->refresh();
    }

    public function ideaWasMarkedAsSpam()
    {
        $this->idea->refresh();
    }

    public function ideaWasMarkedAsNotSpam()
    {
        $this->idea->refresh();
    }

    public function statusWasUpdated()
    {
        $this->idea->refresh();
    }

    public function ideaWasUpdated()
    {
        $this->idea->refresh();
    }

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
            try {
                $this->idea->removeVote(auth()->user());
            } catch (VoteNotFoundException $e) {
                // do nothing
            }
            $this->votes_count--;
            $this->has_voted = false;
        } else {
            try {
                $this->idea->vote(auth()->user());
            } catch (DuplicateVoteException $e) {
                // do nothing
            }
            $this->votes_count++;
            $this->has_voted = true;
        }
    }

    public function render()
    {
        return view('livewire.idea-show');
    }
}
