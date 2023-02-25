<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CommentNotifications extends Component
{
    const NOTIFIATION_TRESHOLD = 20;
    public $notifications;
    public $notificationCount;
    public $isLoading;

    protected $listeners = [
        'getNotifications',
    ];

    public function mount()
    {
        $this->notifications = collect([]);
        $this->isLoading = true;
        $this->getNotificationCount();
    }

    public function getNotificationCount()
    {
        $this->notificationCount = auth()->user()->unreadNotifications()->count();

        if ($this->notificationCount > self::NOTIFIATION_TRESHOLD) {
            $this->notificationCount = self::NOTIFIATION_TRESHOLD . '+';
        }
    }

    public function getNotifications()
    {
        $this->notifications = auth()
            ->user()
            ->unreadNotifications()
            ->latest()
            ->take(self::NOTIFIATION_TRESHOLD)
            ->get();

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.comment-notifications');
    }
}
