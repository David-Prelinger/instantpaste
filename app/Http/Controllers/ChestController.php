<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessChest;
use App\Models\Chest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
class ChestController extends Controller
{
    public function show(Request $request) {
        return view('sharing')->with(['chest' => Chest::getChestByIpAddress($request->ip())]);
    }

    public function update(Request $request) {
        $data = $request->validate([
            'text' => 'present|string|nullable',
        ]);
        $chest = null;
        if(is_null(Chest::getChestByIpAddress($request->ip()))) {
            $chest = new Chest([
               'ip_address' => $request->ip(),
               'text' => $data['text']
            ]);
            $chest->save();
        } else {
            $chest = Chest::getChestByIpAddress($request->ip());
            $chest->setText($data['text'] ?? '');
            $chest->save();
        }
        dispatch(new ProcessChest($chest));
    }
}
