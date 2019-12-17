<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Link;

class LinkController extends Controller
{

    //Get Links
    public function getLinks() {
        $links = Link::all();

        return response()->json($links, 201);
    }
    
    //Save Link
    public function saveLink(Request $request) {
        $user = auth('api')->user();

        //Validate
        $this->validate($request, [
            'link_type' => 'required',
            'link' => 'required',
        ]);

        //return response()->json($request->all());
        $link = Link::create([
            'user_id' => $user->id,
            'link_type' => $request->link_type,
            'link' => $request->link,
        ]);

        return response()->json($link, 201);
    }

    //Delete Link
    public function deleteLink($id) {
        $link = Link::findOrFail($id);
        $deleted = $link->delete();

        return response()->json($deleted, 200);
    }
}
