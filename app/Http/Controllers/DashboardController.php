<?php

namespace App\Http\Controllers;

use App\DataTables\AllReviewablesDataTable;

class DashboardController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock', 'formrepeater']);
        addJavascriptFile('assets/js/custom/users/add-personal-info.js');

        return view('pages/dashboards.index');
    }

    public function adminIndex(AllReviewablesDataTable $dataTable)
    {

        return $dataTable->render('pages/dashboards.adminIndex');
    }
}
