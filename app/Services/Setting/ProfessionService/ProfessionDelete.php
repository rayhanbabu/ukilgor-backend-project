<?php
namespace App\Services\Setting\ProfessionService;

use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProfessionDelete
{
    public function handle(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $model = Profession::findOrFail($id); 
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
                'message' => 'Failed to delete profession',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}
