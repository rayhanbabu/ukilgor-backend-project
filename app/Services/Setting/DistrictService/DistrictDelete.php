<?php
namespace App\Services\Setting\DistrictService;

use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DistrictDelete
{
    public function handle(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $model = District::findOrFail($id); 
            // Delete agent and user
            $model->delete();

            DB::commit();
            return response()->json([
                'message' => 'Data deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete district',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}
