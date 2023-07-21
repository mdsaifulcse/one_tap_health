
<div class="modal-header">
    <h4 class="modal-title">Patient Details</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
    <div class="row justify-content-center">
        <div class="col-md-12 ">

            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-block table-border-style">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered center_table" id="my_table">
                            <tbody>
                            <tr>
                                <td width="15">Patient ID</td>
                                <td>{{$patient->patient_no}}</td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>{{$patient->name}}</td>
                            </tr>
                            <tr>
                                <td>Mobile</td>
                                <td>{{$patient->mobile??'N/A'}}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{$patient->email??'N/A'}}</td>
                            </tr>
                            <tr>
                                <td>Age </td>
                                <td>{{$patient->age??'N/A'}}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>{{$patient->address??'N/A'}}</td>
                            </tr>
                            <tr>
                                <td>Details</td>
                                <td>{{$patient->details??'N/A'}}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td> @if($patient->status==\App\Models\Patient::ACTIVE)
                                        <button class="btn btn-success btn-sm">Active</button>
                                    @else
                                        <button class="btn btn-danger btn-sm">Inactive</button>
                                    @endif</td>
                            </tr>
                            <tr>
                                <td>Created At</td>
                                <td>{{date('M-d-Y',strtotime($patient->created_at))}}</td>
                            </tr>
                            <tr>
                                <td>Created By</td>
                                <td>{{$patient->createdBy->name}}</td>
                            </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
