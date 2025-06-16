<?php

namespace App\Livewire\ParentsTable;

use App\Models\User;
use Livewire\Component;

class ParentsTable extends Component
{
    public function render()
    {
        $users = User::role('student')->paginate(10);
        return view('livewire.parents-table.parents-table', compact('users'));
    }
}
