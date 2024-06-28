<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTime, DateInterval, DatePeriod;
use Exception;

class RedactedLaravelExample extends Model
{
    use HasFactory;

    /**
     * Query the database for existing API data from prior requests for the same time period
     *
     * @var string $clientId
     * @var string $dataSource
     * @var array $dateRange
     * @var array $parameters
     * 
     * @return array
     */
    public function check($clientId, $dataSource, $dateStart, $dateEnd, $parameters)
    {
        //Use provided date range to check each [REDACTED], return them in the same order requested
        $start = new DateTime($dateStart);
        $end = new DateTime($dateEnd);
        $end = $end->modify( '+1 day' ); //Add a day to the end so that the entire month gets looped

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($start, $interval, $end);
        
        //Processed data sets for query
        $types = array_values($parameters);
        $procDates = [];
        $compDates = [];
        $dataRetrieval = [];
        
        //Build dates array for query
        foreach ($period as $date) {
            array_push($procDates, $date->format("Y-m-d"));
        }
        
        try {
            //Retrieve data by date
            $data = DB::table('a')
                ->join('b', 'b.id', '=', 'a.c')
                ->join('d', 'a.e', '=', 'd.e')
                ->join('f', 'a.i', '=', 'f.i')
                ->join('g', 'a.h', '=', 'g.h')
                ->join('j', 'a.k', '=', 'j.k')
                ->select(['l', 'm', 'n', 'o', 'p'])
                ->where('b.q', $clientId)
                ->where('d.l', $dataSource)
                ->whereIn('m', $types)
                ->whereIn('o', $procDates)
                ->get();
            if ($data) {
                //Append data for return in standard API return format
                foreach ($data as $row) {
                    $dataRetrieval[$row->m][$row->n][$row->o] = $row->p;
                    
                    //Build date comparison array as we go to check against
                    if (!in_array($row->o, $compDates)) {
                        array_push($compDates, $row->o);
                    }
                }
                
                //If data is missing for a specified date, fall back to the API so we can update our database
                if (count($compDates) !== count($procDates)) {
                    return false;
                }
            } else {
                //If all data is missing, fall back on the API
                return false;
            }
        } catch (Exception $e) {
            return view('404');
        }

        return $dataRetrieval;
    }
    
    
    /**
     * Optimized checking and local storage of API data as needed based on existing records (Bulk Anonymized For Example) (>100,000 records per run typically)
     *
     * @var string $clientId
     * @var string $dataSource
     * @var array $parameters
     */
    public function store($clientId, $dataSource, $parameters)
    {
        //Convert clientId to accountId Integer
        $accountId = DB::table('x')
            ->select(['id'])
            ->where('y', $clientId)
            ->first()->id;
        
        //Build easily usable search and storage indices from dataset
        $typeIndexImmutable = [];
        $groupIndexImmutable = [];
        $dateIndexImmutable =[];
        $valuesIndex = [];
        
        foreach ($parameters as $type => $groups) {
            array_push($typeIndexImmutable, $type);
            foreach ($groups as $group => $dates) {
                array_push($groupIndexImmutable, $group);
                //Prepare values within new insert-ready array
                foreach ($dates as $date => $data) {
                    array_push($valuesIndex, ['a' => $data, 'b' => $accountId, 'c' => '', 'd' => $type, 'e' => $group, 'f' => $date]);
                }
                if (empty($dateIndexImmutable)) {
                    $dateIndex = $dateIndexImmutable = array_keys($dates);
                }
            }
        }
        
        //Deduplicate API data (measured 2 trillionths of a second faster than !in_array) and create a copy for later that is not destroyed on use
        $typeIndex = $typeIndexImmutable = array_unique($typeIndexImmutable);
        $groupIndex = $groupIndexImmutable = array_unique($groupIndexImmutable);
        
        //Running separate checks for all [REDACTED]. Run query as whereIn, take results, eliminate results from input array, perform insert for remaining array items if not empty (more optimal method)
        $sourceId = DB::table('z')
            ->select(['c'])
            ->where('l', $dataSource)
            ->first();
        
        if (empty($sourceId)) {
            $sourceId = DB::table('z')->insertGetId(['l' => $dataSource]);
        }
        
        $sourceId = (gettype($sourceId) == 'object') ? $sourceId->c : $sourceId;
        
        $typeCheck = DB::table('m')
            ->select(['n'])
            ->whereIn('n', $typeIndex)
            ->get()->toArray();
        
        if (count($typeCheck) !== count($typeIndex)) {
            //Eliminate same-values from index
            foreach ($typeIndex as $key => $typeElim) {
                if (in_array((object) ['n' => $typeElim], $typeCheck)) {
                    unset($typeIndex[$key]);
                } else {
                    $typeIndex[$key] = ['n' => $typeElim];
                }
            }
            
            //Insert remaining index values
            DB::table('m')->insert($typeIndex);
        }
        
        $groupCheck = DB::table('o')
            ->select(['p'])
            ->whereIn('p', $groupIndex)
            ->get()->toArray();
        
        if (count($groupCheck) !== count($groupIndex)) {
            //Eliminate same-values from index
            foreach ($groupIndex as $key => $groupElim) {
                if (in_array((object) ['p' => $groupElim], $groupCheck)) {
                    unset($groupIndex[$key]);
                } else {
                    $groupIndex[$key] = ['p' => $groupElim];
                }
            }
            
            //Insert remaining index values
            DB::table('o')->insert($groupIndex);
        }
        
        $dateCheck = DB::table('q')
            ->select(['r'])
            ->whereIn('r', $dateIndex)
            ->get()->toArray();
        
        if (count($dateCheck) !== count($dateIndex)) {
            //Eliminate same-values from index
            foreach ($dateIndex as $key => $dateElim) {
                if (in_array((object) ['r' => $dateElim], $dateCheck)) {
                    unset($dateIndex[$key]);
                } else {
                    $dateIndex[$key] = ['r' => $dateElim];
                }
            }
            
            //Insert remaining index values
            DB::table('q')->insert($dateIndex);
        }
        
        //May have to run selects for all relevant IDs of [REDACTED] individually, best idea for now
        $typeIdRetrieval = DB::table('m')
            ->select(['n', 'd'])
            ->whereIn('n', $typeIndexImmutable)
            ->get()->toArray();
            
        $groupIdRetrieval = DB::table('o')
            ->select(['p', 'e'])
            ->whereIn('p', $groupIndexImmutable)
            ->get()->toArray();
        
        $dateIdRetrieval = DB::table('q')
            ->select(['r', 'f'])
            ->whereIn('r', $dateIndexImmutable)
            ->get()->toArray();
        
        //Reformat results into key value pair
        foreach ($typeIdRetrieval as $key => $row) {
            if (is_numeric($key)) {
                $typeIdRetrieval[$row->n] = $row->d;
                unset($typeIdRetrieval[$key]);
            }
        }
        
        foreach ($groupIdRetrieval as $key => $row) {
            if (is_numeric($key)) {
                $groupIdRetrieval[$row->p] = $row->e;
                unset($groupIdRetrieval[$key]);
            }
        }
        
        foreach ($dateIdRetrieval as $key => $row) {
            if (is_numeric($key)) {
                $dateIdRetrieval[$row->r] = $row->f;
                unset($dateIdRetrieval[$key]);
            }
        }
        
        foreach ($valuesIndex as &$valueRow) {
            //Translate strings to ids and finish preparation of the array for insert
            $valueRow['c'] = $sourceId;
            $valueRow['d'] = $typeIdRetrieval[$valueRow['d']];
            $valueRow['e'] = $groupIdRetrieval[$valueRow['e']];
            $valueRow['f'] = $dateIdRetrieval[$valueRow['f']];
        }
        
        $reportCheck = DB::table('s')
            ->select(['a', 'b', 'c', 'd', 'e', 'f'])
            ->where('b', $accountId)
            ->where('c', $sourceId)
            ->whereIn('d', array_values($typeIdRetrieval))
            ->whereIn('e', array_values($groupIdRetrieval))
            ->whereIn('f', array_values($dateIdRetrieval))
            ->get()->toArray();
        
        if (count($reportCheck) !== count($valueRow)) {
            //Eliminate existing values from final insert
            foreach ($valuesIndex as $key => $valueElim) {
                if (in_array((object) $valueElim, $reportCheck)) {
                    unset($valuesIndex[$key]);
                }
            }
            
            //Insert remaining index values, chunked to prevent [REDACTED] integer overflow
            foreach (array_chunk($valuesIndex, 5000) as $chunk)
            {
                DB::table('s')->insert($chunk);
            }
        }
    }
}