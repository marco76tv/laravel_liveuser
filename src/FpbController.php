<?php
namespace Xot\Fpb;
 
use App\Http\Controllers\Controller;
use Carbon\Carbon;
 
class FpbController extends Controller
{
 
    public function index($timezone)
    {
        echo Carbon::now($timezone)->toDateTimeString();
    }
 
}