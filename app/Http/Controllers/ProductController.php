<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('created_at', 'DESC')->get();
        $data = $this->dataTableProduct($products);
        return response()->json($data);
    }

    public function dataTableProduct($products)
    {
        $data = [];
        foreach($products as $product)
        {
            $formData = [
                'image' => ($product->image == null) ? 'default.png' : $product->image,
                'category' => $product->category['name'],
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'options' => $product->id
            ];
            array_push($data, $formData);
        }
        return $data;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category' => 'required',
            'name' => 'required',
            'price'    => 'required'
        ]);
        $fileName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(public_path('images/products'), $fileName);
        }

        $category_id = (is_numeric($request->category)) ? $request->category : $this->setCategory($request->category);

        $product = Product::updateOrCreate(
            ['id' => $request->product_id],
            [
                'category_id' => $category_id,
                'name' => $request->name,
                'description' => $request->description,
                'image' => $fileName,
                'price' => $request->price
            ]
        );
        return response()->json($product);
    }

    public function edit($id)
    {
        $product = Product::with('category')->where('id', $id)->first();
        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json($product);
    }

    public function searchProducByDates($initDate, $endDate)
    {
        $initDate = date('Y-m-d 00:00:00', strtotime($initDate));
        $endDate = date('Y-m-d 23:59:59', strtotime($endDate));
        $products = Product::with('category')->whereBetween('created_at', [$initDate, $endDate])->get();
        $data = $this->dataTableProduct($products);
        return response()->json($data);
    }

    public function setCategory($name) 
    {
        return Category::create(['name' => $name])->id;
    }
}
