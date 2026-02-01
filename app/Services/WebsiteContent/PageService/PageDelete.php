<?php
namespace App\Services\WebsiteContent\PageService;

use App\Models\Page;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class PageDelete
{
    public function handle(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $Page = Page::findOrFail($id);
            $this->deleteImage($Page->image);
            $Page->delete();

         
            DB::commit();
            return response()->json([
                'message' => 'Page deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Failed to delete Page',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


     private function deleteImage($image)
    {
        if ($image) {
            $path = public_path('uploads/admin') . '/' . $image;
            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }

}
