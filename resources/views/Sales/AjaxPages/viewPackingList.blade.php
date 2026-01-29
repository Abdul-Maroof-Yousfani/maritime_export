@php
    use App\Helpers\CommonHelper;
    $m = Session::get('run_company');
@endphp

<style>
@media print {
    .printHide { display: none !important; }
    .modal-header, .modal-footer { display: none !important; }
    .modal-body { padding: 0 !important; }
    @page {
        margin: 10mm;
    }
    body {
        margin: 0;
        padding: 0;
    }
}
</style>

<div class="modal-header printHide">
    <h4 class="modal-title">View Packing List</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">
    <div class="row printHide" style="margin-bottom: 10px;">
        <div class="col-lg-12 text-right">
            <button onclick="printPackingListDirect()" class="btn btn-primary">
                <i class="fa fa-print"></i> Print
            </button>
        </div>
    </div>

    <div id="packingListDocWrap">
        <?php echo CommonHelper::headerPrintSectionInPrintView($m); ?>
        @include('Sales.partials.packingListDocument', ['packingList' => $packingList, 'minRows' => 10])
    </div>
</div>

<div class="modal-footer printHide">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button onclick="printPackingListDirect()" class="btn btn-primary">
        <i class="fa fa-print"></i> Print
    </button>
</div>

<script>
function printPackingListDirect() {
    // Get the content to print
    var printContent = document.getElementById('packingListDocWrap').innerHTML;
    
    // Create a new window for printing
    var printWindow = window.open('', '_blank', 'width=800,height=600');
    
    // Write the print content
    printWindow.document.write('<!DOCTYPE html>');
    printWindow.document.write('<html><head><title>Packing List</title>');
    printWindow.document.write('<style>');
    printWindow.document.write('@page { margin: 10mm; }');
    printWindow.document.write('body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }');
    printWindow.document.write('.row { display: flex; align-items: center; }');
    printWindow.document.write('.col-lg-6 { text-align: center !important; display: flex !important; justify-content: center !important; align-items: center !important; }');
    printWindow.document.write('.col-lg-6 > div { width: 100%; text-align: center !important; }');
    printWindow.document.write('</style></head><body>');
    printWindow.document.write(printContent);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    
    // Wait for content to load, then trigger print dialog
    printWindow.onload = function() {
        setTimeout(function() {
            printWindow.focus();
            printWindow.print();
            // Close window after printing (optional)
            // printWindow.close();
        }, 250);
    };
    
    // Fallback if onload doesn't fire
    setTimeout(function() {
        printWindow.focus();
        printWindow.print();
    }, 500);
}
</script>
