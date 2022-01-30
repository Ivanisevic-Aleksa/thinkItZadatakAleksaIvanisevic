<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use Image;

class ShopService 
{
    public function users(Request $request){
        return User::all();
    }

    public function categories(Request $request){
        return CategoryModel::all();
    }

    public function categoryDelete(Request $request, $category_id){
        CategoryModel::query()->where('id', (int)$category_id)->delete();
        return 'Category deleted!';
    }

    public function categoryUpdate(Request $request){
        if(CategoryModel::query()->where('name', Str::lower($request->get('name')))->exists()){
            return 'Category already exists!';
        }else{
            CategoryModel::query()->where('id', (int)$request->get('id'))->update(['name' => Str::lower($request->get('name'))]);
            return 'Category updated!';
        }
    }

    public function categoryAdd(Request $request){
        if(CategoryModel::query()->where('name', Str::lower($request->get('name')))->exists()){
            return 'Category already exists!';
        }else{
            CategoryModel::create(['name' => Str::lower($request->input('name'))]);
            return 'Category added!';
        }
    }

    public function categoryList(Request $request){
        return CategoryModel::query()->select('id','name')->get()->toArray();
    }

    public function products(Request $request){
        return ProductModel::query()->with('category')->get();
    }

    public function productAdd(Request $request){
        $productNumber = trim($request->get('number'));
        if(ProductModel::query()->where('number', $productNumber)->exists()){
            return 'Product number exists!';
        }

        $productData = $this->storeProductData($request, false);
        
        $this->storeProductImage($productData, $request->file('file'));
        return 'Product added!';
    }

    public function productDelete(Request $request, $product_id){
        $getFileInfo = ProductModel::query()->select('image_name')->where('id', (int)$product_id)->get()->toArray()[0];
        ProductModel::query()->where('id', (int)$product_id)->delete();
        $this->deleteImage($getFileInfo['image_name']);
        return 'Product deleted!';
    }

    public function productUpdate(Request $request){
        $productData = $this->storeProductData($request, true);
        $this->deleteImage($productData['filename']);
        $this->storeProductImage($productData, $request->file('file'));
        return 'Product updated!';
    }

    private function storeProductData($request, $update){

        $category_id = (int)$request->get('category');
        $number = trim($request->get('number'));
        $name = trim($request->get('name'));
        $about = trim($request->get('about'));
        $price = (int)trim($request->get('price'));
        $fileName = trim($request->get('number')) .'.'. Str::lower($request->file('file')->getClientOriginalExtension());

        if(!$update){
            $insertArray = [
                'category_id' => $category_id,
                'number' => $number,
                'name' => $name,
                'about' => $about,
                'price' => $price,
                'image_name' => $fileName,
            ];
            ProductModel::create($insertArray);
            return ['filename' => $fileName];
        }else{
            $insertArray = [
                'category_id' => $category_id,
                'name' => $name,
                'about' => $about,
                'price' => $price,
                'image_name' => $fileName,
            ];
            ProductModel::query()->where('number', $number)->update($insertArray);
            return ['filename' => $fileName];
        }
        
    }

    private function storeProductImage($filename, $file){
        $path = 'images/';
        $image = Image::make($file);
        $image->resize(200,200);
        $image->encode(Str::lower($file->getClientOriginalExtension()));
        Storage::disk('local')->put($path . $filename['filename'], $image->__toString());
    }

    private function deleteImage($imageName){
        Storage::disk('local')->delete('/images/'.$imageName);
    }
}