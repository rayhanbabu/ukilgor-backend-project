<?php
namespace App\Services\Setting\ProfessionService;

use App\Models\Profession;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Exception;

class ProfessionUpdate
{
    public function handle($request, $id)
    {

        DB::beginTransaction();
        try {

            $user_auth =user();
            $model = Profession::findOrFail($id);

            $validator = validator($request->all(), [
                'profession_name' => 'required|unique:professions,profession_name,' . $id,
                'status' => 'nullable|boolean',
            ]);
            

         if ($validator->fails()) {
             return response()->json([
                 'message' => 'Validation failed',
                 'errors' => $validator->errors(),
              ], 422);
          }

          $model->profession_name = $request->profession_name;
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
