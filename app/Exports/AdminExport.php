<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AdminExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles
{

    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $users = User::all();


        foreach ($users as $k => $user) {
            if ($user->user_role_id == 2) { // 2 = админ
                $exp[$k]['id'] = $user->id;
                $exp[$k]['name'] = $user->name;
                $exp[$k]['email'] = $user->email;
                $exp[$k]['phone'] = $user->phone;
                $exp[$k]['created_at'] = rusdate3($user->created_at);
                $exp[$k]['birthdate'] = rusbirthdate($user->birthdate);
                $exp[$k]['bonus'] = $user->bonus;
                $exp[$k]['ball'] = $user->ball;
                $exp[$k]['cashback'] = $user->cashback;

            }
        }
        $list = collect($exp);
        return $list;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Имя',
            'Email',
            'Телефон',
            'Дата создания',
            'День рождения',
            'Бонусы',
            'Баллы',
            'Кэшбек',

        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'EF533F']]],
        ];
    }
}
