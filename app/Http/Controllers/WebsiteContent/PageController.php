<?php

namespace App\Http\Controllers\WebsiteContent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use App\Services\WebsiteContent\PageService\PageAdd;
use App\Services\WebsiteContent\PageService\PageList;
use App\Services\WebsiteContent\PageService\PageUpdate;
use App\Services\WebsiteContent\PageService\PageDelete;



class PageController extends Controller
{

    protected $PageAdd;
    protected $PageList;
    protected $PageUpdate;
    protected $PageDelete;


    public function __construct(PageAdd $PageAdd, PageList $PageList, PageUpdate $PageUpdate 
    , PageDelete $PageDelete)
    {
         $this->PageAdd = $PageAdd;
         $this->PageList = $PageList;
         $this->PageUpdate = $PageUpdate;
         $this->PageDelete = $PageDelete;      
    }


     public function page_add(Request $request)
     {
          return $this->PageAdd->handle($request);
     }


     public function page(Request $request){
           return $this->PageList->handle($request);
     }

      public function page_update(Request $request, $id)
      {
          return $this->PageUpdate->handle($request,$id);
      }


       public function page_delete(Request $request, $id)
       {
           return $this->PageDelete->handle($request, $id);
       }


}
