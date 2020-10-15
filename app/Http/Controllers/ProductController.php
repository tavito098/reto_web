<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('created_at', 'DESC')->get();
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
        return response()->json($data);
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
            $image      = $request->file('image');
            $fileName   = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('productImages')->put($fileName, 'Contents');
        }

        $category_id = (is_numeric($request->category)) ? $request->category : $this->setCategory($request->category);

        $product = Product::create([
            'category_id' => $category_id,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $fileName,
            'price' => $request->price
        ]);

        return response()->json($product);
    }

    public function setCategory($name) 
    {
        return Category::create(['name' => $name])->id;
    }
}
