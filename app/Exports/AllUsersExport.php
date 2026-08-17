<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AllUsersExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles
{

    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $users  = User::all();


        foreach ($users as $k => $user) {

            $exp[$k]['id'] = $user->id;
            $exp[$k]['name'] = $user->name;
            $exp[$k]['email'] = $user->email;
            $exp[$k]['phone'] = $user->phone;
            $exp[$k]['created_at'] = rusdate3($user->created_at);
            $exp[$k]['avatar'] = $user->avatar;
            $exp[$k]['birthdate'] = rusbirthdate($user->birthdate);
            $exp[$k]['bonus'] = $user->bonus;
            $exp[$k]['ball'] = $user->ball;
            $exp[$k]['cashback'] = $user->cashback;
            $exp[$k]['manager'] = ($user->user_role_id == 1)?'manager':'-';
            $exp[$k]['rop'] = (isset($user->senior))?'rop':'-';
            $exp[$k]['admin'] = ($user->user_role_id == 2)?'admin':'-';

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
            'Аватар',
            'День рождения',
            'Бонусы',
            'Баллы',
            'Кэшбек',
            'Менеджер',
            'РОП',
            'Админ',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true, 'color' => ['rgb' => 'EF533F']]],
        ];
    }



}
