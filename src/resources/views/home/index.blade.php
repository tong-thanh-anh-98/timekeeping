@extends('layouts.main')

@section('title', 'Home')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <x-alert />
        <div class="card">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
<!-- Check In/Out Modal -->
<div class="modal fade" id="checkInOutModal" tabindex="-1" role="dialog" aria-labelledby="checkInOutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkInOutModalLabel">Check In / Check Out</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="checkInOutForm">
                    @csrf
                    <div class="mb-3 row">
                        <label for="type">Type:</label>
                        <select id="type" name="type" class="form-control">
                            <option value="checkin">Check In</option>
                            <option value="checkout">Check Out</option>
                        </select>
                    </div>
                    <div class="mb-3 row">
                        <label for="attendanceDate">Date of time:</label>
                        <div class="input-group date">
                            <input type="datetime-local" class="form-control" id="attendanceDate" name="date">
                            <x-error-feedback field="date" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var holidays = @json($holidays);

        // Hiển thị các ngày nghỉ lễ
        var events = holidays.map(holiday => {
            return {
                title: holiday.title,
                start: holiday.start,
                end: holiday.end,
                backgroundColor: holiday.color
            };
        });

        // Hiển thị các bản ghi checkin và checkout của user
        var timesheetEvents = @json($timesheets).map(timesheet => {
            // Set màu sắc dựa trên trạng thái
            var color;
            if (timesheet.status === 'success') {
                color = 'green'; // Màu xanh lá cây
            } else if (timesheet.status === 'pending') {
                color = 'blue'; // Màu xanh dương
            } else if (timesheet.status === 'reject') {
                color = 'red'; // Màu đỏ
            }

            return {
                title: timesheet.type + ' (' + timesheet.status + ')',
                start: timesheet.date,
                backgroundColor: color
            };
        });

        // Kết hợp sự kiện lễ và timesheet
        events = events.concat(timesheetEvents);

        var calendar = new FullCalendar.Calendar(calendarEl, {
            height: 720,
            initialView: 'dayGridMonth',
            events: events,
            dateClick: function(info) {
                var selectedDate = info.dateStr;
                var now = new Date();

                // Get current date and time in Vietnam timezone
                var currentVietnamTime = new Date().toLocaleString('sv-SE', { timeZone: 'Asia/Ho_Chi_Minh' }).replace(' ', 'T');
                var currentDateVietnam = now.toISOString().split('T')[0];

                if (selectedDate === currentDateVietnam) {
                    $('#attendanceDate').val(currentVietnamTime).prop('readonly', true);
                } else {
                    $('#attendanceDate').val(selectedDate + '').prop('readonly', false);
                }

                $('#checkInOutModal').modal('show');
            }
        });

        calendar.render();

        // Handle form submission via AJAX
        $('#checkInOutForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route("home.store") }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        // alert('Failed to record attendance.');

                        // Reset error messages
                        $('x-error-feedback[field="date"]').html('');

                        // Hiển thị lỗi
                        if (response.errors) {
                            if (response.errors.date) {
                                $('x-error-feedback[field="date"]').html(response.errors.date[0]);
                            }
                        }
                        alert('Failed to record attendance.');
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        console.log(xhr.responseJSON.errors); // Xem chi tiết lỗi trong console
                        if (xhr.responseJSON.errors.date) {
                            $('x-error-feedback[field="date"]').html(xhr.responseJSON.errors.date[0]);
                        }
                    } else {
                        alert('Error: ' + xhr.responseText);
                    }
                }
                // error: function(xhr, status, error) {
                //     alert('Error: ' + xhr.responseText);
                // }
            });
        });
    });
</script>
@endsection