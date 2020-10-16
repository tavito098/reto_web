<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Folder;

class FolderController extends Controller
{
    public function index()
    {
        $folders = Folder::where('parent_route', null)->get();
        return response()->json($folders);
    }

    public function store(Request $request)
    {
        $folder = Folder::create([
            'name' => $request->name, 
            'current_route' => $request->currentRoute, 
            'parent_route' => $request->parentRoute,
        ]);
        return response()->json($folder);
    }

    public function show($id)
    {
        $folder = Folder::where('id', $id)->first();
        $folders = Folder::where('parent_route', $folder->current_route)->get();
        return response()->json($folders);
    }

    public function update(Request $request, $id) {
        $folder = Folder::where('id', $id)->update([
            'name' => $request->name
        ]);
        return response()->json($folder);
    }

    public function destroy($id) {
        $folder = Folder::where('id', $id)->first();
        $folder->delete();
        $folders = Folder::where('parent_route', $folder->current_route)->get();
        if($folders->count() > 0)
        {
            foreach($folders as $folder)
            {
                Folder::where('id', $folder->id)->delete();
            }
        }
        return response()->json($folders);
    }
}
