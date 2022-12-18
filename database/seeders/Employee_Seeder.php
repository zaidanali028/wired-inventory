<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeeModel;

class Employee_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $emps=[
            [
                'id'=>1,
                'name'=>'employee 1',
            'email'=>'zaidu@gmail.com',
            'mobile'=>'0240040834',
            'address'=>'AK-317-1453',
            'salary'=>'5000',
            'photo'=>'emp.jpg',
            'national_id'=>'GHANA CARD(43430643)',
            'joining_date'=>'15/12/22'
        ],
        ['id'=>2,
            'name'=>'employee 2',
            'email'=>'zaidu@gmail.com',
            'mobile'=>'0240040834',
            'address'=>'AK-317-1453',
            'salary'=>'4500',
            'photo'=>'emp.jpg',
            'national_id'=>'GHANA CARD(43430643)',
            'joining_date'=>'15/12/22'
        ],
        ['id'=>3,
            'name'=>'employee 3',
            'email'=>'zaidu@gmail.com',
            'mobile'=>'0240040834',
            'address'=>'AK-317-1453',
            'salary'=>'4000',
            'photo'=>'emp.jpg',
            'national_id'=>'GHANA CARD(43430643)',
            'joining_date'=>'15/12/22'
        ],
        ['id'=>4,
            'name'=>'employee 4',
            'email'=>'zaidu@gmail.com',
            'mobile'=>'0240040834',
            'address'=>'AK-317-1453',
            'salary'=>'3500',
            'photo'=>'emp.jpg',
            'national_id'=>'GHANA CARD(43430643)',
            'joining_date'=>'15/12/22'
        ],

        ['id'=>5,
            'name'=>'employee 5',
            'email'=>'zaidu@gmail.com',
            'mobile'=>'0240040834',
            'address'=>'AK-317-1453',
            'salary'=>'2500',
            'photo'=>'emp.jpg',
            'national_id'=>'GHANA CARD(43430643)',
            'joining_date'=>'15/12/22'
        ],

        ];
        EmployeeModel::insert($emps);

    }
}
