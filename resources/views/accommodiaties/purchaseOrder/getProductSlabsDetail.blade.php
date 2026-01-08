@if(count($slabs))
<div class="row align-items-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td class="bg-primary">
                        Type
                        </td>
                        <td class="bg-primary">
                        From
                        </td>
                        <td class="bg-primary">
                            To 
                        </td>
                    
                        <td class="bg-primary">
                            Deduction
                        </td>
                        <td class="bg-primary">
                            Remarks
                        </td>
                        <td class="bg-primary">
                        Remove
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($slabs ?? [] as $key => $slab)

                        <tr id="removeSection{{$key}}" class="slab_get">
                            <td>
                                {{$slab_name ?? 'Name'}} 
                            </td>
                            <td>
                                <input type="number" step="0.01" name="slab_from[]" class="form-control" id="from" placeholder="From" value="{{$slab->from}}">
                            </td>
                            <td>
                                <input type="number" step="0.01" name="slab_to[]" class="form-control" id="to" placeholder="To" value="{{$slab->to}}">
                            </td>
                            <td>
                                <input type="number" step="0.01" name="slab_deduction[]" class="form-control" id="deduction" placeholder="Deduction" value="{{$slab->amount}}">
                            </td>
                            <td>
                                <textarea class="form-control" id="slab_remark[]" placeholder="Remarks">{{$slab->remark}}</textarea>
                            </td>
                            <td><span style="cursor:pointer" class="btn btn-danger btn-xs" onClick="removeSection({{$key}})">Remove</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
          

        </div>

    </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <span style="cursor: pointer" onclick="update_slab()" class="btn btn-primary">Update Slab</button>
        </div>
</div>
@endif
       