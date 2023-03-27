<?php

namespace App\Traits;

use App\Models\Customers;
use App\Models\Laundry;
use App\Models\LaundryImages;
use App\Models\Shelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

trait LaundryFunctions
{


    public function laundry_create_page()
    {
        // dd(session()->get('laundry_basket'));
        $customer_model = new Customers();
        $customers = $customer_model->get();
        return view("laundry.create", compact("customers"));
    }


    public function laundry_create(Request $request)
    {
        $laundry_basket = session()->get("laundry_basket");
        $order_info = session()->get("laundry_order_info");
        $order_items = json_encode(session()->get("laundry_basket"));
        $total_cost = $this->basket_total_cost();

        /* this here will prevent the system from breaking when session has been cleared but user somehow still gets to submit create button */
        if ($total_cost == false) {
            return redirect()->route("laundry.create");
        }

        $laundry_model = new Laundry();
        $laundry_model->order_items = $order_items;
        $laundry_model->customer_id = $order_info['customer'];
        $laundry_model->date = $order_info['laundry_date'];
        $laundry_model->total_cost = $total_cost;
        // $laundry_model->payment_mode = $order_info['payment_mode'];
        $laundry_model->payment_status = $order_info['payment_status'];
        $laundry_model->order_number = $this->generate_order_id();


        $laundry_model->save();
        $this->laundry_basket_clear();

        return redirect()->to("dashboard/laundry/basket/view/receipt" . "/" . $laundry_model->order_number);
    }

    public function laundry_basket_remove($id)
    {

        $laundry_basket = session()->get("laundry_basket");
        unset($laundry_basket[$id]);
        $laundry_basket = array_values($laundry_basket);
        session()->put("laundry_basket", $laundry_basket);
        return response()->json([], 200);
    }

    public function laundry_basket_add(Request $request)
    {
        $customer = $request->input('customer');
        $description = $request->input('description');
        $laundry_type = $request->input('laundry_type');
        if ($laundry_type == "Others") {

            $laundry_type = $request->input('laundry_type_other');
        }
        $laundry_date = $request->input('laundry_date');
        $quantity = $request->input('quantity');
        $cost = $request->input('cost');
        $payment_status = $request->input('payment_status');



        $laundry_order_info = [
            'customer' => $customer,
            'laundry_date' => $laundry_date,
            "payment_status" => $payment_status
        ];

        session()->put("laundry_order_info", $laundry_order_info);

        if ($laundry_type == "") {
            $laundry_type = "NA";
        }
        if ($description == "") {
            $description = "NA";
        }

        if (session()->has("laundry_basket")) {
            $laundry_basket = session()->get("laundry_basket");
        } else {
            session()->put("laundry_basket", []);
            $laundry_basket = session()->get("laundry_basket");
        }

        $data = [
            'description' => $description,
            'laundry_type' => $laundry_type,
            'quantity' => $quantity, "cost" => $cost
        ];

        array_push($laundry_basket, $data);
        session()->put("laundry_basket", $laundry_basket);
        $id = count(session()->get("laundry_basket")) - 1;
        $response_data = [
            "message" => "laundry added!", "type" => "success",
            'description' => $description,
            'laundry_type' => $laundry_type,
            'quantity' => $quantity, "cost" => $cost,
            "id" => $id
        ];
        return response()->json($response_data, 200);
    }

    public function laundry_basket_clear()
    {
        Session::forget("laundry_basket");
        Session::forget("laundry_order_info");
        return redirect()->back();
    }

    public function basket_total_cost()
    {
        $laundry_basket = session()->get("laundry_basket");
        $total = 0;
        if ($laundry_basket == null) {
            return false;
        }
        foreach ($laundry_basket as $key => $value) {
            $cost = $value['quantity'] * $value['cost'];
            $total += $cost;
        }
        return $total;
    }

    public function laundry_preview_page($id)
    {
        if ($id != "") {

            $laundry_model = new Laundry();
            $shelf_model = new Shelf();
            $shelves = $shelf_model->get();
            $laundry = $laundry_model->where("order_number", $id)->first();

            if (!$laundry) {
                return redirect()->to("dashboard/laundry/create/");
            }

            $customer_model = new Customers();
            $customer = $customer_model->where("id", $laundry->customer_id)->first();

            $order_date = $laundry->date;
            $order_items = json_decode($laundry->order_items, true);
            $item_count = count($order_items);
            $order_number = $laundry->order_number;
            $order_status = $laundry->status;
            $total_cost = $laundry->total_cost;
            $image_uploaded = $laundry->image_uploaded;
            $payment_mode = $laundry->payment_mode;
            $payment_status = $laundry->payment_status;
            $order_shelf = $laundry->shelf;
            





            return view("laundry.preview", compact(
                "customer",
                "order_date",
                "order_items",
                "order_number",
                "total_cost",
                "item_count",
                "image_uploaded",
                "order_status",
                "payment_mode",
                "payment_status",
                "shelves",
                "order_shelf",
               
            ));
        } elseif (session()->has("laundry_order_info") && session()->has("laundry_basket")) {
            $order_info = session()->get("laundry_order_info");
            $customer_id = $order_info['customer'];
            $order_date = $order_info['laundry_date'];
            $total_cost = number_format($this->basket_total_cost(), 2);
            $item_count = count(session()->get("laundry_basket"));

            $customer_model = new Customers();
            $customer = $customer_model->where("id", $customer_id)->first();


            return view("laundry.preview", compact("customer", "order_date", "total_cost", "item_count"));
        } else {
            return redirect()->back();
        }
    }


