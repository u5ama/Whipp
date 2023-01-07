<?php

namespace App\Http\Controllers\Admin;

use App\BaseAppSocialLinks;
use App\Category;
use App\CustomerInvoice;
use App\RideBookingSchedule;
use App\TransportType;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use App\Utility\Utility;


class EarningAnalysisController extends Controller
{
    /**
     * Display a listing of the Customer Invoices.
     *
     * @param Request $request
     * @return Factory|View
     * @throws Exception
     */

    public function index(Request $request)
    {
        $bankCom = DB::table("customer_invoices")->get()->sum("ci_bank_amount");
        $netInvoice = DB::table("customer_invoices")->get()->sum("ci_net_invoice");
        $whipp = DB::table("customer_invoices")->get()->sum("ci_whipp_amount");
        $driver = DB::table("customer_invoices")->get()->sum("ci_driver_amount");

        $categories = $categories = TransportType::listsTranslations('name')
            ->select('transport_types.id')
            ->get();

        $dataInv = ['categories' => $categories, 'bankCom' => number_format($bankCom, 3, ".", ","), 'netInvoice' => number_format($netInvoice, 3, ".", ","), 'whipp' => number_format($whipp, 3, ".", ","), 'driver' => number_format($driver, 3, ".", ",")];

        if ($request->ajax()) {

            $start_date = (!empty($_GET["start_date"])) ? ($_GET["start_date"]) : ('');
            $end_date = (!empty($_GET["end_date"])) ? ($_GET["end_date"]) : ('');
            $category = (!empty($_GET["categoryFilter"])) ? ($_GET["categoryFilter"]) : ('');
            $status = (!empty($_GET["filterWithStatus"])) ? ($_GET["filterWithStatus"]) : ('');


            if ($start_date && $end_date) {
                $start_date = date('Y-m-d', strtotime($start_date));
                $end_date = date('Y-m-d', strtotime($end_date));
                $invoices = CustomerInvoice::query()->whereRaw("date(customer_invoices.ci_created_at) >= '" . $start_date . "' AND date(customer_invoices.ci_created_at) <= '" . $end_date . "'")->orderBy('customer_invoices.ci_created_at', 'DESC')->with('passenger', 'driver');
            } elseif ($category) {
                $invoices = CustomerInvoice::with('passenger', 'driver')->where('ci_vehicle_category', $category)->orderBy('customer_invoices.ci_created_at', 'DESC')->get();
            }elseif ($status) {
                $invoices = CustomerInvoice::leftJoin('ride_booking_schedules', 'customer_invoices.ci_ride_id', '=', 'ride_booking_schedules.id')->where(['ride_booking_schedules.rbs_ride_status'=> $status])->with('passenger', 'driver')->orderBy('customer_invoices.ci_created_at', 'DESC')->get();
            } else {
                $invoices = CustomerInvoice::with('passenger', 'driver')->orderBy('customer_invoices.ci_created_at', 'DESC')->get();
            }

            return Datatables::of($invoices)
                ->addColumn('invoice_date', function ($invoices) {
                    if (!empty($invoices->ci_invoice_date)) {
                        return Utility:: convertTimeToUSERzone($invoices->ci_invoice_date,Utility::getUserTimeZone(auth()->guard('admin')->user()->time_zone_id));
                    }
                })
                ->addColumn('trx_id', function ($invoices) {
                    if (!empty($invoices->ci_Trx_id)) {
                        $trx_id = $invoices->ci_Trx_id;
                        return $trx_id;
                    }
                })
                ->addColumn('inv_id', function ($invoices) {
                    if (!empty($invoices->ci_invoice_id)) {
                        $inv_id = $invoices->ci_invoice_id;
                        return $inv_id;
                    }
                })
                ->addColumn('ride_status', function ($invoices) {
                    if (!empty($invoices->ci_ride_id)) {
                        $ride = RideBookingSchedule::where('id', $invoices->ci_ride_id)->first();
                        if (!empty($ride)){
                            $rideStatus = $ride->rbs_ride_status;
                            return $rideStatus;
                        }else{
                            $rideStatus = 'Not Found';
                            return $rideStatus;
                        }
                    }
                })
                ->addColumn('category', function ($invoices) {
                    if (!empty($invoices->ci_vehicle_id)) {
                        App::setLocale(auth()->guard('admin')->user()->locale);
                            $category =TransportType::translated()->where('id',$invoices->ci_vehicle_id)->first()->name;
                        App::setLocale('en');
                        return $category;

                    }
                })
                ->addColumn('driver_details', function ($invoices) {
                    if (!empty($invoices->driver)) {

                        $driver = '<b>Vehicle#</b><span>123</span><br>' . '<b>Mobile:</b><span>' . $invoices->driver->du_full_mobile_number . '</span><br>' . '<b>Name:</b><span>' . $invoices->driver->du_full_name . '</span><br>' . '<b>Company:</b><span>' . $invoices->driver->du_com_id . '</span><br>';

                        return $driver;
                    }
                })
                ->addColumn('passenger_detail', function ($invoices) {

                    if (!empty($invoices->passenger)) {
                        $passenger = '<b>Customer Id:</b><span>' . $invoices->passenger->id . '</span><br>' . '<b> Mobile#</b><span>' . $invoices->passenger->mobile_no . '</span><br>' . '<b>Name:</b><span>' . $invoices->passenger->name . '</span><br>';
                        return $passenger;
                    }
                })
                ->addColumn('payment_mode', function ($invoices) {
                    if (!empty($invoices->ci_payment_mode)) {
                        return $invoices->ci_payment_mode;
                    }
                })
                ->addColumn('customer_invoice_amount', function ($invoices) {
                    if (!empty($invoices->ci_customer_invoice_amount)) {
                        return number_format($invoices->ci_customer_invoice_amount, 3, ".", ",");
                    }
                })
                ->addColumn('bank_commission', function ($invoices) {
                    if (!empty($invoices->ci_bank_amount)) {
                        return number_format($invoices->ci_bank_amount, 3, ".", ",");
                    }
                })
                ->addColumn('net_invoice', function ($invoices) {
                    if (!empty($invoices->ci_net_invoice)) {
                        return number_format($invoices->ci_net_invoice, 3, ".", ",");
                    }
                })
                ->addColumn('whipp', function ($invoices) {
                    if (!empty($invoices->ci_whipp_amount)) {
                        return number_format($invoices->ci_whipp_amount, 3, ".", ",");
                    }
                })
                ->addColumn('driver', function ($invoices) {
                    if (!empty($invoices->ci_driver_amount)) {
                        return number_format($invoices->ci_driver_amount, 3, ".", ",");
                    }
                })->addColumn('company_gross_earning', function ($dailyEarnings) {
                    if (!empty($dailyEarnings->ci_company_gross_earning)) {
                        return number_format($dailyEarnings->ci_company_gross_earning, 3, ".", ",");
                    }
                })->addColumn('company_net_earning', function ($dailyEarnings) {
                    if (!empty($dailyEarnings->ci_company_net_earning)) {
                        return number_format($dailyEarnings->ci_company_net_earning, 3, ".", ",");
                    }
                })
                ->addColumn('action', function ($invoices) {
                    $invoiceDetail = '<a type="button" data-invoiceId="' . $invoices->id . '" class="invoice-details btn btn-sm btn-outline-info waves-effect waves-light" data-placement="top" title="View" data-target="#modaldemo44" data-toggle="modal"><i class="fas fa-eye font-size-16 align-middle"></i></a>';
                    $invoiceDel = '<a type="button" data-invid="' . $invoices->id . '" class="delete-single btn btn-sm btn-outline-info waves-effect waves-light"  data-placement="top" ><i class="fas fa-trash font-size-16 align-middle"></i></a>';
                    return $invoiceDetail . ' ' . $invoiceDel;
                })
                ->rawColumns(['action', 'trx_id','inv_id','driver_details', 'passenger_detail','ride_status', 'company_gross_earning', 'company_net_earning'])
                ->make(true);
        }
        return view('admin.EarningAnalysis.index', compact('dataInv'));
    }

