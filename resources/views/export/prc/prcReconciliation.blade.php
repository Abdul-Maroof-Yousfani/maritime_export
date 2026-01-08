<?php
$m =Session::get('run_company');
?>
@extends('layouts.default')

@section('content')
    <div class="well_N">
    <div class="dp_sdw">    
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="display: none;">
                      
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                       
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <span class="subHeadingLabelClass">PRC Reconciliation</span>
                                </div>
                            </div>
                            <form method="POST" action="{{route('prcReconciliationStore')}}" >
                                <div class="row">
                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label for="">PRC NO </label>
                                        <input type="text" readonly class="form-control" value="{{$prc->prc_no}}">
                                        <input type="hidden" name="prc_id" value="{{$prc->id}}">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Bank</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <select class="form-control" name="bank_id" id="">
                                            <option value="">Select</option>
                                            @foreach ($banks as $bank)
                                            <option @if($prc->bank_id == $bank->id) selected @endif value="{{$bank->id}}">{{$bank->bank_name}}</option>
                                            @endforeach
                                          
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Booking Date</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <input readonly type="date" name="book_date" id="name" value="{{$prc->date}}" class="form-control requiredField" />
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Book Amount</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <input readonly type="text" name="book_amount" id="name" value="{{$prc->amount}}" class="form-control requiredField" />
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>FWD NO</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <input readonly type="text" name="fwd_no" id="name" value="{{$prc->fwd_no}}" class="form-control requiredField" />
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Rate</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <input readonly type="text" name="rate" id="name" value="{{$prc->rate}}" class="form-control requiredField" />
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Start Date</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <input readonly type="date" name="start_date" id="name" value="{{$prc->start_date}}" class="form-control requiredField" />
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Maturity Date</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <input readonly type="date" name="maturity_date" id="name" value="{{$prc->maturity}}" class="form-control requiredField" />
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Balance</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <input readonly type="text" name="balance" id="name" value="{{$prc->balance}}" class="form-control requiredField" />
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Fixed</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <input readonly type="date" name="fixed" id="name" value="{{$prc->fixed_date}}" class="form-control requiredField" />
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Option</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <input readonly  type="date" name="option" id="name" value="{{$prc->option_date}}" class="form-control requiredField" />
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Commercial Invoice</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                                        <select name="invoice_id" class="form-control" onChange="invoiceDetails(this.value)">
                                         <option value="">Select Invoice</option>
                                            @foreach($export_invoice as $export)
                                            <option value="{{$export->id}}">{{$export->invoice_no}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row invoicedetail">
                                    
                                </div>
                                <div>&nbsp;</div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
                                        <button type="reset" id="reset" class="btn btn-danger">Clear Form</button>

                                        <?php
                                        //echo Form::submit('Click Me!');
                                        ?>
                                    </div>
                                </div>

                                </form>

                            {{-- <div class="row">
                               
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label for="">PRC NO </label>
                                    <input type="text" class="form-control" value="">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label for="">PRC NO </label>
                                    <input type="text" class="form-control" value="">
                                </div>
                            </div> --}}
                            
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  
@endsection
<script>
   function invoiceDetails(id){

       html ='';
            var amount= 0;
            var counter =1;
            var currencey_rate = 0;
            var curreny = '';
            $.ajax({
                url: '<?php echo url('/')?>/export/getInvoice',
                type: "GET",
                data:{id:id},
                success:function(data) {
                    $('.invoicedetail').empty();
                  $.each(data,function(key,value){
                    amount += value.rate*value.issue_qty;
                    currencey_rate = value.currencey_rate;
                    curreny = value.curreny;
                  });
                  html =` <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Currencey Rate</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                    <input type="text" readonly class="form-control"name="currency_name" value="${curreny}">
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Currencey Rate</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                    <input type="text" readonly class="form-control" name="currency_rate" value="${currencey_rate}">
                </div>
                   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label>Commercial Amount</label>
                                        <span class="rflabelsteric"><strong>*</strong></span>
                    <input type="text" readonly class="form-control" name="invoice_amount" value="${amount}">
                </div>
                    `;
                    $('.invoicedetail').append(html);
                }
            });
   }
</script>