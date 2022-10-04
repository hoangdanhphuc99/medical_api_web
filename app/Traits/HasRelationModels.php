<?php

namespace App\Traits;
use App\Models\TermQuiz;
use App\Models\Chapter;
use App\Models\Department;
use App\Models\Lesson;
use App\Models\Transcript;
use App\Models\User;
trait HasRelationModels
{
    public function termQuizs()
    {
        return $this->hasMany(TermQuiz::class , "course_id" , "course_id");
    }
    public function lessons()
    {
        return $this->belongsTo(Lesson::class , "lesson_id" , "id");
    }
    public function lesson()
    {
        return $this->hasMany(Lesson::class , "chapter_id","chapter_id" );
    }
    public function chapters()
    {
        return $this->hasMany(Chapter::class , "course_id" , "course_id");
    }
    public function department()
    {
        return $this->belongsTo(Department::class , "department_id" , "id");
    }
    public function transcripts()
    {
        return $this->hasMany(Transcript::class ,  "id" , "termquiz_id");
    }
    public function userRole()
    {
        return $this->hasOne(UserPermisson::class,"role_id","id");
    }

    public function user()
    {
        return $this->belongsTo(User::class , "user_id" , "id");
    }

}