    /**
     * Date Filter for Customer Invoices
     * @param Request $request
     * @return JsonResponse
     */
    public function dateFilter(Request $request)
    {
        if ($request->ajax()) {
            $start_date = (!empty($request->start_date)) ? ($request->start_date) : ('');
            $end_date = (!empty($request->end_date)) ? ($request->end_date) : ('');
            $category = (!empty($request->category)) ? ($request->category) : ('');
            $status = (!empty($request->status)) ? ($request->status) : ('');

            if ($start_date && $end_date) {
                $start_date = date('Y-m-d', strtotime($start_date));
                $end_date = date('Y-m-d', strtotime($end_date));

                $bankCom = DB::table("customer_invoices")->whereRaw("date(customer_invoices.ci_created_at) >= '" . $start_date . "' AND date(customer_invoices.ci_created_at) <= '" . $end_date . "'")->get()->sum("ci_bank_amount");
                $netInvoice = DB::table("customer_invoices")->whereRaw("date(customer_invoices.ci_created_at) >= '" . $start_date . "' AND date(customer_invoices.ci_created_at) <= '" . $end_date . "'")->get()->sum("ci_net_invoice");
                $whipp = DB::table("customer_invoices")->whereRaw("date(customer_invoices.ci_created_at) >= '" . $start_date . "' AND date(customer_invoices.ci_created_at) <= '" . $end_date . "'")->get()->sum("ci_whipp_amount");
                $driver = DB::table("customer_invoices")->whereRaw("date(customer_invoices.ci_created_at) >= '" . $start_date . "' AND date(customer_invoices.ci_created_at) <= '" . $end_date . "'")->get()->sum("ci_driver_amount");
            }

            if (!empty($category)) {
                $bankCom = DB::table("customer_invoices")->where('ci_vehicle_category', $category)->get()->sum("ci_bank_amount");
                $netInvoice = DB::table("customer_invoices")->where('ci_vehicle_category', $category)->get()->sum("ci_net_invoice");
                $whipp = DB::table("customer_invoices")->where('ci_vehicle_category', $category)->get()->sum("ci_whipp_amount");
                $driver = DB::table("customer_invoices")->where('ci_vehicle_category', $category)->get()->sum("ci_driver_amount");
            }

            if (!empty($status)) {
                $bankCom = DB::table("customer_invoices")->leftJoin('ride_booking_schedules', 'customer_invoices.ci_ride_id', '=', 'ride_booking_schedules.id')->where(['ride_booking_schedules.rbs_ride_status'=> $status])->get()->sum("ci_bank_amount");
                $netInvoice = DB::table("customer_invoices")->leftJoin('ride_booking_schedules', 'customer_invoices.ci_ride_id', '=', 'ride_booking_schedules.id')->where(['ride_booking_schedules.rbs_ride_status'=> $status])->get()->sum("ci_net_invoice");
                $whipp = DB::table("customer_invoices")->leftJoin('ride_booking_schedules', 'customer_invoices.ci_ride_id', '=', 'ride_booking_schedules.id')->where(['ride_booking_schedules.rbs_ride_status'=> $status])->get()->sum("ci_whipp_amount");
                $driver = DB::table("customer_invoices")->leftJoin('ride_booking_schedules', 'customer_invoices.ci_ride_id', '=', 'ride_booking_schedules.id')->where(['ride_booking_schedules.rbs_ride_status'=> $status])->get()->sum("ci_driver_amount");
            }
        }
        return response()->json(['bankCom' => number_format($bankCom, 3, ".", ","), 'netInvoice' => number_format($netInvoice, 3, ".", ","), 'whipp' => number_format($whipp, 3, ".", ","), 'driver' => number_format($driver, 3, ".", ",")]);
    }

