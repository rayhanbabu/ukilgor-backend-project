<?php
namespace App\Services\Setting\DistrictService;

use App\Models\District;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Exception;

class DistrictUpdate
{
    public function handle($request, $id)
    {

        DB::beginTransaction();
        try {

            $user_auth =user();
            $model = District::findOrFail($id);

            $validator = validator($request->all(), [
                'district_name' => 'required|unique:districts,district_name,' . $id,
                'status' => 'nullable|boolean',
            ]);
            

         if ($validator->fails()) {
             return response()->json([
                 'message' => 'Validation failed',
                 'errors' => $validator->errors(),
              ], 422);
          }

          $model->district_name = $request->district_name;
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
