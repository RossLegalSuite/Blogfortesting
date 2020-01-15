<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class MatterController extends Controller
{
    public function GetMatter(Request $request)
    {

        $query = DB::connection('userdb')
            ->table('Matter')
            ->select("RecordID")
            ->get()
            ->take(1);

        return $query;

        // $users = DB::select('select top 1 * from Matters');

        // return $users;

        // try {

        //     DB::connection("userdb")->getPdo();
        //     return 'success';
        // } catch (\Exception $e) {

        //     die("Could not connect to the database.  Please check your configuration. error:" . $e);

        // }

    }

}
