<?php

namespace App\Livewire\Classroom;

use App\Models\Message;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Events\MessageSent;
use Livewire\WithPagination;
use App\Models\ClassroomUser;

class Classroom extends Component
{
    use WithPagination;
    public $search = '';
    public $searchStudent = '';
    public $course;
    public $section;
    public $students;
    public $classCode;
    public $listeners = ['$refresh'];

    //Classroom
    public function joinClassroom()
    {
        $user = auth()->user();
        if (!$user->hasRole('student')) {
            $this->dispatch('notification', message: 'Not a registered user. Contact Management!', success: false);
        }
        if ($this->classCode) {
            $currentUser_id = auth()->id();
            $classroom = \App\Models\Classroom::where('code', $this->classCode)->first();
            if ($classroom) {
                $alreadyJoined = ClassroomUser::where('user_id', $currentUser_id)->where('classroom_id', $classroom->id)->exists();
                if ($classroom->instructor_id == $currentUser_id || $alreadyJoined) {
                    $this->dispatch('notification', message: 'Class already joined!', success: false);
                } else {
                    ClassroomUser::create(['user_id' => $currentUser_id, 'classroom_id' => $classroom->id]);
                    $this->dispatch('notification', message: 'Joined classroom successfully!', success: true);
                }
            } else {
                $this->dispatch('notification', message: 'Classroom does not exist!', success: false);
            }
        } else {
            $this->dispatch('notification', message: 'Enter a code!', success: false);
        }
    }
    public function deleteClassroom($classroomId)
    {
        $classroom = \App\Models\Classroom::findOrFail($classroomId);
        $classroom->delete();
    }
    public function createClassroom()
    {
        if ($this->course != null && $this->section != null) {
            $code = '';
            do {
                $code = Str::random(5);
            } while (\App\Models\Classroom::where('code', $code)->exists());
            $classroom = \App\Models\Classroom::create([
                'course' => $this->course,
                'section' => $this->section,
                'code' => $code,
                'instructor_id' => auth()->user()->id,
            ]);
            ClassroomUser::create(['user_id' => auth()->user()->id, 'classroom_id' => $classroom->id]);
        }
    }

    //Searching
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingSearchStudent()
    {
        $this->resetPage();
    }
    public function render()
    {
        $classrooms = null;
        if (auth()->user()->hasRole('admin')) {
            $classrooms = \App\Models\Classroom::query()
                ->where(function ($query) {
                    $query->where('course', 'LIKE', '%' . $this->search . '%')->orWhere('section', 'LIKE', '%' . $this->search . '%');
                })
                ->with(['students', 'messages', 'instructor'])
                ->paginate(5);
        } else {
            $classrooms = auth()
                ->user()
                ->classrooms()
                ->where(function ($query) {
                    $query->where('course', 'LIKE', '%' . $this->search . '%')->orWhere('section', 'LIKE', '%' . $this->search . '%');
                })
                ->with(['students', 'messages', 'instructor'])
                ->paginate(5);
        }
        return view('livewire.classroom.classroom', compact('classrooms'));
    }
}
