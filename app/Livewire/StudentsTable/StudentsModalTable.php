<?php

namespace App\Livewire\StudentsTable;

use App\Models\Classroom;
use App\Models\ClassroomUser;
use Livewire\Component;
use Livewire\WithPagination;

class StudentsModalTable extends Component
{
    use WithPagination;
    public $searchStudent = '';
    public $classroomId = '';
    public $classroom;

    public function removeStudent($studentId)
    {
        if (ClassroomUser::where('user_id', $studentId)->where('classroom_id', $this->classroomId)->delete()) {
            $this->dispatch('notification', message: 'Student Removed!', success: true);
        } else {
            $this->dispatch('notification', message: 'Error Removing Student!', success: false);
        }
    }
    public function updatingSearchStudent()
    {
        $this->resetPage();
    }
    public function render()
    {
        $this->classroom = Classroom::findOrFail($this->classroomId);
        $students = $this->classroom
            ->students()
            ->where(function ($query) {
                $query->where('name', 'LIKE', '%' . $this->searchStudent . '%')->orWhere('email', 'LIKE', '%' . $this->searchStudent . '%');
            })
            ->where('users.id', '!=', $this->classroom->instructor_id)
            ->paginate(5);
        return view('livewire.students-table.students-modal-table', compact('students'));
    }
}
