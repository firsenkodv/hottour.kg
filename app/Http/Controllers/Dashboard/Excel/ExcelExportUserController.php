<?php
namespace App\Http\Controllers\Dashboard\Excel;
use App\Exports\AdminExport;
use App\Exports\AllUsersExport;
use App\Exports\ManagerExport;
use App\Exports\RopExport;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use OpenSpout\Common\Entity\Style\Style;
use Rap2hpoutre\FastExcel\FastExcel;

class ExcelExportUserController extends Controller
{
    public function export_user(Request $request)
    {


        if(!$request->func) {
            abort(404);
        }



       // $path = public_path('storage/user_export/');
          $path = Storage::disk('userexport')->path('');

        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }



        if (isset($request->func)) {
            if($request->func == 'allUsers') {
                Excel::store(new AllUsersExport, $request->func . date('d.m.Y') . '.xlsx', 'userexport');
            }
            if($request->func == 'Users') {
                Excel::store(new UsersExport, $request->func . date('d.m.Y') . '.xlsx', 'userexport');
            }
            if($request->func == 'Managers') {
                Excel::store(new ManagerExport, $request->func . date('d.m.Y') . '.xlsx', 'userexport');
            }
            if($request->func == 'Rops') {
                Excel::store(new RopExport, $request->func . date('d.m.Y') . '.xlsx', 'userexport');
            }
            if($request->func == 'Admins') {
                Excel::store(new AdminExport, $request->func . date('d.m.Y') . '.xlsx', 'userexport');
            }
        }

        /**
         * возвращаем назад в браузер
         */

        return response()->json([
            'func' => $request->func,

        ]);

    }

}
