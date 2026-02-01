<?php

namespace App\Http\Controllers\WebsiteContent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use App\Services\WebsiteContent\PageCategoryService\PageCategoryAdd;
use App\Services\WebsiteContent\PageCategoryService\PageCategoryList;
use App\Services\WebsiteContent\PageCategoryService\PageCategoryUpdate;
use App\Services\WebsiteContent\PageCategoryService\PageCategoryDelete;



class PageCategoryController extends Controller
{

    protected $PageCategoryAdd;
    protected $PageCategoryList;
    protected $PageCategoryUpdate;
    protected $PageCategoryDelete;


    public function __construct(PageCategoryAdd $PageCategoryAdd, PageCategoryList $PageCategoryList, PageCategoryUpdate $PageCategoryUpdate 
    , PageCategoryDelete $PageCategoryDelete)
    {
         $this->PageCategoryAdd = $PageCategoryAdd;
         $this->PageCategoryList = $PageCategoryList;
         $this->PageCategoryUpdate = $PageCategoryUpdate;
         $this->PageCategoryDelete = $PageCategoryDelete;      
    }


     public function pageCategory_add(Request $request)
     {
          return $this->PageCategoryAdd->handle($request);
     }


     public function pageCategory(Request $request){
           return $this->PageCategoryList->handle($request);
     }

      public function pageCategory_update(Request $request, $id)
      {
          return $this->PageCategoryUpdate->handle($request, $id);
      }


       public function pageCategory_delete(Request $request, $id)
       {
           return $this->PageCategoryDelete->handle($request, $id);
       }


}