    /**
     * Show the form for creating a new Customer Invoices.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.EarningAnalysis.create');
    }

    /**
     * Store a newly created Customer Invoices in storage.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function store(Request $request)
    {
        return view('admin.EarningAnalysis.show');
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified Customer Invoices from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        CustomerInvoice::where('id', $id)->delete();
        return response()->json(['success' => true, 'message' => trans('adminMessages.country_deleted')]);
    }

    /**
     * Get Customer Invoices By country Filter
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function getDataByCountry(Request $request)
    {
        if ($request->ajax()) {
            $invoices = CustomerInvoice::with('passenger', 'driver')->where('category', $request->category)->orderBy('customer_invoices.ci_created_at', 'DESC')->get();
            return Datatables::of($invoices)
                ->addColumn('invoice_date', function ($invoices) {
                    if (!empty($invoices->ci_invoice_date)) {
                        return Utility:: convertTimeToUSERzone($invoices->ci_invoice_date,Utility::getUserTimeZone(auth()->guard('admin')->user()->time_zone_id));
                    }
                })
                ->addColumn('trx_id', function ($invoices) {
                    if (!empty($invoices->ci_Trx_id)) {
                        $trx_id = $invoices->ci_Trx_id;
                        return $trx_id;
                    }
                })
                ->addColumn('inv_id', function ($invoices) {
                    if (!empty($invoices->ci_invoice_id)) {
                        $inv_id = $invoices->ci_invoice_id;
                        return $inv_id;
                    }
                })
                ->addColumn('ride_status', function ($invoices) {
                    if (!empty($invoices->ci_ride_id)) {
                        $ride = RideBookingSchedule::where('id', $invoices->ci_ride_id)->first();
                        if (!empty($ride)){
                            $rideStatus = $ride->rbs_ride_status;
                            return $rideStatus;
                        }else{
                            $rideStatus = 'Not Found';
                            return $rideStatus;
                        }
                    }
                })
                ->addColumn('category', function ($invoices) {
                    if (!empty($invoices->ci_vehicle_category)) {
                        return $invoices->ci_vehicle_category;
                    }
                })
                ->addColumn('driver_details', function ($invoices) {
                    //  dd($invoices->driver);
                    if (isset($invoices->driver)) {
                        $driver = '<b>Vehicle#</b><span>123</span><br>' . '<b>Mobile:</b><span>' . $invoices->driver->du_full_mobile_number . '</span><br>' . '<b>Name:</b><span>' . $invoices->driver->du_full_name . '</span><br>' . '<b>Company:</b><span>' . $invoices->driver->du_com_id . '</span><br>';
                        return $driver;
                    }
                })
                ->addColumn('passenger_detail', function ($invoices) {
                    if (!empty($invoices->passenger)) {
                        $passenger = '<b>Customer Id:</b><span>' . $invoices->passenger->id . '</span><br>' . '<b> Mobile#</b><span>' . $invoices->passenger->mobile_no . '</span><br>' . '<b>Name:</b><span>' . $invoices->passenger->name . '</span><br>';
                        return $passenger;
                    }
                })
                ->addColumn('payment_mode', function ($invoices) {
                    if (!empty($invoices->ci_payment_mode)) {
                        return $invoices->ci_payment_mode;
                    }
                })
                ->addColumn('customer_invoice_amount', function ($invoices) {
                    if (!empty($invoices->ci_customer_invoice_amount)) {
                        return number_format($invoices->ci_customer_invoice_amount, 3, ".", ",");
                    }
                })
                ->addColumn('bank_commission', function ($invoices) {
                    if (!empty($invoices->ci_bank_amount)) {
                        return number_format($invoices->ci_bank_amount, 3, ".", ",");
                    }
                })
                ->addColumn('net_invoice', function ($invoices) {
                    if (!empty($invoices->ci_net_invoice)) {
                        return number_format($invoices->ci_net_invoice, 3, ".", ",");
                    }
                })->addColumn('company_gross_earning', function ($dailyEarnings) {
                    if (!empty($dailyEarnings->ci_company_gross_earning)) {
                        return number_format($dailyEarnings->ci_company_gross_earning, 3, ".", ",");
                    }
                })->addColumn('company_net_earning', function ($dailyEarnings) {
                    if (!empty($dailyEarnings->ci_company_net_earning)) {
                        return number_format($dailyEarnings->ci_company_net_earning, 3, ".", ",");
                    }
                })
                ->addColumn('whipp', function ($invoices) {
                    if (!empty($invoices->ci_whipp_amount)) {
                        return number_format($invoices->ci_whipp_amount, 3, ".", ",");
                    }
                })
                ->addColumn('driver', function ($invoices) {
                    if (!empty($invoices->ci_driver_amount)) {
                        return number_format($invoices->ci_driver_amount, 3, ".", ",");
                    }
                })
                ->addColumn('action', function ($invoices) {
                    $invoiceDetail = '<a type="button" data-invid="' . $invoices->id . '" class="delete-single btn btn-sm btn-outline-info waves-effect waves-light"  data-placement="top" ><i class="fas fa-trash font-size-16 align-middle"></i></a>';
                    return $invoiceDetail;
                })
                ->rawColumns(['action', 'driver_details','trx_id','inv_id','ride_status', 'passenger_detail', 'company_gross_earning', 'company_net_earning'])
                ->make(true);
        }
        return response()->json(['success' => true]);
    }

    /**
     * Get Specified Customer Invoices Detail
     * @param $invoiceId
     * @return Factory|View
     */
    public function invoicesDetails($invoiceId)
    {
        $detailsInvoice = CustomerInvoice::with('passenger', 'driver')->where('id', $invoiceId)->first();
        if (!empty($detailsInvoice->ci_ride_id)) {
            $ride_id = $detailsInvoice->ci_ride_id;
            $rideData = RideBookingSchedule::where('id', $ride_id)->first();
            if (!empty($rideData)) {
                $sourceLat = floatval($rideData->rbs_source_lat);
                $sourceLong = floatval($rideData->rbs_source_long);
                $desLat = floatval($rideData->rbs_destination_lat);
                $desLong = floatval($rideData->rbs_destination_long);
                $pickup_location = app('geocoder')->reverse($sourceLat, $sourceLong)->get()->first();
                $drop_off = app('geocoder')->reverse($desLat, $desLong)->get()->first();
                $address = '<div class="box-style"><div class="locBox"><i class="fas fa-map-marker-alt"></i>&nbsp;<span>Pickup Location: </span><br><span>' . $pickup_location->getFormattedAddress() . '</span>' . '</div><br><div class="locBox"><i class="fas fa-map-pin"></i>&nbsp;<span>Dropoff Location: </span><br><span>' . $drop_off->getFormattedAddress() . '</span></div></div>';
                $socialLinks = BaseAppSocialLinks::all();
            } else {
                $address = 'No Address';
                $socialLinks = BaseAppSocialLinks::all();
            }
        }
        return view('admin.EarningAnalysis.reciept', ['detailsInvoice' => $detailsInvoice, 'address' => $address, 'socialLinks' => $socialLinks]);
    }
}
