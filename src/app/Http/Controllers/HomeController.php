<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use App\Models\Timesheet;
use App\Http\Requests\TimesheetRequest;

class HomeController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $holidays = Holiday::fetchHolidays();

        // Lấy dữ liệu timesheet để hiển thị lên calendar
        $timesheets = Timesheet::getAllUserTimesheets($userId);
        
        return view('home.index', compact('holidays', 'timesheets'));
    }

    public function store(TimesheetRequest $request)
    {
        $data = $request->validated();
        $userId = auth()->id(); // Lấy user_id từ người dùng đang đăng nhập
        $type = $data['type']; // 'checkin' hoặc 'checkout'

        // Lấy ngày của input date theo múi giờ Việt Nam
        $inputDate = \Carbon\Carbon::parse($data['date'])->format('Y-m-d');

        // Lấy thời gian hiện tại tại Việt Nam
        $currentDateTime = now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');

        // Kiểm tra xem đã có bản ghi checkin/checkout của user trong ngày input chưa
        $existingTimesheet = Timesheet::where('user_id', $userId)
            ->whereDate('date', $inputDate) // Kiểm tra theo ngày
            ->where('type', $type)          // Kiểm tra theo loại 'checkin' hoặc 'checkout'
            ->first();

        if ($existingTimesheet) {
            // Nếu đã có checkin hoặc checkout trong ngày, cập nhật bản ghi hiện tại
            $existingTimesheet->update([
                'date' => $data['date'], // Cập nhật thời gian với lần checkin/checkout cuối
                'status' => $inputDate === now('Asia/Ho_Chi_Minh')->format('Y-m-d') ? 'success' : 'pending', // Xử lý trạng thái
            ]);
        } else {
            // Nếu chưa có bản ghi nào, tạo một bản ghi mới
            $data['user_id'] = $userId;
            $data['status'] = $inputDate === now('Asia/Ho_Chi_Minh')->format('Y-m-d') ? 'success' : 'pending'; // Xử lý trạng thái

            // Tạo bản ghi mới trong bảng timesheets
            Timesheet::create($data);
        }

        return response()->json(['success' => true, 'message' => 'Recorded timesheet successfully.']);
    }
}
