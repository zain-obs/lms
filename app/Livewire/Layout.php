<?php

namespace App\Livewire;

use App\Models\TabUser;
use Livewire\Component;
use App\Models\Classroom;
use App\Models\ClassroomUser;

class Layout extends Component
{
    public $tabs;
    public $activeTab = 'Dashboard';
    protected $queryString = ['activeTab'];
    protected $listeners = ['scanQrCode'];
    public function changeTab($tabName)
    {
        $this->activeTab = $tabName;
    }

    public function updateTabOrder($newTabs)
    {
        foreach ($newTabs as $newTabIndex => $newTab) {
            TabUser::where('user_id', auth()->id())
                ->where('tab_id', $newTabIndex + 1)
                ->update(['priority' => $newTab + 1]);
        }
        $this->mount();
    }

    public function mount()
    {
        $this->tabs = auth()->user()->tabs()->orderBy('tab_users.priority')->pluck('name')->toArray();
        if (!auth()->user()->can('view users') && in_array('Roles and Permissions', $this->tabs)) {
            $this->tabs = array_filter($this->tabs, function ($tab) {
                return $tab !== 'Roles and Permissions';
            });
        }
    }

    public function scanQrCode($code)
    {
        if (Classroom::where('code', $code)->exists()) {
            $user = auth()->user();
            if (!$user->hasRole('student')) {
                $this->dispatch('notification', message: 'Not a registered user. Contact Management!', success: false);
                return;
            }
            $currentUser_id = auth()->id();
            $classroom = Classroom::where('code', $code)->first();
            $alreadyJoined = ClassroomUser::where('user_id', $currentUser_id)->where('classroom_id', $classroom->id)->exists();
            if ($classroom->instructor_id == $currentUser_id || $alreadyJoined) {
                $this->dispatch('notification', message: 'Class already joined!', success: false);
            } else {
                ClassroomUser::create(['user_id' => $currentUser_id, 'classroom_id' => $classroom->id]);
                $this->dispatch('notification', message: 'Joined classroom successfully!', success: true);
                $this->dispatch('$refresh');
            }
        } else {
            $this->dispatch('notification', message: 'Invalid code!', success: false);
        }
    }

    public function render()
    {
        return view('livewire.layout')
            ->layout('layout.layout')
            ->section('content')
            ->with('title', $this->activeTab . ' | LMS');
    }
}
