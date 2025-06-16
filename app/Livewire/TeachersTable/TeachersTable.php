<?php

namespace App\Livewire\TeachersTable;

use App\Models\User;
use Livewire\Component;

class TeachersTable extends Component
{
    public function render()
    {
        $users = User::role('teacher')->paginate(10);
        return view('livewire.teachers-table.teachers-table', compact('users'));
    }
}
