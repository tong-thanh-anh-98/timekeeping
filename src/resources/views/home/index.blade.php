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
{{-- @include('home.timesheet-modal') --}}
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
                            <option value="">Choose</option>
                            <option value="checkin">Check In</option>
                            <option value="checkout">Check Out</option>
                        </select>
                        <x-error-feedback field="type" />
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

        // Hiển thị các ngày nghỉ lễ
        var holidays = @json($holidays);
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
                color = '#00DD00'; // Màu xanh lá cây
            } else if (timesheet.status === 'pending') {
                color = '#FFFF00'; // Màu vàng
            } else if (timesheet.status === 'reject') {
                color = '#FF0000'; // Màu đỏ
            }

            return {
                // title: timesheet.type + ' (' + timesheet.status + ')',
                title: timesheet.type,
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

            // Clear any previous error messages
            $('x-error-feedback[field="type"]').html('');
            $('x-error-feedback[field="date"]').html('');

            // Lấy giá trị các trường
            var type = $('#type').val();
            var date = $('#attendanceDate').val();

            // Kiểm tra xem các trường có được điền chưa
            if (!type) {
                $('x-error-feedback[field="type"]').html('Please select a type.');
                return;
            }
            if (!date) {
                $('x-error-feedback[field="date"]').html('Please select a date.');
                return;
            }

            $.ajax({
                url: '{{ route("home.store") }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert('Failed to record timesheet.');
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;

                        // Hiển thị lỗi cho từng trường
                        if (errors.type) {
                            $('x-error-feedback[field="type"]').html(errors.type[0]);
                        }
                        if (errors.date) {
                            $('x-error-feedback[field="date"]').html(errors.date[0]);
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