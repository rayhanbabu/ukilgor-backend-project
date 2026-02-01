<?php
namespace App\Services\Setting\PracticeAreaService;

use App\Models\PracticeArea;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Exception;

class PracticeAreaUpdate
{
    public function handle($request, $id)
    {

        DB::beginTransaction();
        try {

            $user_auth =user();
            $model = PracticeArea::findOrFail($id);

            $validator = validator($request->all(), [
                'practicearea_name' => 'required|unique:practiceareas,practicearea_name,' . $id,
                'status' => 'nullable|boolean',
            ]);
            

         if ($validator->fails()) {
             return response()->json([
                 'message' => 'Validation failed',
                 'errors' => $validator->errors(),
              ], 422);
          }

          $model->practicearea_name = $request->practicearea_name;
          $model->status = $request->status;
          $model->updated_by = $user_auth->id;

            $model->save();

            DB::commit();

            return response()->json([
                'message' => 'Data updated successfully',
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update school',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

   

}
