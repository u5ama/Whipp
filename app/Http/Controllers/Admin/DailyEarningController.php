<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\CustomerInvoice;
use App\RideBookingSchedule;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use App\Utility\Utility;
use DB;


class DailyEarningController extends Controller
{
    /**
     * Display a listing of the DailyEarning.
     *
     * @param Request $request
     * @return Factory|View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $companies = Company::all();
        if ($request->ajax()) {
            $start_date = (!empty($_GET["start_date"])) ? ($_GET["start_date"]) : ('');
            $end_date = (!empty($_GET["end_date"])) ? ($_GET["end_date"]) : ('');
            $company = (!empty($_GET["company"])) ? ($_GET["company"]) : ('');
            $status = (!empty($_GET["filterWithCategory"])) ? ($_GET["filterWithCategory"]) : ('');

            if ($start_date && $end_date) {
                if ($company) {
                    $start_date = date('Y-m-d', strtotime($start_date));
                    $end_date = date('Y-m-d', strtotime($end_date));
                    $dailyEarnings = CustomerInvoice::query()->whereRaw("date(customer_invoices.ci_created_at) >= '" . $start_date . "' AND date(customer_invoices.ci_created_at) <= '" . $end_date . "'")->leftjoin('drivers', 'customer_invoices.ci_driver_id', '=', 'drivers.id')->where('drivers.du_com_id', $company)->orderBy('customer_invoices.ci_created_at', 'DESC')->with('passenger', 'driver')
                    ->select(array('customer_invoices.ci_ride_id','customer_invoices.ci_vehicle_category','customer_invoices.ci_payment_mode',
                    DB::Raw('sum(customer_invoices.ci_customer_invoice_amount) as customer_invoice_amount'),
                    DB::Raw('sum(customer_invoices.ci_bank_amount) as bank_amount'),
                    DB::Raw('sum(customer_invoices.ci_net_invoice) as net_invoice'),
                    DB::Raw('sum(customer_invoices.ci_whipp_amount) as whipp_amount'),
                    DB::Raw('sum(customer_invoices.ci_company_gross_earning) as company_gross_earning'),
                    DB::Raw('sum(customer_invoices.ci_company_net_earning) as company_net_earning'),
                    DB::Raw('sum(customer_invoices.ci_driver_amount) as driver_amount'),
                    DB::Raw('DATE(customer_invoices.ci_invoice_date) as ci_invoice_date')))
                ->groupBy([
                    DB::raw('DATE(customer_invoices.ci_created_at)'),
                    
                    DB::raw('customer_invoices.ci_vehicle_category'),
                    DB::raw('customer_invoices.ci_payment_mode'),
                    
                ])
                    ->get();

                } else {
                    $start_date = date('Y-m-d', strtotime($start_date));
                    $end_date = date('Y-m-d', strtotime($end_date));
                    $dailyEarnings = CustomerInvoice::query()->whereRaw("date(customer_invoices.ci_created_at) >= '" . $start_date . "' AND date(customer_invoices.ci_created_at) <= '" . $end_date . "'")->orderBy('customer_invoices.ci_created_at', 'DESC')->with('passenger', 'driver')
                    ->select(array('customer_invoices.ci_ride_id','customer_invoices.ci_vehicle_category','customer_invoices.ci_payment_mode',
                    DB::Raw('sum(customer_invoices.ci_customer_invoice_amount) as customer_invoice_amount'),
                    DB::Raw('sum(customer_invoices.ci_bank_amount) as bank_amount'),
                    DB::Raw('sum(customer_invoices.ci_net_invoice) as net_invoice'),
                    DB::Raw('sum(customer_invoices.ci_whipp_amount) as whipp_amount'),
                    DB::Raw('sum(customer_invoices.ci_company_gross_earning) as company_gross_earning'),
                    DB::Raw('sum(customer_invoices.ci_company_net_earning) as company_net_earning'),
                    DB::Raw('sum(customer_invoices.ci_driver_amount) as driver_amount'),
                    DB::Raw('DATE(customer_invoices.ci_invoice_date) as ci_invoice_date')))
                ->groupBy([
                    DB::raw('DATE(customer_invoices.ci_created_at)'),
                    
                    DB::raw('customer_invoices.ci_vehicle_id'),
                    DB::raw('customer_invoices.ci_payment_mode'),
                    
                ])
                    ->get();

                }
            } elseif ($company) {
                $currentDate = date('Y-m-d');
                $dailyEarnings = CustomerInvoice::leftjoin('drivers', 'customer_invoices.ci_driver_id', '=', 'drivers.id')->where('drivers.du_com_id', $company)->whereDate("customer_invoices.ci_created_at", $currentDate)->orderBy('customer_invoices.ci_created_at', 'DESC')->with('passenger', 'driver')
                ->select(array('customer_invoices.ci_ride_id','customer_invoices.ci_vehicle_category','customer_invoices.ci_payment_mode',
                    DB::Raw('sum(customer_invoices.ci_customer_invoice_amount) as customer_invoice_amount'),
                    DB::Raw('sum(customer_invoices.ci_bank_amount) as bank_amount'),
                    DB::Raw('sum(customer_invoices.ci_net_invoice) as net_invoice'),
                    DB::Raw('sum(customer_invoices.ci_whipp_amount) as whipp_amount'),
                    DB::Raw('sum(customer_invoices.ci_company_gross_earning) as company_gross_earning'),
                    DB::Raw('sum(customer_invoices.ci_company_net_earning) as company_net_earning'),
                    DB::Raw('sum(customer_invoices.ci_driver_amount) as driver_amount'),
                    DB::Raw('DATE(customer_invoices.ci_invoice_date) as ci_invoice_date')))
                ->groupBy([
                    DB::raw('DATE(customer_invoices.ci_created_at)'),
                    
                    DB::raw('customer_invoices.ci_vehicle_id'),
                    DB::raw('customer_invoices.ci_payment_mode'),
                    
                ])
                ->get();
            } elseif ($status) {
                $currentDate = date('Y-m-d');
                $dailyEarnings = CustomerInvoice::leftJoin('ride_booking_schedules', 'customer_invoices.ci_ride_id', '=', 'ride_booking_schedules.id')->where(['ride_booking_schedules.rbs_ride_status'=> $status])->whereDate("customer_invoices.ci_created_at", $currentDate)->with('passenger', 'driver')
                ->select(array('ci_ride_id','ci_vehicle_category','ci_payment_mode',
                    DB::Raw('sum(customer_invoices.ci_customer_invoice_amount) as customer_invoice_amount'),
                    DB::Raw('sum(customer_invoices.ci_bank_amount) as bank_amount'),
                    DB::Raw('sum(customer_invoices.ci_net_invoice) as net_invoice'),
                    DB::Raw('sum(customer_invoices.ci_whipp_amount) as whipp_amount'),
                    DB::Raw('sum(customer_invoices.ci_company_gross_earning) as company_gross_earning'),
                    DB::Raw('sum(customer_invoices.ci_company_net_earning) as company_net_earning'),
                    DB::Raw('sum(customer_invoices.ci_driver_amount) as driver_amount'),
                    DB::Raw('DATE(customer_invoices.ci_invoice_date) as ci_invoice_date')))
                 ->groupBy([
                    DB::raw('DATE(customer_invoices.ci_created_at)'),
                    DB::raw('customer_invoices.ci_payment_mode'),
                    DB::raw('customer_invoices.ci_vehicle_id'),
                    
                ])

                ->orderBy('customer_invoices.ci_created_at', 'DESC')->get();
            }else {
                $currentDate = date('Y-m-d');
                $dailyEarnings = CustomerInvoice::Join('ride_booking_schedules', 'customer_invoices.ci_ride_id', '=', 'ride_booking_schedules.id')->with('passenger', 'driver')->whereDate("customer_invoices.ci_created_at", $currentDate)
                 ->select(array('customer_invoices.ci_ride_id','customer_invoices.ci_vehicle_category','customer_invoices.ci_payment_mode',
                    DB::Raw('sum(customer_invoices.ci_customer_invoice_amount) as customer_invoice_amount'),
                    DB::Raw('sum(customer_invoices.ci_bank_amount) as bank_amount'),
                    DB::Raw('sum(customer_invoices.ci_net_invoice) as net_invoice'),
                    DB::Raw('sum(customer_invoices.ci_whipp_amount) as whipp_amount'),
                    DB::Raw('sum(customer_invoices.ci_company_gross_earning) as company_gross_earning'),
                    DB::Raw('sum(customer_invoices.ci_company_net_earning) as company_net_earning'),
                    DB::Raw('sum(customer_invoices.ci_driver_amount) as driver_amount'),
                    DB::Raw('DATE(customer_invoices.ci_invoice_date) as ci_invoice_date')))
                ->groupBy([
                    DB::raw('DATE(customer_invoices.ci_created_at)'),
                    
                    DB::raw('customer_invoices.ci_vehicle_id'),
                    DB::raw('customer_invoices.ci_payment_mode'),
                    
                ])
                ->orderBy('customer_invoices.ci_created_at', 'DESC')
                ->get();

            }

            return Datatables::of($dailyEarnings)
                ->addColumn('invoice_date', function ($dailyEarnings) {
                    return $dailyEarnings->ci_invoice_date;
                })

                ->addColumn('ride_status', function ($dailyEarnings) {
                    if (!empty($dailyEarnings->ci_ride_id)) {
                        $ride = RideBookingSchedule::where('id', $dailyEarnings->ci_ride_id)->first();
                        if (!empty($ride)){
                            $rideStatus = $ride->rbs_ride_status;
                            return $rideStatus;
                        }else{
                            $rideStatus = 'Not Found';
                            return $rideStatus;
                        }
                    }
                })
                ->addColumn('category', function ($dailyEarnings) {
                    if (!empty($dailyEarnings->ci_vehicle_category)) {
                        return $dailyEarnings->ci_vehicle_category;
                    }
                })

                ->addColumn('payment_mode', function ($dailyEarnings) {
                    if (!empty($dailyEarnings->ci_payment_mode)) {
                        return $dailyEarnings->ci_payment_mode;
                    }
                })
                ->addColumn('customer_invoice_amount', function ($dailyEarnings) {
                    if (!empty($dailyEarnings->customer_invoice_amount)) {
                        return number_format($dailyEarnings->customer_invoice_amount, 3, ".", ",");
                    }
                })
                ->addColumn('bank_commission', function ($dailyEarnings) {
                    if (!empty($dailyEarnings->bank_amount)) {
                        return number_format($dailyEarnings->bank_amount, 3, ".", ",");
                    }
                })
                ->addColumn('net_invoice', function ($dailyEarnings) {
                    if (!empty($dailyEarnings->net_invoice)) {
                        return number_format($dailyEarnings->net_invoice, 3, ".", ",");
                    }
                })
                ->addColumn('whipp', function ($dailyEarnings) {
                    if (!empty($dailyEarnings->whipp_amount)) {
                        return number_format($dailyEarnings->whipp_amount, 3, ".", ",");
                    }
                })->addColumn('company_gross_earning', function ($dailyEarnings) {
                    if (!empty($dailyEarnings->company_gross_earning)) {
                        return number_format($dailyEarnings->company_gross_earning, 3, ".", ",");
                    }
                })->addColumn('company_net_earning', function ($dailyEarnings) {
                    if (!empty($dailyEarnings->company_net_earning)) {
                        return number_format($dailyEarnings->company_net_earning, 3, ".", ",");
                    }
                })
                ->addColumn('driver', function ($dailyEarnings) {
                    if (!empty($dailyEarnings->driver_amount)) {
                        return number_format($dailyEarnings->driver_amount, 3, ".", ",");
                    }
                })
                ->addColumn('action', function ($dailyEarnings) {
                    $invoiceDetail = '<a type="button" data-invid="' . $dailyEarnings->id . '" class="delete-single btn btn-sm btn-outline-info waves-effect waves-light"  data-placement="top" ><i class="fas fa-trash font-size-16 align-middle"></i></a>';
                    return $invoiceDetail;
                })
                ->rawColumns(['action', 'driver_details', 'passenger_detail', 'ride_detail', 'company_gross_earning', 'company_net_earning'])
                ->make(true);
        }
        return view('admin.DailyEarning.index', compact('companies'));
    }

    /**
     * Show the form for creating a new DailyEarning.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.DailyEarning.create');
    }

    /**
     * Store a newly created DailyEarning in storage.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function store(Request $request)
    {
        return view('admin.DailyEarning.show');
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
     * Show the form for editing the specified DailyEarning.
     *
     * @param int $id
     * @return void
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified DailyEarning in storage.
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
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        CustomerInvoice::where('id', $id)->delete();
        return response()->json(['success' => true, 'message' => trans('adminMessages.invoice_deleted')]);
    }
}
