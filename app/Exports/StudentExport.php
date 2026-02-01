<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection, WithHeadings
{
    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }

    public function collection()
    {
        return collect($this->students)->map(function ($student) {
            return [
                'student_id' => $student->student_id,
                'roll' => $student->roll,
               
                'english_name' => $student->student->english_name,
                'bangla_name' => $student->student->bangla_name,
                 'father_name' => $student->student->father_name,
              
                'phone' => $student->user->phone,
              

                 'gender' => $student->student->gender,
                'religion_name' => $student->religion->religion_name,
                 'email' => $student->user->email,
                'enroll_status' => $student->enroll_status,

                'sessionyear_name' => $student->sessionyear->sessionyear_name,
              
                'programyear_name' => $student->programyear->programyear_name,
             
                'level_name' => $student->level->level_name,
             
               
                'faculty_name' => $student->faculty->faculty_name,
           
                'department_name' => $student->department->department_name,
          
                'section_name' => $student->section->section_name,

             
               

             
                'father_phone' => $student->student->father_phone,
                'mother_name' => $student->student->mother_name,
                'dob' => $student->student->dob,
                'registration' => $student->student->registration,
              
                'created_at' => $student->created_at->format('Y-m-d H:i:s'),


               'main_subject1_name' => $student->mainSubject1->subject_name ?? null,
             
                'main_subject2_name' => $student->mainSubject2->subject_name ?? null,
               
                'main_subject3_name' => $student->mainSubject3->subject_name ?? null,
              
                'additional_subject_name' => $student->additionalSubject->subject_name ?? null,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'student_id',
            'roll',
         
            'english_name',
            'bangla_name',
            'father_name',
           
            'phone',
         
             'gender',
            'religion_name',
             'email',
            'enroll_status',

            'sessionyear_name',
            'programyear_name',
      
            'level_name',
            'faculty_name',
          
            'department_name',
          
            'section_name',

        
            'father_phone',
            'mother_name',
            'dob',
            'registration',
          
            'created_at',

          
            'main_subject1_name',
         
            'main_subject2_name',
         
            'main_subject3_name',
            'additional_subject_name',

           
        ];
    }
}

