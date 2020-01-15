<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class MatterController extends Controller
{
    public function GetMatter(Request $request)
    {

        $columns = '';
        $columns .= "CASE WHEN ISNULL(Matter.DateInstructed,0) = 0 THEN '' ELSE  CONVERT(VarChar(12),CAST(Matter.DateInstructed-36163 as DateTime),106) END AS Instructed";
        $columns .= ", CASE WHEN ISNULL(Matter.PrescriptionDate,0) = 0 THEN '' ELSE  CONVERT(VarChar(12),CAST(Matter.PrescriptionDate-36163 as DateTime),106) END AS PrescriptionDate";
        $columns .= ", Matter.FileRef";
        $columns .= ", Matter.TheirRef";
        $columns .= ", Matter.AlternateRef";
        $columns .= ", Matter.RecordID";
        $columns .= ", Matter.Description";
        $columns .= ", CASE WHEN ISNULL(Matter.FeeEstimate,0) = 0 THEN 0 ELSE Matter.FeeEstimate END AS FeeEstimate";
        $columns .= ", Matter.FileCabinet";
        $columns .= ", CASE WHEN Matter.Access = 'O' THEN 'Open to All' WHEN Matter.Access = 'V' THEN 'View Only' WHEN Matter.Access = 'R' THEN 'Restricted' ELSE 'Unspecified' END AS MatterAccess";
        $columns .= ", Employee.RecordID as EmployeeID";

        $columns .= ", CASE WHEN ISNULL(Employee.RecordID,0) = 0 THEN 'Not Set' ELSE Employee.Name END AS Employee";
        $columns .= ", CASE WHEN ISNULL(MatType.RecordID,0) = 0 THEN 'Not Set' ELSE MatType.Description END AS MatterType";
        $columns .= ", CASE WHEN ISNULL(Docgen.RecordID,0) = 0 THEN 'Not Set' ELSE Docgen.Description END AS DocumentSet";
        $columns .= ", CASE WHEN ISNULL(CostCentre.RecordID,0) = 0 THEN 'Not Set' ELSE CostCentre.Description END AS CostCentre";
        $columns .= ", CASE WHEN ISNULL(PlanOfAction.RecordID,0) = 0 THEN 'Not Set' ELSE PlanOfAction.Description END AS PlanOfAction";
        $columns .= ", CASE WHEN ISNULL(Branch.RecordID,0) = 0 THEN 'Not Set' ELSE Branch.Description END AS Branch";
// $columns .= ",CASE WHEN ISNULL(StageGroup.RecordID,0) = 0 THEN 'Not Set' ELSE StageGroup.Description END AS StageGroup";
        // $columns .= ",CASE WHEN ISNULL(Docscrn.RecordID,0) = 0 THEN 'Not Set' ELSE Docscrn.Description END AS ExtraScreen";
        // $columns .= ",CASE WHEN ISNULL(FeeSheet.RecordID,0) = 0 THEN 'Not Set' ELSE FeeSheet.Description END AS FeeSheet";
        // $columns .= ",CASE WHEN ISNULL(BondCause.RecordID,0) = 0 THEN 'Not Set' ELSE BondCause.Description END AS BondCause";

        $columns .= ",Party.Name as ClientName";
        $columns .= ",Party.MatterPrefix as ClientCode";

        $query = DB::connection('userdb')
            ->table('Matter')
            ->selectRaw($columns)
            ->leftJoin('Employee', 'Matter.EmployeeID', '=', 'Employee.RecordID')
            ->leftJoin('MatType', 'Matter.MatterTypeID', '=', 'MatType.RecordID')
            ->leftJoin('Docgen', 'Matter.DocgenID', '=', 'Docgen.RecordID')
            ->leftJoin('CostCentre', 'Matter.CostCentreID', '=', 'CostCentre.RecordID')
            ->leftJoin('Party', 'Matter.ClientID', '=', 'Party.RecordID')
            ->leftJoin('PlanOfAction', 'Matter.ToDoGroupID', '=', 'PlanOfAction.RecordID')
            ->leftJoin('Branch', 'Matter.BranchID', '=', 'Branch.RecordID')
            ->leftJoin('StageGroup', 'Matter.StageGroupID', '=', 'StageGroup.RecordID')
            ->leftJoin('Language', 'Matter.DocumentLanguageID', '=', 'Language.RecordID')
            ->leftJoin('ConveyData', 'Matter.RecordID', '=', 'ConveyData.MatterID')
            ->leftJoin('BondCause', 'ConveyData.BondCauseID', '=', 'BondCause.RecordID')
            ->leftJoin('FeeSheet', 'Matter.ClientFeeSheetID', '=', 'FeeSheet.RecordID')
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
