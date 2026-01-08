<?php

namespace App\Http\Controllers;

use App\Models\ExportDutiesClearing;
use App\Models\ExportPakingList;
use App\Models\SaleOrderExport;
use App\Models\FumigationCertificate;
use App\Models\OriginCertificate;
use App\Models\ClearanceCertificate;
use App\Models\ExportBillOfLading;
use App\Models\QualityPackingCertificate;
use App\Models\QualityDeclearCertificate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExportDutiesClearingController extends Controller
{

    public function createDutiesList()
    {
        return view('export.dutiesclearing.createDuitesList');
    }


    public function createDutiesListAjax(Request $request)
    {

        $query = ExportPakingList::join('export_invoices', 'export_invoices.id', 'export_paking_lists.invoice_id')
            ->select('export_invoices.invoice_no', 'export_paking_lists.*')
            ->where('export_paking_lists.status', 1);
        if (!empty($request->packing_list_no)) {
            $query->where('export_paking_lists.import_no', 'LIKE', '%' . $request->packing_list_no . '%');
        }
        if (!empty($request->commercial)) {
            $query->where('export_invoices.invoice_no', 'LIKE', '%' . $request->commercial . '%');
        }

        $exportpakingList =   $query->get();

        return view('export.dutiesclearing.createDuitesListAjax', compact('exportpakingList'));
    }

    public function createDuties(Request $request)
    {

        $exportpakingList = ExportPakingList::join('export_paking_list_datas', 'export_paking_list_datas.import_paking_list_id', 'export_paking_lists.id')
            ->join('export_invoice_datas', 'export_invoice_datas.id', 'export_paking_list_datas.invoice_data_id')
            ->join('sale_order_data_exports', 'sale_order_data_exports.id', 'export_invoice_datas.sale_order_export_data_id')
            ->join('subitem', 'subitem.id', 'sale_order_data_exports.item_id')
            ->join('sale_order_exports', 'sale_order_exports.id', 'sale_order_data_exports.sale_order_export_id')
            ->join('export_invoices', 'export_invoices.id', 'export_invoice_datas.export_invoice_id')
            ->join('customers', 'customers.id', 'sale_order_exports.buyer_id')
            ->select(
                'export_paking_lists.id as export_list_id',
                'export_invoices.invoice_no',
                'sale_order_exports.delevery_date',
                'export_invoices.form_no',
                'export_invoices.invoice_date',
                'sale_order_exports.bank',
                'customers.name',
                'customers.country',
                'sale_order_exports.port_loading',
                'sale_order_exports.port_of_discharge',
                'export_invoices.bill_of_loading',
                'sale_order_exports.hs_code',
                'export_invoices.ship_name',
                'subitem.sub_ic',
                'sale_order_exports.quality_remarks',
                'export_paking_list_datas.qty',
                'sale_order_data_exports.flc_qty',
                'sale_order_data_exports.rate as rate_qty',
                'sale_order_data_exports.uom_id',
                'sale_order_exports.currencey_rate',
                'export_invoice_datas.id as invoice_data_id'
            )
            ->where('export_paking_lists.id', trim($request->id))
            ->first();
        // dd( $exportpakingList);
        return view('export.dutiesclearing.createDutiesClearing', compact('exportpakingList'));
        $exportpakingList = ExportPakingList::join('export_paking_list_datas', 'export_paking_list_datas.import_paking_list_id', 'export_paking_lists.id')
            ->join('export_invoices', 'export_invoices.id', 'export_paking_lists.invoice_id')
            ->join('export_performas', 'export_performas.id', 'export_invoices.proforma_id')
            ->join('sale_order_exports', 'sale_order_exports.id', 'export_performas.sale_order_id')
            ->where('export_paking_lists.id', trim($request->id))
            ->where('export_paking_lists.status', 1)
            ->get();
        dd($exportpakingList);
    }


    public function dutiesClearingStore(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
            $str = DB::connection('mysql2')->selectOne("select max(convert(substr(`mf_no`,4,length(substr(`mf_no`,4))-4),signed integer)) reg from `export_duties_clearings` where substr(`mf_no`,-4,2) = " . date('m') . " and substr(`mf_no`,-2,2) = " . date('y') . "")->reg;
            $sccd_no = 'SCCD' . ($str + 1) . date('my');

            $export_duities = new ExportDutiesClearing;
            $export_duities->mf_no = $sccd_no;
            $export_duities->invoice_no = $request->invoice_no;
            $export_duities->shipment_date = $request->shippment_date;
            $export_duities->delevery_date = $request->delevery_date;
            $export_duities->e_form_no = $request->e_form_no;
            $export_duities->e_form_date = $request->e_form_date;
            $export_duities->e_form_bank = $request->bank_e_form;
            $export_duities->party_name = $request->party_name;
            $export_duities->country = $request->country;
            $export_duities->port_of_loading = $request->port_loading;
            $export_duities->port_of_discharge = $request->port_of_discharge;
            $export_duities->bill_no = $request->bill_of_loading;
            $export_duities->bill_date = $request->bl_date;
            $export_duities->hs_code = $request->hs_code;
            $export_duities->vessel_name = $request->vessel_name;
            $export_duities->commodity = $request->commodity;
            $export_duities->quality = $request->quality;
            $export_duities->quantity_ton = $request->quantity;
            $export_duities->type = $request->type;
            $export_duities->raw_material_cost_per_ton = $request->raw_material_cost_per_ton;
            $export_duities->container = $request->total_container;
            $export_duities->cost_sales = $request->cost_of_sales;
            $export_duities->labour_cost = $request->labour_cost_per_ton;
            $export_duities->shipment_labour_cost = $request->shipment_labour_cost;
            $export_duities->rate_per_ton = $request->rate_per_ton;
            $export_duities->invoice_fcy = $request->invoice_value_in_fcy;
            $export_duities->exchange_rate = $request->exchange_rate;
            $export_duities->invoice_value_pkr = $request->invoice_value_in_pkr;
            $export_duities->shipment_term = $request->shipment_term;
            $export_duities->income_tax = $request->income_tax;
            $export_duities->eds_charges = $request->eds_charges;
            $export_duities->pkr_realization = $request->pkr_realization;
            $export_duities->proceeds_realization_bank = $request->proceeds_realization_in_bank;
            $export_duities->packing_type = $request->paking_type;
            $export_duities->packing_quality = $request->paking_quality;
            // quantity_in_ton
            $export_duities->no_of_begs = $request->no_of_begs;
            $export_duities->packing_cost_per_ton = $request->packing_cost_per_ton;
            $export_duities->packing_cost = $request->packing_cost;
            $export_duities->fumigation_cost_per_ton = $request->fumigation_cost_per_ton;
            $export_duities->shipment_fumigation_cost = $request->shipment_fumigation_cost;
            $export_duities->inspection_cost_per_ton = $request->inspection_cost_per_ton;
            $export_duities->shipment_inspection_cost = $request->shipment_inspection_cost;
            $export_duities->crearing_agent = $request->clearing_agent;
            $export_duities->terminal = $request->terminal;
            $export_duities->weboc_token_charges = $request->weboc_token_charges;
            $export_duities->psw_fee = $request->psw_fee;
            $export_duities->Wharfage = $request->Wharfage;
            $export_duities->terminal_handling_charges = $request->terminal_handling_charges;
            $export_duities->fuel_adjustment_charges = $request->fuel_adjustment_charges;
            $export_duities->documentation_charges = $request->documentation_charges;
            $export_duities->miscellaneous_charges = $request->miscellaneous_charges;
            $export_duities->anf_expanse = $request->anf_chrages;
            $export_duities->agencey_charges = $request->agency_charges;
            $export_duities->freight_forwarder = $request->freight_forwarder;
            $export_duities->house_bill_no = $request->house_bl_no;
            $export_duities->shipping_line = $request->shipping_line;
            $export_duities->export_freight_in_per_ton = $request->export_freight_in_per_ton;
            $export_duities->export_freight_in_usd = $request->export_freight_in_dolar;
            $export_duities->export_freight_in_per_pkr = $request->invoice_value_in_pkr;
            $export_duities->lifting_charges = $request->lifting_charges;
            $export_duities->transporter = $request->Transporter;
            $export_duities->container_cost = $request->container_cost_;
            $export_duities->total_container_cost = $request->total_transportation_cost;
            $export_duities->craft_paear_cost = $request->craft_papper_cost;
            $export_duities->invoice_data_id = $request->invoice_id;
            $export_duities->status = 1;
            $export_duities->save();

            $exportPakingList = ExportPakingList::find($request->export_list_id);
            $exportPakingList->duities_clearing_status = 1;
            $exportPakingList->save();
            DB::Connection('mysql2')->commit();
            return redirect()->route('DutiesList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }


    public function DutiesList()
    {
        return view('export.dutiesclearing.DuitiesList');
    }


    public function DutiesListAjax(Request $request)
    {
        $query = ExportDutiesClearing::where('status', 1);
        if (!empty($request->sccd)) {
            $query->where('export_duties_clearings.mf_no', 'LIKE', '%' . $request->sccd . '%');
        }
        if (!empty($request->commercial)) {
            $query->where('export_duties_clearings.invoice_no', 'LIKE', '%' . $request->commercial . '%');
        }
        $exportpakingList =   $query->get();
        return view('export.dutiesclearing.DuitiesListAjax', compact('exportpakingList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExportDutiesClearing  $exportDutiesClearing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExportDutiesClearing $exportDutiesClearing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExportDutiesClearing  $exportDutiesClearing
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExportDutiesClearing $exportDutiesClearing)
    {
        //
    }

    public function fumigationCertificate(Request $request)
    {

        $fumigation =  FumigationCertificate::where('ex_duities_id', $request->id)->first();
        return view('export.dutiesclearing.fumigationCertificate', compact('fumigation'));
    }
    public function originertificate(Request $request)
    {
        $originCertificate =  OriginCertificate::where('ex_duities_id', $request->id)->first();
        $totalBags = ExportPakingList::where('id', $request->id)->sum('total_qty');
        return view('export.dutiesclearing.originertificate', compact('originCertificate', 'totalBags'));
    }
    public function clearingCertificate(Request $request)
    {
        $clearingCertificate =  ClearanceCertificate::where('ex_duities_id', $request->id)->first();
        
        $exportPakingList = ExportPakingList::find($request->id);//->sum('total_qty');
        return view('export.dutiesclearing.clearingCertificate', compact('clearingCertificate', 'exportPakingList'));
    }
    public function qualityDeclaration(Request $request)
    {
        $qualityDeclaration =  QualityDeclearCertificate::where('ex_duities_id', $request->id)->first();
        return view('export.dutiesclearing.qualityDeclaration', compact('qualityDeclaration'));
    }
    public function qualityPacking(Request $request)
    {
        $qualityPacking = QualityPackingCertificate::where('ex_duities_id', $request->id)->first();
        $exportInvoiceDetail =  ExportPakingList::join('export_invoices', 'export_invoices.id', 'export_paking_lists.invoice_id')
        ->join('sale_order_exports', 'sale_order_exports.id', 'export_invoices.sale_order_export_id')
        ->select('export_invoices.*')
        ->where('export_paking_lists.id', $qualityPacking->ex_duities_id)
        ->first();
        // dd($exportInvoiceDetail);
        return view('export.dutiesclearing.qualityPacking', compact('qualityPacking', 'exportInvoiceDetail'));
    }

    public function createFumigation(Request $request, $id, $key)
    {
        $duities_id = $id;
        $export_order_data =  ExportPakingList::join('export_invoices', 'export_invoices.id', 'export_paking_lists.invoice_id')
            ->join('sale_order_exports', 'sale_order_exports.id', 'export_invoices.sale_order_export_id')
            ->where('export_paking_lists.id', $duities_id)
            ->first();
        $exportPakingList = ExportPakingList::find($duities_id);
        if ($key == 'Fumigation') {
            return view('export.dutiesclearing.certificate.createFumigation', compact('duities_id', 'exportPakingList', 'export_order_data'));
        }
        if ($key == 'origin') {
            // dd($exportPakingList->invoice);
            return view('export.dutiesclearing.certificate.createOrigin', compact('duities_id', 'exportPakingList'));
        }
        if ($key == 'clearance') {
            return view('export.dutiesclearing.certificate.createClearance', compact('duities_id', 'exportPakingList'));
        }
        if ($key == 'qualitydeclaration') {
            $exportPakingList =  ExportPakingList::join('export_invoices', 'export_invoices.id', 'export_paking_lists.invoice_id')
                ->join('sale_order_exports', 'sale_order_exports.id', 'export_invoices.sale_order_export_id')
                ->select('export_paking_lists.*', 'export_invoices.ship_name', 'export_invoices.consigned_deatils', 'sale_order_exports.quality_remarks', 'sale_order_exports.product_specification')
                ->where('export_paking_lists.id', $duities_id)
                ->first();
            $billOfLading = ExportBillOfLading::where('status', 1)->where('packaging_id', $duities_id)->first();
            return view('export.dutiesclearing.certificate.createQualityDeclaration', compact('duities_id', 'exportPakingList', 'billOfLading'));
        }
        if ($key == 'qualitypacking') {
            return view('export.dutiesclearing.certificate.createQualityPacking', compact('duities_id', 'export_order_data', 'exportPakingList'));
        }
    }
    public function createFumigationStore(Request $request)
    {

        DB::Connection('mysql2')->beginTransaction();
        try {
          $certification  =  new FumigationCertificate;
          $certification->ex_duities_id  = $request->ex_duities_id;
          $certification->fumigation_text_area  = $request->Details;
          $certification->chemical_treatment  = $request->chemical_treatment;
          $certification->chemical_concentration  = $request->chemical_concentration;
          $certification->name_address_expoter  = $request->name_exporter;
          $certification->name_address_consignee  = $request->name_of_consignee;
          $certification->mean_of_conveyance  = $request->conveyance;
          $certification->distinguishing_marks  = $request->distinguishing;
          $certification->description_of_good  = $request->description;
          $certification->origin_certificate_shippers  = $request->certified_by_shipper;
          $certification->no_of_bags  = $request->no_bags;
          $certification->date  = $request->date;
          $certification->fumigation_created_by  = $request->fumigation_created_by;
          $certification->details2  = $request->details2;
          $certification->details1  = $request->details1;

            $certification->save();
            $export_duities = ExportPakingList::find($request->ex_duities_id);
            $export_duities->fumigation_status = 1;
            $export_duities->save();

            DB::Connection('mysql2')->commit();
            return redirect()->route('importPakingList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }

    public function OriginStore(Request $request)
    {
        // dd($request);
        DB::Connection('mysql2')->beginTransaction();
        try {
            $certification  =  new OriginCertificate;
            $certification->ex_duities_id  = $request->ex_duities_id;
            $certification->exporter_name  = $request->exporter_name;
            $certification->exporter_address  = $request->exporter_address;
            $certification->consignee_name  = $request->importer_name;
            $certification->consignee_address  = $request->importer_address;
            $certification->exporter_membership_no  = $request->membership_no;
            $certification->mode_transport  = $request->mode_of_transport;
            //   $certification->bl_no_date  = $request->b_l_no;
            $certification->shiper_name  = $request->vessel_name;
            $certification->marks_number      = $request->marks_no;
            $certification->description_of_good_origin      = $request->description_of_good_origin;
            //   $certification->country_origin	  = $request->country;
            $certification->neight_weight      = $request->gross_weight;
            $certification->gross_weight      = $request->gross_weight;
            $certification->name_origin      = $request->designation;
            $certification->designation_origin      = $request->designation;
            $certification->company      = $request->company;
            $certification->place      = $request->place;
            $certification->save();
            $export_duities = ExportPakingList::find($request->ex_duities_id);
            $export_duities->origin_status = 1;
            $export_duities->save();
            DB::Connection('mysql2')->commit();
            return redirect()->route('importPakingList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }
    public function clearanceStore(Request $request)
    {

        DB::Connection('mysql2')->beginTransaction();
        try {
            $certification  =  new ClearanceCertificate;
            $certification->ex_duities_id  = $request->ex_duities_id;
            // $certification->invoice_no  = $request->invoice_no;
            // $certification->invoice_date  = $request->invoice_date;
            $certification->clearance_certificate_no  = $request->clearance_certificate_no;
            $certification->invoice_date  = $request->invoice_date;
            $certification->consignee  = $request->consignee;
            // $certification->vessel_name  = $request->vessel_name;
            // $certification->port_of_loading  = $request->port_of_loading;
            $certification->container_no  = $request->container_no;
            // $certification->port_of_discharge  = $request->port_of_discharge;
            // $certification->total_weight  = $request->total_weight;
            $certification->description_og_good  = $request->description_og_good;
            $certification->health      = $request->health;
            $certification->specification      = $request->specification;
            // $certification->lead      = $request->lead;
            // $certification->arsenic      = $request->arsenic;
            // $certification->cadmium      = $request->cadmium;
            // $certification->mercury      = $request->mercury;
            // $certification->mercury_organic_pesticides      = $request->mercury_organic_pesticides;
            // $certification->hexachlorocy      = $request->hexachlorocy;
            // $certification->ddt_4_4      = $request->ddt_4_4;
            // $certification->d_2_4      = $request->d_2_4;
            // $certification->ddt_2_4      = $request->ddt_2_4;
            // $certification->dde_4_4      = $request->dde_4_4;
            // $certification->dde_2_4      = $request->dde_2_4;
            // $certification->ddd_4_4      = $request->ddd_4_4;
            // $certification->aflatoxin_B1      = $request->aflatoxin_B1;
            // $certification->aflatoxin_B2      = $request->aflatoxin_B2;
            // $certification->aflatoxin_G1      = $request->aflatoxin_G1;
            // $certification->aflatoxin_G2      = $request->aflatoxin_G2;
            // $certification->orchratoxin_a      = $request->orchratoxin_a;
            // $certification->t_2_toxins      = $request->t_2_toxins;
            $certification->save();
            $export_duities = ExportPakingList::find($request->ex_duities_id);
            $export_duities->clearance_status = 1;
            $export_duities->save();
            DB::Connection('mysql2')->commit();
            return redirect()->route('importPakingList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }

    public function qualityDeclearationStore(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
            $certification  =  new QualityDeclearCertificate;
            $certification->ex_duities_id  =  $request->ex_duities_id;
            $certification->certificate_no  =  $request->certificate_no;
            $certification->certificate_date  =  $request->certificate_date;
            $certification->bill_of_lading  =  $request->bill_of_lading;
            $certification->qulity_decleartion_shiper_name  =  $request->qulity_decleartion_shiper_name;
            $certification->qulity_decleartion_consignee  =  $request->qulity_decleartion_consignee;
            $certification->qulity_decleartion_shipper  =  $request->qulity_decleartion_shipper;
            $certification->description_of_goods  =  $request->description_of_goods;
            $certification->other_detail  =  $request->other_detail;
            $certification->other_detail_2  =  $request->other_detail_2;






            $certification->qulity_decleartion_container_no  =  $request->qulity_decleartion_container_no;
            $certification->qulity_decleartion_number_of_bags  =  $request->qulity_decleartion_number_of_bags;
            $certification->qulity_decleartion_net_weight  =  $request->qulity_decleartion_net_weight;
            $certification->broken_grain  =  $request->broken_grain;
            $certification->contaating_varieties  =  $request->contaating_varieties;
            $certification->foreign_garin  =  $request->foreign_garin;
            $certification->foreign_matter  =  $request->foreign_matter;
            $certification->undermilled_red_striped  =  $request->undermilled_red_striped;
            $certification->paddy_grain  =  $request->paddy_grain;
            $certification->damaged_discolour  =  $request->damaged_discolour;
            $certification->chalky_kernal  =  $request->chalky_kernal;
            $certification->moisture  =  $request->moisture;
            $certification->averga_origin_length  =  $request->averga_origin_length;
            $certification->whitness  =  $request->averga_origin_length;
            $certification->crop  =  $request->crop;
            $certification->cadmimum  =  $request->cadmimum;
            $certification->arsen  =  $request->arsen;
            $certification->zinc  =  $request->zinc;
            $certification->hg  =  $request->hg;
            $certification->save();
            $export_duities = ExportPakingList::find($request->ex_duities_id);
            $export_duities->quality_declear_status = 1;
            $export_duities->save();
            DB::Connection('mysql2')->commit();
            return redirect()->route('importPakingList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }

    public function qualityPackingStore(Request $request)
    {

        DB::Connection('mysql2')->beginTransaction();
        try {
            $certification = new QualityPackingCertificate;
            $certification->ex_duities_id = $request->ex_duities_id ;
            $certification->quality_packing_shipper = $request->quality_packing_shipper ;
            $certification->quality_packing_consignee = $request->quality_packing_consignee ;
            $certification->quality_packing_description_of_good = $request->quality_packing_description_of_good ;
            $certification->quality_packing_packing = $request->quality_packing_packing ;
            $certification->quality_packing_origin = $request->quality_packing_origin ;
            $certification->quality_packing_declared_quality = $request->quality_packing_declared_quality ;
            $certification->quality_packing_vessel = $request->quality_packing_vessel ;
            $certification->quality_packing_port_of_loading = $request->quality_packing_port_of_loading ;
            $certification->quality_packing_of_discharge = $request->quality_packing_of_discharge ;
            $certification->quality_packing_Bl_no = $request->quality_packing_Bl_no ;
            $certification->quality_packing_container_no = $request->quality_packing_container_no ;
            $certification->quality_packing_lot_no = $request->quality_packing_lot_no ;
            $certification->quality_packing_weight = $request->quality_packing_weight ;
            $certification->quality_packing_date_of_production = $request->quality_packing_date_of_production ;
            $certification->quality_packing_quality = $request->quality_packing_quality ;
            $certification->quality_packing_broken = $request->quality_product_specification; // saving all product specification Broken column
            $certification->quality_packing_detail = $request->quality_packing_detail ;
            $certification->quality_certificate_no = $request->quality_certificate_no ;
            $certification->quality_date = $request->quality_date ;
            $certification->save();
            $export_duities = ExportPakingList::find($request->ex_duities_id);
            $export_duities->quality_packing_status = 1;
            $export_duities->save();
            DB::Connection('mysql2')->commit();
            return redirect()->route('importPakingList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }

    public function editCertificate(Request $request, $id, $key)
    {
        $duities_id = $id;

        if ($key == 'Fumigation') {
            $fumigation =  FumigationCertificate::where('ex_duities_id', $duities_id)->first();
            return view('export.dutiesclearing.certificate.editFumigation', compact('fumigation'));
        }
        if ($key == 'origin') {

            $originCertificate = OriginCertificate::where('ex_duities_id', $duities_id)->first();

            return view('export.dutiesclearing.certificate.editOrigin', compact('originCertificate'));
        }
        if ($key == 'clearance') {
            $clearance = ClearanceCertificate::where('ex_duities_id', $duities_id)->first();
            return view('export.dutiesclearing.certificate.editClearance', compact('clearance'));
        }
        if ($key == 'qualitydeclaration') {
            $qualitydeclaration = QualityDeclearCertificate::where('ex_duities_id', $duities_id)->first();
            return view('export.dutiesclearing.certificate.editQualityDeclaration', compact('qualitydeclaration'));
        }
        if ($key == 'qualitypacking') {
            $qualityPacking =  QualityPackingCertificate::where('ex_duities_id', $duities_id)->first();
            return view('export.dutiesclearing.certificate.editQualityPacking', compact('qualityPacking'));
        }
    }


    public function updateFumigation(Request $request)
    {

        DB::Connection('mysql2')->beginTransaction();
        try {
            $certification  = FumigationCertificate::find($request->id);
            $certification->ex_duities_id  = $request->ex_duities_id;
            $certification->fumigation_text_area  = $request->Details;
            $certification->chemical_treatment  = $request->chemical_treatment;
            $certification->chemical_concentration  = $request->chemical_concentration;
            $certification->name_address_expoter  = $request->name_exporter;
            $certification->name_address_consignee  = $request->name_of_consignee;
            $certification->mean_of_conveyance  = $request->conveyance;
            $certification->distinguishing_marks  = $request->distinguishing;
            $certification->description_of_good  = $request->description;
            $certification->origin_certificate_shippers  = $request->certified_by_shipper;
            $certification->no_of_bags  = $request->no_bags;
            $certification->date  = $request->date;
            $certification->fumigation_created_by  = $request->fumigation_created_by;
            $certification->details2  = $request->details2;
            $certification->details1  = $request->details1;
            $certification->save();
            $export_duities = ExportPakingList::find($request->ex_duities_id);
            $export_duities->fumigation_status = 1;
            $export_duities->save();

            DB::Connection('mysql2')->commit();
            return redirect()->route('importPakingList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }

    public function updateOrigin(Request $request)
    {

        DB::Connection('mysql2')->beginTransaction();
        try {
            $certification  = OriginCertificate::find($request->id);
            $certification->ex_duities_id  = $request->ex_duities_id;
            $certification->exporter_name  = $request->exporter_name;
            $certification->exporter_address  = $request->exporter_address;
            $certification->consignee_name  = $request->importer_name;
            $certification->consignee_address  = $request->importer_address;
            $certification->exporter_membership_no  = $request->membership_no;
            $certification->mode_transport  = $request->mode_of_transport;
            $certification->bl_no_date  = $request->b_l_no;
            $certification->shiper_name  = $request->vessel_name;
            $certification->marks_number      = $request->marks_no;
            $certification->description_of_good_origin      = $request->description_of_good_origin;
            $certification->country_origin      = $request->country;
            $certification->neight_weight      = $request->net_weight;
            $certification->gross_weight      = $request->gross_weight;
            $certification->name_origin      = $request->name;
            $certification->designation_origin      = $request->designation;
            $certification->company      = $request->company;
            $certification->place      = $request->place;
            $certification->save();
            $export_duities = ExportPakingList::find($request->ex_duities_id);
            $export_duities->origin_status = 1;
            $export_duities->save();
            DB::Connection('mysql2')->commit();
            return redirect()->route('importPakingList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }
    public function updateclearance(Request $request)
    {

        DB::Connection('mysql2')->beginTransaction();
        try {
            $certification  =  ClearanceCertificate::find($request->id);
            $certification->ex_duities_id  = $request->ex_duities_id;
            // $certification->invoice_no  = $request->invoice_no;
            $certification->invoice_date  = $request->invoice_date;
            $certification->clearance_certificate_no  = $request->clearance_certificate_no;
            $certification->consignee  = $request->consignee;
            // $certification->vessel_name  = $request->vessel_name;
            // $certification->port_of_loading  = $request->port_of_loading;
            $certification->container_no  = $request->container_no;
            // $certification->port_of_discharge  = $request->port_of_discharge;
            // $certification->total_weight  = $request->total_weight;
            $certification->description_og_good  = $request->description_og_good;
            $certification->health      = $request->health;
            $certification->specification      = $request->specification;
            // $certification->lead      = $request->lead;
            // $certification->arsenic      = $request->arsenic;
            // $certification->cadmium      = $request->cadmium;
            // $certification->mercury      = $request->mercury;
            // $certification->mercury_organic_pesticides      = $request->mercury_organic_pesticides;
            // $certification->hexachlorocy      = $request->hexachlorocy;
            // $certification->ddt_4_4      = $request->ddt_4_4;
            // $certification->d_2_4      = $request->d_2_4;
            // $certification->ddt_2_4      = $request->ddt_2_4;
            // $certification->dde_4_4      = $request->dde_4_4;
            // $certification->dde_2_4      = $request->dde_2_4;
            // $certification->ddd_4_4      = $request->ddd_4_4;
            // $certification->aflatoxin_B1      = $request->aflatoxin_B1;
            // $certification->aflatoxin_B2      = $request->aflatoxin_B2;
            // $certification->aflatoxin_G1      = $request->aflatoxin_G1;
            // $certification->aflatoxin_G2      = $request->aflatoxin_G2;
            // $certification->orchratoxin_a      = $request->orchratoxin_a;
            // $certification->t_2_toxins      = $request->t_2_toxins;
            $certification->save();
            $export_duities = ExportPakingList::find($request->ex_duities_id);
            $export_duities->clearance_status = 1;
            $export_duities->save();
            DB::Connection('mysql2')->commit();
            return redirect()->route('importPakingList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }

    public function updatequalityDeclearation(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
            $certification  = QualityDeclearCertificate::find($request->id);
            $certification->ex_duities_id  =  $request->ex_duities_id;
            $certification->certificate_no  =  $request->certificate_no;
            $certification->certificate_date  =  $request->certificate_date;
            $certification->bill_of_lading  =  $request->bill_of_lading;
            $certification->qulity_decleartion_shiper_name  =  $request->qulity_decleartion_shiper_name;
            $certification->qulity_decleartion_consignee  =  $request->qulity_decleartion_consignee;
            $certification->qulity_decleartion_shipper  =  $request->qulity_decleartion_shipper;
            $certification->description_of_goods  =  $request->description_of_goods;
            $certification->other_detail  =  $request->other_detail;
            $certification->other_detail_2  =  $request->other_detail_2;







            $certification->qulity_decleartion_container_no  =  $request->qulity_decleartion_container_no;
            $certification->qulity_decleartion_number_of_bags  =  $request->qulity_decleartion_number_of_bags;
            $certification->qulity_decleartion_net_weight  =  $request->qulity_decleartion_net_weight;
            $certification->broken_grain  =  $request->broken_grain;
            $certification->contaating_varieties  =  $request->contaating_varieties;
            $certification->foreign_garin  =  $request->foreign_garin;
            $certification->foreign_matter  =  $request->foreign_matter;
            $certification->undermilled_red_striped  =  $request->undermilled_red_striped;
            $certification->paddy_grain  =  $request->paddy_grain;
            $certification->damaged_discolour  =  $request->damaged_discolour;
            $certification->chalky_kernal  =  $request->chalky_kernal;
            $certification->moisture  =  $request->moisture;
            $certification->averga_origin_length  =  $request->averga_origin_length;
            $certification->whitness  =  $request->averga_origin_length;
            $certification->crop  =  $request->crop;
            $certification->cadmimum  =  $request->cadmimum;
            $certification->arsen  =  $request->arsen;
            $certification->zinc  =  $request->zinc;
            $certification->hg  =  $request->hg;
            $certification->save();
            $export_duities = ExportPakingList::find($request->ex_duities_id);
            $export_duities->quality_declear_status = 1;
            $export_duities->save();
            DB::Connection('mysql2')->commit();
            return redirect()->route('importPakingList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }

    public function updatequalityPacking(Request $request)
    {
        DB::Connection('mysql2')->beginTransaction();
        try {
            $certification = QualityPackingCertificate::find($request->id);
            $certification->ex_duities_id = $request->ex_duities_id ;
            $certification->quality_packing_shipper = $request->quality_packing_shipper ;
            $certification->quality_packing_consignee = $request->quality_packing_consignee ;
            $certification->quality_packing_description_of_good = $request->quality_packing_description_of_good ;
            $certification->quality_packing_packing = $request->quality_packing_packing ;
            $certification->quality_packing_origin = $request->quality_packing_origin ;
            $certification->quality_packing_declared_quality = $request->quality_packing_declared_quality ;
            $certification->quality_packing_vessel = $request->quality_packing_vessel ;
            $certification->quality_packing_port_of_loading = $request->quality_packing_port_of_loading ;
            $certification->quality_packing_of_discharge = $request->quality_packing_of_discharge ;
            $certification->quality_packing_Bl_no = $request->quality_packing_Bl_no ;
            $certification->quality_packing_container_no = $request->quality_packing_container_no ;
            $certification->quality_packing_lot_no = $request->quality_packing_lot_no ;
            $certification->quality_packing_weight = $request->quality_packing_weight ;
            $certification->quality_packing_date_of_production = $request->quality_packing_date_of_production ;
            $certification->quality_packing_quality = $request->quality_packing_quality ;
            $certification->quality_packing_broken = $request->quality_product_specification ;
            $certification->quality_packing_detail = $request->quality_packing_detail ;
            $certification->quality_certificate_no = $request->quality_certificate_no ;
            $certification->quality_date = $request->quality_date ;
            $certification->save();
            $export_duities = ExportPakingList::find($request->ex_duities_id);
            $export_duities->quality_packing_status = 1;
            $export_duities->save();
            DB::Connection('mysql2')->commit();
            return redirect()->route('importPakingList');
        } catch (Exception $ex) {

            DB::rollBack();
            dd($ex);
            $ex->getCode();
        }
    }
}
