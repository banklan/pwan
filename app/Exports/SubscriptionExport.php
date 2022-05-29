<?php

namespace App\Exports;

use App\Subscription;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\FromQuery;
// use Maatwebsite\Excel\Concerns\Exportable;

// use Maatwebsite\Excel\Concerns\FromCollection;

class SubscriptionExport implements FromQuery
{
     /**
    * @return \Illuminate\Support\Collection
    */
    
    use Exportable;

    public $subscription;

    public function __construct(int $subscription)
    {
        $this->subscription = $subscription;
    }
    
    public function collection()
    {
        return Subscription::where('id', $this->subscription);
        // pass the subscription to be exported in your controller like so: return (new SubscriptionExport(10))->download('subscription.xlsx');
    }
}
