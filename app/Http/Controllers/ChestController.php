<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessChest;
use App\Models\Chest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\isEmpty;
use App\Models\File;
use Intervention\Image\ImageManagerStatic as Image;

class ChestController extends Controller
{
    public function show(Request $request) {
        return view('sharing')->with(['chest' => Chest::getChestByIpAddress($request->ip())]);
    }

    public function update(Request $request) {
        logger($request);
        $data = $request->validate([
            'text' => 'string|nullable',
        ]);
        $chest = null;
        if(is_null(Chest::getChestByIpAddress($request->ip()))) {
            $chest = new Chest([
               'ip_address' => $request->ip(),
               'text' => array_key_exists('text', $data) ? $data['text'] : null
            ]);
        } else {
            $chest = Chest::getChestByIpAddress($request->ip());
            if(array_key_exists('text', $data)) {
                $chest->setText($data['text']);
            }
        }
        $chest->save();
        if($request->hasFile('file')) {
            logger(!is_dir(storage_path(rtrim($request->ip(),'.'))));
            $ipDirectory = rtrim($request->ip(),'.');
            if(!is_dir(storage_path($ipDirectory))) {
                Storage::disk('local')->makeDirectory(rtrim($request->ip(),'.'));
            }
            $fileName =  explode('.', $request->file('file')->getClientOriginalName())[0];
            $fileExtension = $request->file('file')->getClientOriginalExtension();
            if(!Storage::exists($ipDirectory . '/' . $fileName . '.' . $fileExtension)) {
                Storage::put($ipDirectory . '/' . $fileName . '.' . $fileExtension,
                    file_get_contents($request->file('file')));
            } else {
                $temporaryName = $fileName;
                for($i = 1; Storage::exists($ipDirectory . '/' . $temporaryName . '.' . $fileExtension); $i++) {
                   $temporaryName = $fileName . '(' . $i . ')';
                }
                $fileName = $temporaryName;
                Storage::put($ipDirectory . '/' . $fileName . '.' . $fileExtension,
                    file_get_contents($request->file('file')));
            }
            $file = new File([
                'file_path' => $fileName . '.' . $fileExtension,
                'chest_id' => $chest->getId()
            ]);
            $file->save();
        }
        dispatch(new ProcessChest($chest));
        return response(["chest-id" => $chest->getid()]);
    }

    public function getFile(Request $request, $fileName)
    {
        if(File::hasPermission($request->ip(), $fileName)) {
            return response()->file(storage_path('app/' . rtrim($request->ip(),'.') . '/' . $fileName));
        } else {
            return abort(403, 'You shall not see this, little hacker.');
        }
    }

    public function getThumbnail(Request $request, $fileName) {
        if(File::hasPermission($request->ip(), $fileName)) {
            if(in_array(strrchr($fileName, '.'), ['.jpg', '.jpeg', '.png'])) {
                Image::configure(array('driver' => 'imagick'));
                $img = Image::make(storage_path('app/' . rtrim($request->ip(), '.') . '/' . $fileName));
                $img->fit(120);
                return $img->response();
            } else {
                $img = Image::make(storage_path('app/saved_file.png'));
                $img->fit(120);
                return $img->response();
            }
        } else {
            return abort(403, 'You shall not see this, little hacker.');
        }
    }

    public function delete(Request $request) {
        logger('here i am');
        try {
            Chest::getChestByIpAddress($request->ip())->delete();
        } catch (\Exception $e) {
            //unhandled error
        }
        Storage::deleteDirectory($request->ip());
        return response('200');
    }
}
