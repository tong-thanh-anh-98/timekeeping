<!-- Check In/Out Modal -->
<div class="modal fade" id="checkInOutModal" tabindex="-1" role="dialog" aria-labelledby="checkInOutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkInOutModalLabel">Check In / Check Out</h5>
                <button type="button" class="close btn btn-sm" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="checkInOutForm">
                     <div class="mb-3 row">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="checkin">Check In</option>
                            <option value="checkout">Check Out</option>
                        </select>
                    </div>
                     <div class="mb-3 row">
                        <label for="attendanceDate">Date:</label>
                        <div class="input-group date">
                            <input type="datetime-local" class="form-control" id="attendanceDate" name="date">
                        </div>
                        <x-error-feedback field="date" />
                    </div>
                     <div class="mb-3 row">
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
