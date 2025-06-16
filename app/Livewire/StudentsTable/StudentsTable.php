<?php

namespace App\Livewire\StudentsTable;

use App\Models\User;
use Livewire\Component;

class StudentsTable extends Component
{
    public function render()
    {
        $users = User::role('student')->paginate(10);
        return view('livewire.students-table.students-table', compact('users'));
    }
}
