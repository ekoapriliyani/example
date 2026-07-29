<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    protected array $modules = [
        'wm' => [
            'label' => 'Wiremesh (WM)',
            'model' => \App\Models\InspeksiWm::class,
            'wip_relation' => 'inspeksiWmWip',
            'resource_prefix' => 'inspeksi_wm',
            'toggle_route' => 'inspeksi-wm.toggle',
        ],
        'wf' => [
            'label' => 'Wiremesh Fence (WF)',
            'model' => \App\Models\InspeksiWf::class,
            'wip_relation' => 'inspeksiWfWip',
            'resource_prefix' => 'inspeksi_wf',
            'toggle_route' => 'inspeksi-wf.toggle',
        ],
        'ct' => [
            'label' => 'Concertina (CT)',
            'model' => \App\Models\InspeksiCt::class,
            'wip_relation' => 'inspeksiCtWip',
            'resource_prefix' => 'inspeksi_ct',
            'toggle_route' => 'inspeksi-ct.toggle',
        ],
        'fencing' => [
            'label' => 'Fencing',
            'model' => \App\Models\InspeksiFencing::class,
            'wip_relation' => 'inspeksiFencingWip',
            'resource_prefix' => 'inspeksi_fencing',
            'toggle_route' => 'inspeksi-fencing.toggle',
        ],
        'pvc' => [
            'label' => 'PVC',
            'model' => \App\Models\InspeksiPvc::class,
            'wip_relation' => 'inspeksiPvcWip',
            'resource_prefix' => 'inspeksi_pvc',
            'toggle_route' => 'inspeksi-pvc.toggle',
        ],
        'chainlink' => [
            'label' => 'Chainlink',
            'model' => \App\Models\InspeksiChainlink::class,
            'wip_relation' => 'inspeksiChainlinkWip',
            'resource_prefix' => 'inspeksi_chainlink',
            'toggle_route' => 'inspeksi-chainlink.toggle',
        ],
        'kawat_duri' => [
            'label' => 'Kawat Duri',
            'model' => \App\Models\InspeksiKawatDuri::class,
            'wip_relation' => 'inspeksiKawatDuriWip',
            'resource_prefix' => 'inspeksi_kawat_duri',
            'toggle_route' => 'inspeksi-kawat-duri.toggle',
        ],
        'slitting' => [
            'label' => 'Slitting',
            'model' => \App\Models\InspeksiSlitting::class,
            'wip_relation' => 'inspeksiSlittingWip',
            'resource_prefix' => 'inspeksi_slitting',
            'toggle_route' => 'inspeksi-slitting.toggle',
        ],
        'pound' => [
            'label' => 'Pound',
            'model' => \App\Models\InspeksiPound::class,
            'wip_relation' => 'inspeksiPoundWip',
            'resource_prefix' => 'inspeksi_pound',
            'toggle_route' => 'inspeksi-pound.toggle',
        ],
        'klip' => [
            'label' => 'Klip',
            'model' => \App\Models\InspeksiKlip::class,
            'wip_relation' => 'inspeksiKlipWip',
            'resource_prefix' => 'inspeksi_klip',
            'toggle_route' => 'inspeksi-klip.toggle',
        ],
        'shearing' => [
            'label' => 'Shearing',
            'model' => \App\Models\InspeksiShearing::class,
            'wip_relation' => 'inspeksiShearingWip',
            'resource_prefix' => 'inspeksi_shearing',
            'toggle_route' => 'inspeksi-shearing.toggle',
        ],
        'gabionframe' => [
            'label' => 'Gabion Frame',
            'model' => \App\Models\InspeksiGabionframe::class,
            'wip_relation' => 'inspeksiGabionframeWip',
            'resource_prefix' => 'inspeksi_gabionframe',
            'toggle_route' => 'inspeksi-gabionframe.toggle',
        ],
        'gabionanyam' => [
            'label' => 'Gabion Anyam',
            'model' => \App\Models\InspeksiGabionanyam::class,
            'wip_relation' => 'inspeksiGabionanyamWip',
            'resource_prefix' => 'inspeksi_gabionanyam',
            'toggle_route' => 'inspeksi-gabionanyam.toggle',
        ],
        'gabionrakit' => [
            'label' => 'Gabion Rakit',
            'model' => \App\Models\InspeksiGabionrakit::class,
            'wip_relation' => 'inspeksiGabionrakitWip',
            'resource_prefix' => 'inspeksi_gabionrakit',
            'toggle_route' => 'inspeksi-gabionrakit.toggle',
        ],
        'razorpacking' => [
            'label' => 'Razor Packing',
            'model' => \App\Models\InspeksiRazorpacking::class,
            'wip_relation' => 'inspeksiRazorpackingFg',
            'resource_prefix' => 'inspeksi_razorpacking',
            'toggle_route' => 'inspeksi-razorpacking.toggle',
        ],
        'gabionpacking' => [
            'label' => 'Gabion Packing',
            'model' => \App\Models\InspeksiGabionpacking::class,
            'wip_relation' => 'inspeksiGabionpackingFg',
            'resource_prefix' => 'inspeksi_gabionpacking',
            'toggle_route' => 'inspeksi-gabionpacking.toggle',
        ],
    ];

    public function index(Request $request)
    {
        $module = $request->query('module', 'wm');

        if (!isset($this->modules[$module])) {
            $module = 'wm';
        }

        $config = $this->modules[$module];
        $modelClass = $config['model'];

        $totalInspeksi = $modelClass::count();
        $pendingApproval = $modelClass::where('approval_status', 'PENDING')->count();
        $approved = $modelClass::where('approval_status', 'APPROVED')->count();

        $pendingList = $modelClass::with($config['wip_relation'] . '.user')
            ->where('approval_status', 'PENDING')
            ->orderBy('tanggal', 'desc')
            ->get();

        $modules = collect($this->modules)->map(fn ($m, $key) => [
            'key' => $key,
            'label' => $m['label'],
        ]);

        return view('dashboard', compact(
            'module', 'modules', 'config', 'totalInspeksi', 'pendingApproval', 'approved', 'pendingList'
        ));
    }

    public function syncPro()
    {
        $cmd = sprintf('php %s sync:pro-reference > /dev/null 2>&1 &', base_path('artisan'));
        exec($cmd);

        Cache::forever('last_sync_at', now()->toIso8601String());

        return back()->with('success', 'Sync PRO Reference sedang diproses di background.');
    }
}
