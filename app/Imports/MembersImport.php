<?php

namespace App\Imports;

use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MembersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(!Member::where('student_ID', '=', @$row['student_id'])->exists()) {
            return new Member([
                'name' => @$row['name'],
                'student_ID' => @$row['student_id'],
                'join_year' => @$row['join_year'],
                'password' => Hash::make(@$row['password']),
                'title' => 9,
            ]);
        }

    }
    public function headingRow(): int
    {
        return 1;
    }
}
