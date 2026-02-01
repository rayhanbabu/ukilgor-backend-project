<?php
namespace App\Services\Setting\PracticeAreaService;

use App\Models\PracticeArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PracticeAreaDelete
{
    public function handle(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $model = PracticeArea::findOrFail($id); 
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
                'message' => 'Failed to delete practice area',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}
