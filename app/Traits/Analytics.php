<?php

namespace App\Traits;

use App\Models\Customers;
use App\Models\Laundry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait Analytics
{

    public function getCurrentMonthSales()
    {
        $orders_model = new Laundry();
        $currentMonth = Carbon::now()->month;

        $orders = $orders_model->whereMonth("created_at", $currentMonth)->get();
        $order_count = count($orders);
        $total_amount = 0;

        $currentDate =  $currentDate = Carbon::today();
        $status = "processing";
        $processing_orders = $orders_model->whereDate("created_at", $currentDate)->where('status', $status)->get()->count();

        foreach ($orders as $key => $value) {
            $total_amount += $value->total_cost;
        }
        $total_amount = number_format($total_amount, 2);


        return ["order_count" => $order_count, "total_amount" => $total_amount, "processing_orders" => $processing_orders];
    }

    public function allSalesWithCustomer()
    {
        $orders_model = new Laundry();


        $orders = $orders_model->get();

        $order_count = count($orders);
        $total_amount = $this->get_total_amount($orders);
        $total_amount = number_format($total_amount, 2);
        $orders_paginate = DB::table('laundries')
            ->join('customers', 'laundries.customer_id', '=', 'customers.id')
            ->select('laundries.*', 'customers.name', 'customers.phone')
            ->orderBy("created_at", 'DESC')
            ->paginate(10);


        return ["order_count" => $order_count, "total_amount" => $total_amount, "orders_paginate" => $orders_paginate];
    }

    public function allSalesWithCustomerFilter(Request $request)
    {

        $from_date = $request->input("from_date") ?? session()->get('session_filters')['from_date'] ?? "";
        $from_date = date("Y-m-d",strtotime($from_date));
        $to_date = $request->input("to_date") ?? session()->get('session_filters')['to_date'] ?? "";
        $to_date = date("Y-m-d",strtotime($to_date));
        $customer =  $request->input("customer") ?? session()->get('session_filters')['customer'] ?? "";
        $order_status = $request->input("order_status") ?? session()->get('session_filters')['order_status'] ?? "";
        $payment_status = $request->input("payment_status") ?? session()->get('session_filters')['payment_status'] ?? "";
        $filer_Session = [];
        $error_msg = [];




        $orders_model = new Laundry();

        $orders_query = DB::table('laundries')
            ->join('customers', 'laundries.customer_id', '=', 'customers.id')
            ->select('laundries.*', 'customers.name', 'customers.phone')
            ->orderBy("created_at", 'DESC');

            if ($from_date > $to_date) {
                $error_msg[] = "From Date can not be greater than To Date!";
            } elseif ($to_date < $from_date) {
                $error_msg[] = "To Date can not be lesser than From Date!";
            } else {
                $filer_Session['from_date'] = $from_date;
                $filer_Session['to_date'] = $to_date;
            
                if ($from_date == $to_date) {
                    $orders_query = $orders_query->whereDate("laundries.created_at", $from_date);
                } else {
                    $orders_query = $orders_query->whereBetween("laundries.created_at", [$from_date, $to_date]);
                }
            }
            
            

        if ($customer != "") {
            $filer_Session['customer'] = $customer;
            $orders_query = $orders_query->where("customers.phone", $customer);
        }

        if ($payment_status != "") {

            $filer_Session['payment_status'] = $payment_status;
            $orders_query = $orders_query->where("laundries.payment_status", $payment_status);
        }

        if ($order_status != "") {

            $filer_Session['order_status'] = $order_status;
            $orders_query = $orders_query->where("laundries.status", $order_status);
        }

        $orders_paginate =  $orders_query->paginate(10);
        $order_count = $orders_paginate->total();
        $orders = $orders_query->get();
        $total_amount = $this->get_total_amount($orders);
        $total_amount = number_format($total_amount, 2);

        session()->put("session_filters", $filer_Session);



        return [
            "order_count" => $order_count, 
            "total_amount" => $total_amount, 
            "orders_paginate" => $orders_paginate,
            "error_msg"=>$error_msg
        ];
    }

    public function customer_count()
    {
        $customer_model = new Customers();

        $customer = $customer_model->get();
        $customer_count = count($customer);

        return ['customer_count' => $customer_count];
    }

    public function get_total_amount($orders)
    {
        $total_amount = 0;
        foreach ($orders as $key => $value) {
            $total_amount += $value->total_cost;
        }
        return $total_amount;
    }
}
