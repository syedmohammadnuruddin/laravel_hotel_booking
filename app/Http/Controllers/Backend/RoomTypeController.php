<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function roomTypeList(){
        $allData = RoomType::orderBy('id','desc')->get();
        return view('backend.allroom.roomtype.view_roomtype', compact('allData'));
    }

    public function addRoomType(){
        return view('backend.allroom.roomtype.add_roomtype');
    }

    public function storeRoomType(Request $request){
        $roomtype_id = RoomType::insertGetId([
            'name'=>$request->name,
            'created_at'=> Carbon::now()
        ]);

        Room::insert([
            'roomtype_id'=>$roomtype_id,
        ]);

        $notification = array(
            'message'=> 'Room Type Inserted Successfully',
            'alert-type'=>'success'
        );

        return redirect()->route('room.type.list')->with($notification);
    }
}
