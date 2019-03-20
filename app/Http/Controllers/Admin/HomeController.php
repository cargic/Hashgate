<?php

namespace App\Http\Controllers\Admin;

use App\Models\BuryPoint;
use App\Models\Coin;
use App\Models\Star;
use App\Models\User;
use App\Models\WebStat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        $stat = [];
//        $stat['users'] = User::query()->count();
//        $stat['today_online_users'] = User::query()->where('updated_at','>=',Carbon::now()->toDateString())->count();
//        $stat['today_add_users'] = User::query()->where('created_at','>=',Carbon::now()->toDateString())->count();
//        $stat['web_stat'] = WebStat::query()
//            ->where('date','>=',Carbon::now()->addDay(-30)->toDateString())
//            ->get()->toArray();
//
//        $stat['online_coin'] = Coin::query()->where('state','!=',0)->count();
//        $stat['error_coin'] = Coin::query()
//            ->where('state','!=',0)
//            ->where('state','!=',1)
//            ->count();

        return view('admin.home')->with([
            'activeTab' => 'home',
            'stat' => $stat
        ]);
    }

    public function getWebStat(Request $request)
    {
        $web_stat = WebStat::query()
            ->where('type',$request->input('type'))
            ->where('date','>=',Carbon::now()->subDay(30)->toDateString())
            ->orderBy('date','asc')
            ->get()->toArray();

        return $web_stat;
    }

    public function getStarsStat()
    {
        $starStat = DB::table('stars') ->select(DB::raw('count(*) as star_count, cid'))->groupBy('cid')->get()->toArray();
        if(!empty($starStat)){
            foreach ($starStat as $key=>$value){
                $starStat[$key]->coin_name = Coin::query()->where('id',$value->cid)->value('name');
            }
        }

        return $starStat;
    }

    public function getWebHeadStat(){
        $headParams = [
            config('buryPoint.EN'),
            config('buryPoint.CN'),
            config('buryPoint.USD'),
            config('buryPoint.CNY'),
        ];
        $headStat = BuryPoint::query()
            ->whereIn('type',$headParams)
            ->get()->toArray();

        $data = [];
        if(!empty($headStat)){
            $headParams = array_flip(config('buryPoint'));
            for ($i=0; $i<count($headStat); $i++){
                $data[$i]['name'] = $headParams[$headStat[$i]['type']];
                $data[$i]['value']= $headStat[$i]['times'];
            }
        }
        return $data;
    }

    public function getWebListStat(){
        $headParams = [
            5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30
        ];
        $headStat = BuryPoint::query()
            ->whereIn('type',$headParams)
            ->get()->toArray();

        $data = [];
        if(!empty($headStat)){
            $headParams = array_flip(config('buryPoint'));
            for ($i=0; $i<count($headStat); $i++){
                $data[$i]['name'] = $headParams[$headStat[$i]['type']];
                $data[$i]['value']= $headStat[$i]['times'];
            }
        }

        return $data;
    }

    public function getWebDetailStayTimeStat(){
        $headStat = BuryPoint::query()
            ->where('type',0)
            ->get()->toArray();

        $data = [];
        if(!empty($headStat)){
            for ($i=0; $i<count($headStat); $i++){
                $data[$i]['name'] = Coin::query()->where('id',$headStat[$i]['coin_id'])->value('symbol');
                $data[$i]['value']= $headStat[$i]['time'];
            }
        }

        return $data;
    }
}
