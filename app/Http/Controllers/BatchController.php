<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::all();
        return response()->json($batches);
    }


   public function findByBatch(Request $request, $batchId)
    {
        // Find the batch by its ID
        $batch = Batch::find($batchId);

        if (!$batch) {
           
            return response()->json(['error' => 'Batch not found'], 404);
        }

        // Retrieve products related to the batch
        $products = Product::where('batch_id', $batchId)->get();

        return response()->json(['batch' => $batch, 'products' => $products]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'batch_name' => 'required',
            'created_by' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $batch = new Batch();
        $batch->batch_name = $request->input('batch_name');
        $batch->created_by = $request->input('created_by');

        if ($batch->save()) {
            return response()->json(['status' => 'success', 'message' => 'Batch added']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Batch was not added']);
        }
    }

    // Other methods (show, update, destroy) follow a similar structure.

    public function destroy($id)
    {
        $products = Batch::find($id)->products;

        foreach ($products as $product) {
            Product::destroy($product->id);
        }

        if (Batch::destroy($id)) {
            return response()->json(['status' => 'success', 'message' => 'Batch deleted']);
        }

        return response()->json(['status' => 'error', 'message' => 'Batch was not deleted'], 422);
    }
}
