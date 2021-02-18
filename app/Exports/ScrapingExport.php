<?php

namespace App\Exports;

use App\ScrapingList;
use Maatwebsite\Excel\Concerns\FromCollection;

class ScrapingExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id;
    public function __construct($id){
        $this->id = $id;
    }
    public function collection()
    {
        return ScrapingList::where('timestamp_id',$this->id)->get();
    }
}
