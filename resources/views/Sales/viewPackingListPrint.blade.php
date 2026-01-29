<?php
use App\Helpers\CommonHelper;
$m = Session::get('run_company');
?>
@extends('layouts.default')
@section('content')
<style>
@media print {
    .printHide{display:none !important;}
    @page { margin: 10mm; }
    .row { display: flex; align-items: center; }
    .col-lg-6 { text-align: center !important; display: flex !important; justify-content: center !important; align-items: center !important; }
    .col-lg-6 > div { width: 100%; text-align: center !important; }
}
.row { display: flex; align-items: center; }
.col-lg-6 { text-align: center !important; display: flex !important; justify-content: center !important; align-items: center !important; }
.col-lg-6 > div { width: 100%; text-align: center !important; }
</style>

<div class="row printHide" style="margin-bottom: 15px;">
    <div class="col-lg-12 text-right">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fa fa-print"></i> Print
        </button>
        <a href="{{ url('/export/packingListList') }}" class="btn btn-default">
            <i class="fa fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row" id="printPackingList">
    <div class="col-md-12">
        <?php echo CommonHelper::headerPrintSectionInPrintView($m);?>
        @include('Sales.partials.packingListDocument', ['packingList' => $packingList, 'minRows' => 10])
    </div>
</div>

@endsection
