<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductModel;

class ProductController extends Controller
{
    // ambil semua data
    public function index()
    {
        $product = ProductModel::all();
        if($product)
        {
            return response([
                'status' => 'success',
                'message' => 'Data product ditemukan',
                'product_data' => $product
            ], 200);
        }else{
            return response([
                'status' => 'NOT FOUND',
                'message' => 'Data product tidak ditemukan',
                'product_data' => []
            ], 404);
        }
    }

    //insert data api
    public function insert_data_product(Request $request)
    {

        $product = new ProductModel;

        //ambil gambar
        $fileName = time().$request->file('cover')->getClientOriginalName();
        $path = $request->file('cover')->storeAs('IMAGES/cover',$fileName);

        $insert_product['cover'] = $path;
        $insert_product['name'] = $request->name;
        $insert_product['code'] = $request->code;
        $insert_product['deskripsi'] = $request->deskripsi;
        $product->create( $insert_product);
        if($product){
            return response([
                'status' => 'success',
                'message' => 'Data Product Berhasil Di Input',
                'data' => $product,
            ],200);
        }else{
            return response([
                'status' => 'failed',
                'message' => 'Data Product gagal di Input',
                'data' => [],
            ],404);
        }

    }

    public function update_data_siswa(Request $request, $id)
    {
        $cek_id = ProductModel::firstWhere('product_id', $id);
        $fileName = time().$request->file('cover')->getClientOriginalName();
        $path = $request->file('cover')->storeAs('IMAGES/cover',$fileName);
        if($cek_id){
            $Product = ProductModel::find($id);
            $dataProduct['cover']=$path;
            $dataProduct['name'] = $request->name;
            $dataProduct['code'] = $request->code;
            $dataProduct['deskripsi'] = $request->deskripsi;
            $Product->update($dataProduct);
            return response([
                'status' => 'success',
                'message' => 'Data product Berhasil dirubah',
                'update_data' => $dataProduct
            ], 200);
        }else{
            return response([
                'status' => 'NOT FOUND',
                'message' => 'Data Siswa tidak ditemukan'
            ], 404);
        }
    }

    //delete data
    public function delete_data_product($id)
    {
        $cek_id = ProductModel::firstWhere('product_id', $id);


        if ($cek_id) {
            ProductModel::destroy($id);
            return response([
                'status' => 'success',
                'message' => 'Data Siswa Berhasil Di Hapus'
            ], 200);
        } else {
            return response([
                'status' => 'NOT FOUND',
                'message' => 'Data Siswa tidak ditemukan'
            ], 404);
        }
    }
}
