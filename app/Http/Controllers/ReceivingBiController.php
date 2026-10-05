<?php

namespace App\Http\Controllers;

use App\Services\SybaseService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ReceivingBiController extends Controller
{
    public function index(Request $request, SybaseService $sybaseService)
    {
        $search = trim($request->query('search', ''));

        $rows = collect($sybaseService->getReceivingBIData());

        if ($search !== '') {
            $rows = $rows->filter(fn($row) =>
                str_contains($row['trno'] ?? '', $search) ||
                str_contains($row['description'] ?? '', $search) ||
                str_contains($row['OrderNo'] ?? '', $search) ||
                str_contains($row['SuppName'] ?? '', $search)
            );
        }

        $rows = $rows->sortBy('trno')->values();

        $perPage = 25;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $data = new LengthAwarePaginator(
            $rows->forPage($page, $perPage),
            $rows->count(),
            $perPage,
            $page,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        return view('receiving_bi.index', compact('data', 'search'));
    }
}
