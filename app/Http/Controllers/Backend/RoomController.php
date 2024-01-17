<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\MultiImage;
use App\Models\Room;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class RoomController extends Controller
{
    public function editRoom($id){
        $basic_facility = Facility::where("rooms_id",$id)->get();
        $multi_image = MultiImage::where("rooms_id",$id)->get();
        $editData = Room::findOrFail($id);
        return view("backend.allroom.rooms.edit_room", compact("editData", "basic_facility","multi_image"));
    }

    public function updateRoom(Request $request, $id){
        $room = Room::findOrFail($id);
        $room->roomtype_id = $room->roomtype_id;
        $room->total_adult = $request->total_adult;
        $room->total_child = $request->total_child;
        $room->room_capacity = $request->room_capacity;
        $room->price = $request->price;
        $room->size = $request->size;
        $room->view = $request->view;
        $room->bed_style = $request->bed_style;
        $room->discount = $request->discount;
        $room->short_desc = $request->short_desc;
        $room->description = $request->description;

        if($request->file('image')){
            @unlink(public_path('upload/rooming/'.$room->image));
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('image')->getClientOriginalExtension();
            $img = $manager->read($request->file('image'));
            $img = $img->resize(550,670);
            
            $img->toJpeg(80)->save(base_path('public/upload/rooming/'.$name_gen));
            $room['image'] = $name_gen;
        }
        $room->save();

        if($request->facility_name == NULL){
            $notification = array(
                'message'=> 'Sorry! You did not select any basic facility',
                'alert-type'=>'error'
            );
    
            return redirect()->back()->with($notification);
        }else{
            Facility::where('rooms_id', $id)->delete();
            $facilities = count($request->facility_name);
            for($i=0; $i<$facilities; $i++){
                $fcount = new Facility();
                $fcount->rooms_id = $room->id;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->save();
            }
        }

        if($room->save()){
            $files = $request->multi_image;
            if(!empty($files)){
                $subimage = MultiImage::where('rooms_id', $id)->get()->toArray();
                MultiImage::where('rooms_id', $id)->delete();
            }
            if(!empty($files)){
                foreach($files as $file){
                    $imgName = date('YmdHi').$file->getClientOriginalName();
                    $file->move('upload/rooming/multi-img/', $imgName);
                    $subimage['multi_image'] = $imgName;

                    $subimage = new MultiImage();
                    $subimage->rooms_id = $room->id;
                    $subimage->multi_image = $imgName;
                    $subimage->save();
                }
            }

        }
        $notification = array(
            'message'=> 'Room Updated Successfully',
            'alert-type'=>'success'
        );

        return redirect()->back()->with($notification);
    }

    public function multiImageDelete($id){
        $deleteData = MultiImage::where('id', $id)->first();
        if($deleteData){
            $imagePath = $deleteData->multi_image;
            if(file_exists($imagePath)){
                unlink( $imagePath );
                echo "Image Unlinked Successfully";
            }else{
                echo "Image does not exist";
            }
            MultiImage::where("id", $id)->delete();
        }
        $notification = array(
            'message'=> 'Multi Image Deleted Successfully',
            'alert-type'=>'success'
        );

        return redirect()->back()->with($notification);
    }
}
