<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\AreaModel;
use App\Models\LocationModel;
use App\Models\ParkingSlotModel;
use Illuminate\Http\Request;
use App\Models\BookingModel;
use Carbon;
use DataTables;

class BookingController extends Controller
{
    private $request;

    function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    function index(){
        $page = $this->pageDetails('manage');
        return view('booking/booking-list',compact('page'));
    }

    public function create($id = null){
        $locations = LocationModel::all();
        $areas = AreaModel::all();
        $slots = ParkingSlotModel::all();
        $dataSource = [
            'locations'=>  $locations,
            'areas'=>  $areas,
            'slots'=>  $slots,
            'routes'=>[ 'fetch_booking'=>route('api_fetch_booking') ]
        ];
        if ($id) {
            $booking = BookingModel::find($id);
        } else {
            $booking = new BookingModel;
        }
        \JavaScript::put($dataSource);
        $page = $this->pageDetails($booking->id ? 'edit' : 'add');
        return view('booking/booking-form', compact('booking','page','dataSource'));
    }

    public function getParkingSlotsByDuration(){
        try{
            $data = $this->request->all();
            $bookings = BookingModel::getTimeSlotBookings($data)->get();
            return response()->json([
                'status'=>true,
                'data'=>$bookings,
                'message'=>''
            ],200);
        }catch(Exception $e){
            return response()->json([
                'status'=>false,
                'data'=>null,
                'message'=>$e->getMessage()
            ],200);
        }
    }

    private function pageDetails($action)
    {
        if ($action == "add") {
            return [
                'action'=>'add',
                'successMsg' => trans('booking.added'),
                'title' => trans('booking.add'),
                'icon'=>'<i class="icon-book-open"></i> '
            ];
        }else if ($action == "edit") {
            return [
                'action'=>'update',
                'successMsg' => trans('booking.updated'),
                'title' => trans('booking.edit'),
                'icon'=>'<i class="icon-book-open"></i> '
            ];
        }else if ($action == "manage") {
            return [
                'action'=>'manage',
                'successMsg' => trans('booking.updated'),
                'title' => trans('booking.manage'),
                'icon'=>'<i class="icon-notebook"></i> '
            ];
        }
    }

    function save(BookingRequest $request)
    {
        $data = $request->all();
        $payloadedData = [
          'booking_date'=> Carbon\Carbon::parse($data['booking_date_submit'])->format('Y-m-d'),
          'start_time'=> Carbon\Carbon::parse($data['start_time'])->format('H:i:s'),
          'end_time'=> Carbon\Carbon::parse($data['end_time'])->format('H:i:s'),
          'user_id'=>$this->user->id,
          'booking_status'=>'booked',
        ];
        $data = array_merge($request->all(),$payloadedData);
        if (isset($data['id'])) {
            $booking = BookingModel::find($data['id']);

        } else {
            $booking = new BookingModel();
        }
        $booking->fill($data);
        $page = $this->pageDetails($booking->id ? 'edit' : 'add');
        if ($booking->save()) {
            //dd("sa");
            return redirect()->route('booking_manage')->with('success', $page['successMsg']);
        }
    }

    function getAllBookings(){
        $bookings = BookingModel::with('user','location','area','slot')->getAll($this->user)->orderBy('id','desc');
        return DataTables::eloquent($bookings)
            ->addColumn('action', function(BookingModel $bookingModel) {
                $template = '
                     <a data-toggle="tooltip" data-placement="left" title="Parking Details" class="primary cgi-tooltip" href="'. route('booking_details',[$bookingModel->id]) .'"><i  class="la la-file-text"></i></a>                         
                 ';
                return $template;
            })
            ->make(true);
    }

    function details($id){
        $booking = BookingModel::with('user','location','area','slot')->where('id',$id)->first();
        $dataSource = [
            'booking'=>  $booking,
            'routes'=>[ 'booking_cancel'=>route('api_booking_cancel') ]
        ];
        \JavaScript::put($dataSource);
        return view('booking/booking-details', compact('booking','dataSource'));
    }

    function cancelled($bookingID){
        try{
            $booking = BookingModel::find($bookingID);
            $booking->fill(['booking_status'=>'cancelled']);
            $result = $booking->update();

            if($result){
                return response()->json([
                    'status'=>true,
                    'data'=>$booking,
                    'message'=>trans('booking.cancelled')
                ],200);
            }else{
                return response()->json([
                    'status'=>false,
                    'data'=>null,
                    'message'=>'Something went wrong'
                ],200);
            }
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'data'=>null,
                'message'=>$e->getMessage()
            ],200);
        }

    }
}