    public function laundry_view_receipt_page($id = "")
    {

        if ($id != "") {

            $laundry_model = new Laundry();
            $shelf_model = new Shelf();
            $shelves = $shelf_model->get();
            $laundry = $laundry_model->where("order_number", $id)->first();

            if (!$laundry) {
                return redirect()->to("dashboard/laundry/create/");
            }

            $customer_model = new Customers();
            $customer = $customer_model->where("id", $laundry->customer_id)->first();

            $order_date = $laundry->date;
            $order_items = json_decode($laundry->order_items, true);
            $item_count = count($order_items);
            $order_number = $laundry->order_number;
            $order_status = $laundry->status;
            $total_cost = $laundry->total_cost;
            $image_uploaded = $laundry->image_uploaded;
            $payment_mode = $laundry->payment_mode;
            $payment_status = $laundry->payment_status;
            $order_shelf = $laundry->shelf;





            return view("laundry.view-receipt", compact(
                "customer",
                "order_date",
                "order_items",
                "order_number",
                "total_cost",
                "item_count",
                "image_uploaded",
                "order_status",
                "payment_mode",
                "payment_status",
                "shelves",
                "order_shelf"
            ));
        } elseif (session()->has("laundry_order_info") && session()->has("laundry_basket")) {
            $order_info = session()->get("laundry_order_info");
            $customer_id = $order_info['customer'];
            $order_date = $order_info['laundry_date'];
            $total_cost = number_format($this->basket_total_cost(), 2);
            $item_count = count(session()->get("laundry_basket"));

            $customer_model = new Customers();
            $customer = $customer_model->where("id", $customer_id)->first();


            return view("laundry.view-receipt", compact("customer", "order_date", "total_cost", "item_count"));
        } else {
            return redirect()->back();
        }
    }


    public function generate_order_id()
    {
        $laundry_model = new Laundry();
        $new_id =  random_int(100000, 999999);;

        $check = $laundry_model->where("order_number", $new_id)->first();

        if ($check != null) {
            $this->generate_order_id();
        } else {
            return $new_id;
        }
    }

    public function laundry_gallery($id)
    {
        $image_model = new LaundryImages();
        $images = $image_model->select("id", "image_path", "name")->where('order_number', $id)->get();

        if ($images->count() < 1) {
            return redirect()->back()->with("error","No images found in gallery for this order!");
        }

        return view("laundry.laundry_gallery", compact("images"));
    }

    public function laundry_image_delete($id)
    {
        $image_model = new LaundryImages();
        $image = $image_model->where('id', $id)->first();

        if (!$image) {
            return redirect()->back();
        } else {
            // Storage::disk('local')->delete($image->image_path);
            $image = $image_model->where("id", $id)->delete();
            return redirect()->back();
        }
    }

    public function laundry_image_upload_page()
    {
        $laundry_model = new Laundry();
        $orders = $laundry_model->select("order_number")->orderBy("created_at", 'DESC')->get();
        return view("laundry.upload_image", compact("orders"));
    }

    public function laundry_image_upload(Request $request)
    {

        $order_number = $request->input("order_number");

        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $image) {
                $name = $image->getClientOriginalName();
                $ext = $image->extension();

                try {
                    $new_name = $name . "_" . time() . "." . $ext;
                    $path = $image->storeAs('laundry_images', $new_name, 'public');
                    $laundryImage = new LaundryImages();
                    $laundryImage->name = $new_name;
                    $laundryImage->order_number = $order_number;
                    $laundryImage->image_path = $path;
                    $laundryImage->save();
                } catch (\Throwable $th) {
                    dd($th);
                }
            }
        }

        $laundry_model = new Laundry();
        $laundry_model->where("order_number", $order_number)
            ->update([
                "image_uploaded" => 1
            ]);

        return redirect()->back()->with('success', 'Images uploaded successfully.');
    }

    public function laundry_orders_display_page()
    {
        $laundry_model = new Laundry();
        $orders = $laundry_model->fetch_orders();
        return view("laundry.orders", compact("orders"));
    }

    public function update_order_status(Request $request)
    {
        $order_status = $request->input("status");
        $order_number = $request->input("order_number");

        $laundry_model = new Laundry();
        $laundry_model->where("order_number", $order_number)
            ->update([
                "status" => $order_status
            ]);

        return redirect()->back();
    }

    public function update_order_payment_status(Request $request)
    {
        $order_payment_status = $request->input("payment_status");
        $order_number = $request->input("order_number");

        $laundry_model = new Laundry();
        $laundry_model->where("order_number", $order_number)
            ->update([
                "payment_status" => $order_payment_status
            ]);

        return redirect()->back();
    }

    public function update_order_payment_mode(Request $request)
    {
        $order_payment_status = $request->input("payment_mode");
        $order_number = $request->input("order_number");

        $laundry_model = new Laundry();
        $laundry_model->where("order_number", $order_number)
            ->update([
                "payment_mode" => $order_payment_status
            ]);

        return redirect()->back();
    }

    public function view_laundry_order(Request $request)
    {
        $order_number = $request->input("order_number");

        // dd("dashboard/laundry/basket/preview"."/".$order_number);
        return redirect()->to("dashboard/laundry/basket/preview" . "/" . $order_number);
    }

    public function update_order_shelf(Request $request)
    {
        $shelf = $request->input("shelf");
        $order_number = $request->input("order_number");

        $laundry_model = new Laundry();
        $laundry_model->where("order_number", $order_number)
            ->update([
                "shelf" => $shelf
            ]);

        return redirect()->back();
    }
}
