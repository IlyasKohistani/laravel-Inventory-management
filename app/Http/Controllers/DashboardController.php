<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Grant;
use App\Models\RequestTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories_stock = Category::select(['id', 'name'])->withCount([
            'products AS stock' => function ($query) {
                $query->select(DB::raw("SUM(quantity) as stock"))->where('status', 1);
            }
        ])->orderBy('stock', 'DESC')->take(4)->get();

        
        $categories_in_out = Category::select(['id', 'name'])
            ->with(['grant_transactions' => function ($query) {
                return $query->selectRaw(DB::raw("DATE(grants.created_at) date,SUM(grants.quantity) as total_quantity"))
                    ->where(
                        'grants.created_at',
                        '>=',
                        Carbon::now()->subDays(29)->toDateTimeString()
                    )
                    ->groupBy(['date', 'products.category_id']);
            }, 'request_transactions' => function ($query) {
                return $query->selectRaw(DB::raw("DATE(request_transactions.updated_at) date,SUM(request_transactions.quantity) as total_quantity"))
                    ->where(
                        'request_transactions.updated_at',
                        '>=',
                        Carbon::now()->subDays(29)->toDateTimeString()
                    )
                    ->where('request_transactions.status', 3)
                    ->groupBy(['date', 'products.category_id']);
            }])
            ->withCount([
                'products AS stock' => function ($query) {
                    $query->select(DB::raw("SUM(quantity) as stock"))->where('status', 1);
                }
            ])->orderBy('stock', 'DESC')->take(4)->get()->toArray();

        $stock_total_in = RequestTransaction::where('status', 3)->where(
            'created_at',
            '>=',
            Carbon::now()->subDays(30)->toDateTimeString()
        )->sum('quantity');
        $stock_total_out = Grant::where(
            'created_at',
            '>=',
            Carbon::now()->subDays(30)->toDateTimeString()
        )->sum('quantity');

        $last_year_in_array = RequestTransaction::select(DB::raw("MONTH(updated_at) month,SUM(quantity) as total_quantity"))
            ->where('status', 3)
            ->whereYear(
                'updated_at',
                '=',
                now()->year
            )
            ->groupBy('month')->get();

        $last_year_out_array = Grant::select(DB::raw("MONTH(updated_at) month,SUM(quantity) as total_quantity"))
            ->whereYear(
                'updated_at',
                '=',
                now()->year
            )
            ->groupBy('month')->get();


        $last_year_in_result = array_fill(0, 12, 0);
        $last_year_out_result = array_fill(0, 12, 0);
        foreach ($last_year_in_array as $value) {
            $last_year_in_result[$value->month - 1] = intval($value->total_quantity);
        }

        foreach ($last_year_out_array as $value) {
            $last_year_out_result[$value->month - 1] = intval($value->total_quantity);
        }


        $last_transaction_in = RequestTransaction::where('status', 3)
            ->select(['id', 'product_id', 'quantity', 'updated_at as date', DB::raw('"in" as type')])
            ->with('product:id,name,image')
            ->orderBy('updated_at', 'ASC')
            ->take(5)
            ->get();
        $last_transaction_out = Grant::select(['id', 'product_id', 'quantity', 'created_at as date', DB::raw('"out" as type')])
            ->with('product:id,name,image')
            ->orderBy('created_at', 'ASC')
            ->take(5)
            ->get();
        $last_transactions = $last_transaction_in->merge($last_transaction_out)->sortByDesc('date')->take(3);

        $data = [
            "categories_stock" => $categories_stock,
            "stock_in_per" => $stock_total_in,
            "stock_out_per" => $stock_total_out,
            "last_year_in" => $last_year_in_result,
            "last_year_out" => $last_year_out_result,
            "last_transactions" => $last_transactions,
            "categories_in_out" => $categories_in_out,
        ];
        return view('layouts.dashboard', $data);
    }
}
