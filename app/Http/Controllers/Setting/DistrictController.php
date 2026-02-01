<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use App\Services\Setting\DistrictService\Districtv1Add;
use App\Services\Setting\DistrictService\DistrictList;
use App\Services\Setting\DistrictService\DistrictUpdate;
use App\Services\Setting\DistrictService\DistrictDelete;


class DistrictController extends Controller
{

    protected $Districtv1Add;
    protected $DistrictList;
    protected $DistrictUpdate;
    protected $DistrictDelete;


    public function __construct(Districtv1Add $Districtv1Add, DistrictList $DistrictList, DistrictUpdate $DistrictUpdate, DistrictDelete $DistrictDelete)
    {
         $this->Districtv1Add = $Districtv1Add;
         $this->DistrictList = $DistrictList;
         $this->DistrictUpdate = $DistrictUpdate;
         $this->DistrictDelete = $DistrictDelete;
    }

  
     public function district_add(Request $request)
     {
          return $this->Districtv1Add->handle($request);
     }

     public function district(Request $request){
           return $this->DistrictList->handle($request);
     }

      public function district_update(Request $request, $id)
      {
          return $this->DistrictUpdate->handle($request, $id);
      }
   
 
       public function district_delete(Request $request, $id)
       {
           return $this->DistrictDelete->handle($request, $id);
       }




}
