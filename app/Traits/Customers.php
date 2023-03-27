<?php
namespace App\Traits;

use App\Models\Customers as ModelsCustomers;
use Illuminate\Http\Request;

trait Customers {


    public function add_new_customers_page () 
    {
        return view("customers.create");
    }
    
    public function add_new_customers(Request $request)
    {
        $name = $request->input("name");
        $phone = $request->input("phone");

        $customer_model = new ModelsCustomers();
        $customer_model->name = $name;
        $customer_model->phone = $phone;
        $customer_model->save();

        return redirect()->back()->with("success","Customer Added Successfully1");

    }


    public function list_customers_page()
    {
        $customer_model = new ModelsCustomers();
        $customers = $customer_model->paginate(15);
        return view("customers.list",compact("customers"));
        
    }

    public function customer_history_page($id)
    {

    }

    public function edit_customers_page($id)
    {
        $customer_model = new ModelsCustomers();
        $customer = $customer_model->where('id',$id)->first();
        return view("customers.edit",compact("customer"));
    }

    public function edit_customers(Request $request)
    {
        $name = $request->input("name");
        $phone = $request->input("phone");
        $id = $request->input("id");


        $customer_model = new ModelsCustomers();

        $customer_model->where('id',$id)->update([
            "name"=>$name,
            "phone"=>$phone
        ]);

        session()->flash('success', 'Customer Account edited!');
        return redirect()->back();
    }

    public function delete_customer($id)
    {
        $customer_model = new ModelsCustomers();
        $customer_model->where('id',$id)->delete();
        session()->flash('success', 'Customer Account deleted!');
        return redirect()->back();
    }

}