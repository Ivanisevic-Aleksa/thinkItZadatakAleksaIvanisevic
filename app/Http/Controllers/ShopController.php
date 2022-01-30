<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Services\ShopService;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    protected $shopService;

    public function __construct(ShopService $shopService){
        $this->shopService = $shopService;
    }

    public function index(){
        return view('pages.index');
    }

    public function users(){
        return view('pages.users');
    }

    public function usersAjax(Request $request){
        $data = $this->shopService->users($request);
        return response()->json(['data' => $data]);
    }

    public function categories(){
        return view('pages.categories');
    }

    public function categoriesAjax(Request $request){
        $data = $this->shopService->categories($request);
        return response()->json(['data' => $data]);
    }

    public function categoryDelete(Request $request, $category_id){
        $data = $this->shopService->categoryDelete($request, $category_id);
        return redirect()->back()->with('alert', $data);
    }

    public function categoryUpdate(Request $request){
        $data = $this->shopService->categoryUpdate($request);
        return redirect()->back()->with('alert', $data);
    }

    public function categoryAdd(Request $request){
        $data = $this->shopService->categoryAdd($request);
        return redirect()->back()->with('alert', $data);
    }

    public function products(Request $request){
        $categories = $this->shopService->categoryList($request);
        return view('pages.products', ['categories' => $categories]);
    }

    public function productsAjax(Request $request){
        $data = $this->shopService->products($request);
        return response()->json(['data' => $data]);
    }

    public function getImage(Request $request, $filename){
        $path = '/images/' . $filename;
        if (!Storage::exists($path)) {
            abort(404);
        }
        $file = Storage::disk('local')->get($path);
        $type = Storage::disk('local')->mimeType($path);
        $headers = [
            'Content-Type' => $type,
            'Content-Disposition' => 'attachment; filename=' . $filename,
        ];
        $response = response( $file, 200, $headers );
        return $response;
    }

    public function productAdd(Request $request){
        $validator = Validator::make($request->all(), [
            'category' => 'required|string',
            'number' => 'required|string',
            'name' => 'required|string',
            'about' => 'required|string',
            'price' => 'required|string',
            'file' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('alert', 'Validation fails!');
        }

        if(!$this->checkSelectData($request->get('category'))){
            return redirect()->back()->with('alert', 'Category not valid!');
        }

        if($this->checkFileExt($request->file('file')->getClientOriginalExtension())){
            $data = $this->shopService->productAdd($request);
            return redirect()->back()->with('alert', $data);
        }else{
            return redirect()->back()->with('alert', 'File extension not valid!');
        }
    }

    public function productDelete(Request $request, $product_id){
        $data = $this->shopService->productDelete($request, $product_id);
        return redirect()->back()->with('alert', $data);
    }

    public function productUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'category' => 'required|string',
            'number' => 'required|string',
            'name' => 'required|string',
            'about' => 'required|string',
            'price' => 'required|string',
            'file' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('alert', 'Validation fails!');
        }

        if(!$this->checkSelectData($request->get('category'))){
            return redirect()->back()->with('alert', 'Category not valid!');
        }

        if($this->checkFileExt($request->file('file')->getClientOriginalExtension())){
            $data = $this->shopService->productUpdate($request);
            return redirect()->back()->with('alert', $data);
        }else{
            return redirect()->back()->with('alert', 'File extension not valid!');
        }
    }

    private function checkSelectData($category){
        if($category == 'none'){
            return false;
        }else{
            return true;
        }
    }

    private function checkFileExt($file){
        $extArray = ['jpg','jpeg','png'];
        if(in_array(Str::lower($file), $extArray)){
            return true;
        }else{
            return false;
        }
    }
}
