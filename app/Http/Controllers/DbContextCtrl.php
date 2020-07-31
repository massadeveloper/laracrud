<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Item;
use App\OrderItems;
use App\Orders;
use App\Component;


class DbContextCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function getComponent($nomecomponent)
    {


        $cmp = Component::where('nome_component',$nomecomponent)->count();

        if($cmp == 0 )
        {
            return 'NON CE NESSUNO COMPONENTE';
        }


        dd($cmp);

        switch ($nomecomponent) {
            case 'customer':
                $items = Customer::all();
              break;
            case 'item':
                $items = Item::all();
              break;
            case 'orderitems':
                $items = OrderItems::all();
              break;
            case 'orders':
                $items = OrderItems::all();
              break;
            default:
              $items = [];
        }

        return response()->json( [$items] );
    }


    public function postComponent(Request $req)
    {
            dd($req->all());
    }


    private ckeckComponent($nomecomponent)
    {
        $cmp = Component::where('nome_component',$nomecomponent)->count();

        if($cmp == 0 )
        {
            return 'NON CE NESSUNO COMPONENTE';
        }


        switch ($nomecomponent) {
            case 'customer':
                $items = Customer::all();
              break;
            case 'item':
                $items = Item::all();
              break;
            case 'orderitems':
                $items = OrderItems::all();
              break;
            case 'orders':
                $items = OrderItems::all();
              break;
            default:
              $items = [];
        }
    }

}
