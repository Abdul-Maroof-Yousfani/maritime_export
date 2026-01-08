<div class="row">
    <form action="{{ route('secondinspection.store') }}" method="post"
          id="accommodiatiesProduct">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>PO No.</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="ins_no" readonly
                       id="ins_no" value="{{ $inspections->po_no }}"
                       class="form-control requiredField" />
            </div>


            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Inspection No:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="ins_no" readonly
                       id="ins_no" value="{{ $inspections->ins_no }}"
                       class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Date:</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="date" name="date" id="date" readonly
                       value="{{ $inspections->date }}"
                       class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Lot / Truck No.</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="truck_no" id="truck_no" readonly
                       value="{{ $inspections->truck_no }}"
                       class="form-control requiredField" />
            </div>
        </div>
        <div class="row" style="">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Variety/Product Description</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="product_description" readonly id="product_description"
                       value="{{ $inspections->product_description }}"
                       class="form-control requiredField" />
            </div>

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Name of Seller/Customer</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="ins_no" readonly
                       id="ins_no" value="{{ $inspections->customer_name }}"
                       class="form-control requiredField" />
            </div>


            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Number of Bags</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="number" name="no_of_bags" id="no_of_bags" readonly
                       value="{{ $inspections->no_of_bags }}"
                       class="form-control requiredField" />
            </div>

            {{--            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">--}}
            {{--                <label>PP Bags</label>--}}
            {{--                <span class="rflabelsteric"><strong>*</strong></span>--}}
            {{--                <select name="pp_bags_id" id="pp_bags_id"--}}
            {{--                        class="form-control requiredField select2 requiredField"--}}
            {{--                >--}}
            {{--                    <option value="">Select PP Bags</option>--}}
            {{--                    @foreach ($printingBags as $key => $y)--}}
            {{--                        <option value="{{ $y->id }}"--}}
            {{--                                {{ old('po_id') == $y->id ? 'selected' : '' }}>--}}
            {{--                            {{ $y->printing_bags }} - {{ $y->bag_weight }}</option>--}}
            {{--                    @endforeach--}}
            {{--                </select>--}}
            {{--            </div>--}}

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Jute Bags 100kg</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="number" name="no_of_bags"
                       id="jute_bags" readonly
                       value="{{ $inspections->no_of_bags }}"
                       class="form-control requiredField" />
            </div>
{{--            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">--}}
{{--                <label>Shipment Origin</label>--}}
{{--                <span class="rflabelsteric"><strong>*</strong></span>--}}
{{--                <input type="text" name="shipment_origin"--}}
{{--                       id="shipment_origin" readonly--}}
{{--                       value="{{ $inspections->shipment_origin }}"--}}
{{--                       class="form-control requiredField" />--}}
{{--            </div>--}}

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Bilty Number</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="bilty_no"
                       id="bilty_no" readonly
                       value="{{ $inspections->bilty_no }}"
                       class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Bilty Date</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="date" name="bilty_date" id="bilty_date" readonly
                       value="{{ $inspections->bilty_date }}"
                       class="form-control requiredField"  />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Consignee Weight (kg)</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="number" name="consignee_weight" readonly
                       id="consignee_weight"
                       value="{{ $inspections->consignee_weight }}"
                       class="form-control requiredField" />
            </div>
        </div>
        <div class="row">
          
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Vehicle Driver’s Name</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="driver_name"
                       id="driver_name" readonly
                       value="{{ $inspections->driver_name }}"
                       class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Vehicle Driver’s Number</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="driver_name"
                       id="driver_name" readonly
                       value="{{ $inspections->driver_number ?? '' }}"
                       class="form-control requiredField" />
            </div>

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Transporter Name</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="transporter_name"
                       id="transporter_name" readonly
                       value="{{ $inspections->transporter_name }}"
                       class="form-control requiredField" />
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="bg-primary" >
                            <th  class="bg-primary" style="width: 50%"  style="width: 20%;">
                                Particulars
                            </th>
                            <th class="bg-primary" >First Report</th>
                        </tr>
                        </thead>

                        <tbody id="AppnedHtml">
                        @if(count($checklists) != 0)
                            @foreach($checklists as $qc)
                                <tr>
                                    <th style="width: 50%" style="width: 20%;">
                                        {{ $qc->name}}
                                        <input type="hidden" value="{{$qc->id}}" name="checklist_id[]">
                                    </th>
                                    <th style="width: 50%" class="">
                                        {{$qc->comment}}
                                    </th>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <th style="width: 100%" >
                                    <div class="alert alert-warning">
                                        No record found
                                    </div>
                                </th>
                            </tr>


                        @endif
                        </tbody>


                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="bg-primary" >
                            <th width="25%" class="bg-primary" >PO Qty:</th>
                            <th width="25%"  class="bg-primary" >Balance Qty:</th>
                            <th width="25%"  class="bg-primary" >Received:</th>
                            <th width="25%"  class="bg-primary" >Rejected:</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>
                                <input type="number" readonly name="total_qty" value="{{$inspections->total_qty}}" class="form-control">
                            </th>
                            <th>
                                <input type="number" readonly name="balance_qty" value="{{$inspections->balance_qty}}"  class="form-control">
                            </th>
                            <th>
                                <input type="number" readonly name="recived_qty" value="{{$inspections->recived_qty}}"  class="form-control">
                            </th>
                            <th>
                                <input type="number"  readonly name="reject_qty" value="{{$inspections->reject_qty}}"  class="form-control">
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Analysed and Inspected By</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <input type="text" name="inspect_by"
                       id="inspect_by" readonly
                       required
                       value="{{ $inspections->inspect_by }}"
                       class="form-control requiredField" />
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="margin-top: 3%;">
                <label>Attachment </label>
                @if(!empty($inspections->attachment))
                    <a href="{{ asset('storage/' . $inspections->attachment) }}" 
                    class="btn btn-primary" 
                    download="{{ $inspections->attachment }}">
                    Download Attachment
                    </a>
                @else
                    <p>No attachment available</p>
                @endif  
            </div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label>Overall product status found satisfactory</label>
                <span class="rflabelsteric"><strong>*</strong></span>
                <label for="">
                    <input type="radio" name="satisfactory_status"
                           value="1"
                           checked
                           class="form-control requiredField" />
                    <span>Yes</span>
                </label>
                <label for="">
                    <input type="radio" name="satisfactory_status"
                           value="0"
                           class="form-control requiredField" />
                    <span>No</span>
                </label>
            </div>
        </div>
{{--        <div class="row">--}}
{{--            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">--}}
{{--                <label>Corrective Action (CAR)</label>--}}
{{--                <span class="rflabelsteric"><strong>*</strong></span><br>--}}
{{--                <label for="corrective_action_reject">--}}
{{--                    <input type="radio" name="corrective_action" id="corrective_action_reject"--}}
{{--                           value="1" checked required class="requiredField" />--}}
{{--                    <span>Reject</span>--}}
{{--                </label>--}}
{{--                <label for="corrective_action_use_as_is">--}}
{{--                    <input type="radio" name="corrective_action" id="corrective_action_use_as_is"--}}
{{--                           value="0" required class="requiredField" />--}}
{{--                    <span>Use as it is</span>--}}
{{--                </label>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="row">--}}
{{--            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
{{--                <label>Re-work Details / Action Taken</label>--}}
{{--                <textarea type="number" name="justification" readonly--}}
{{--                          id="justification"--}}
{{--                          class="form-control requiredField" >{{ $inspections->justification }}</textarea>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="row">--}}
{{--            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">--}}
{{--                <label>Action Raised By</label>--}}
{{--                <span class="rflabelsteric"><strong>*</strong></span>--}}
{{--                <input type="text" name="inspect_by"--}}
{{--                       id="inspect_by" readonly--}}
{{--                       required--}}
{{--                       value="{{ $inspections->created_by }}"--}}
{{--                       class="form-control requiredField" />--}}
{{--            </div>--}}
{{--            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">--}}
{{--                <label>Action Raised By</label>--}}
{{--                <span class="rflabelsteric"><strong>*</strong></span>--}}
{{--                <input type="text" name="inspect_by"--}}
{{--                       id="inspect_by" readonly--}}
{{--                       required--}}
{{--                       value="{{ $inspections->approved_by }}"--}}
{{--                       class="form-control requiredField" />--}}
{{--            </div>--}}
{{--        </div>--}}



        <hr>
{{--        <div class="row">--}}
{{--            <div--}}
{{--                    class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">--}}
{{--                --}}{{-- {{ Form::submit('Submit', ['class' => 'btn btn-success']) }} --}}
{{--                @if ($inspections->ins_status == 0)--}}
{{--                <button id="approveButton" type="button" class="btn btn-success">Approve</button>--}}
{{--                <button id="rejectButton" type="button" class="btn btn-warning">Reject</button>--}}
{{--                @endif--}}
{{--             --}}
{{--                --}}{{-- <button type="reset" id="reset"--}}
{{--                        class="btn btn-primary">Clear Form</button> --}}
{{--            </div>--}}
{{--        </div>--}}
    </form>
</div>


<script>
    function approveInspection(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to approve this inspection.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait while we process your request.',
                    didOpen: () => {
                        Swal.showLoading();
                        $.ajax({
                            url: '{{ url('/') }}' + '/arrival/approve/' + id,
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Approved!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    // Reload the page after the success message
                                    window.location.reload();
                                });
                            },
                            error: function(response) {
                                Swal.fire(
                                    'Error!',
                                    response.responseJSON.message,
                                    'error'
                                );
                            }
                        });
                    }
                });
            }
        });
    }

    function rejectInspection(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to reject this inspection.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reject it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait while we process your request.',
                    didOpen: () => {
                        Swal.showLoading();
                        $.ajax({
                            url: '{{ url('/') }}' + '/arrival/reject/' + id,
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Rejected!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    // Reload the page after the success message
                                    window.location.reload();
                                });
                            },
                            error: function(response) {
                                Swal.fire(
                                    'Error!',
                                    response.responseJSON.message,
                                    'error'
                                );
                            }
                        });
                    }
                });
            }
        });
    }

    // Add event listeners to buttons
    $(document).ready(function() {
        var inspectionId = {{$inspections->id}}; // Replace with the actual ID or fetch dynamically

        $('#approveButton').click(function() {
            approveInspection(inspectionId);
        });

        $('#rejectButton').click(function() {
            rejectInspection(inspectionId);
        });
    });
</script>