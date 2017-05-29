<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Player;
use App\Slate;


class LineUpControllerFd extends Controller
{



    /**
     *  Fake Data with nested arrays
     * @var array
     */
    private $data;

    /**
     * Limit of items in each combination
     *
     */
    private $limit = 8;

    /**
     * Number of desired combinations
     *
     */
    private $count = 10;

    /**
     * Combinations array
     * @var array
     */
    private $combinations = [];

    private $minSalary;
    private $maxSalary;

    /**
     * Lineup Generator
     * Limit content access to specific domains
     *
     * @param Request $request
     * @return mixed
     */
    // public function index(Request $request)
    public function index($slate = "fd")
    {
//        if(empty($_SERVER['HTTP_REFERER'])){
//            return "You cannot access the lineup generator directly. It must be loaded in an iFrame.";
//        }

//        if(strpos($_SERVER['HTTP_REFERER'], "fantasygolfinsider.com") === false &&
//           strpos($_SERVER['HTTP_REFERER'], "fgi.local") === false ){
//            return "You do not have access to view the lineup generator";
//        }
        return viefd'lineups-fd')->with('slate', $slate);
    }


    public function players($slate = "fd")
    {
        // dd($request);
        $slate_id = Slate::where('name', $slate)->first()->id;
        $players = Player::where('slate_id', $slate_id)->get();
        // $players = Player::all();

        $draft_kings_ids = array_column($players->toArray(), 'draft_kings_id');

        foreach($draft_kings_ids as $id){
            $rosterCounts[$id] = 0;
        }
        return response()->json(['players' => $players, 'rosterCounts' => $rosterCounts ]);
    }
    /**
     * Request handler
     *
     */
    public function generate(Request $request)
    {

        $data = json_decode($request->data);
        $this->count = $datfd>lineups;
        $this->minSalary = $data->minSalary;
        $this->maxSalary = $data->maxSalary;

        $players = array_map('get_object_vars',$data->players);
        $n = 1;

        foreach($players as $key => $player){
            if($player['weight'] != 0){
                if ($player['weight'] == 100) {
                    $player['weight'] = 10000; //Add more weight to values with 100%
                }
                $n2 = $player['draft_kings_id'];
                $players[$n2] = $player;
            }
            unset($players[$key]);
        }
        $this->data = $players;
        session(['combinations' => $this->generateCombinations() ]);
        $ids = array_column(session('combinations'), 'ids');
        foreach($ids as $id){
            $idArr[] = explode(',', $id);
        }
        $rosterCounts = array_count_values(array_map('trim', array_merge(...$idArr)));
        return ['combos' => session('combinations'), 'stats' => $this->getStats(), 'rosterCounts' => $rosterCounts];
    }

    /**
     * Generates CSV for exporting
     *
     */

    public function export(Request $request)
    {
        header("Content-type: text/csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-Disposition: attachment; filename=fd_lineups.csv");

        $dump = [];

        // $index = 0;

        foreach( session('combinations') as $combo){
            // if ($index == 0) {
            //     $dump[] = $combo['ids'] . ", ," . "1. Locate the player you want to select in the list below ";
            // }
            // if ($index == 1) {
            //     $dump[] = $combo['ids'] . ", ," . "2. Copy the ID of your player (you can use the Name + ID column or the ID column) ";
            // }
            // if ($index > 1) {
            //     $dump[] = $combo['ids'];
            // }
            // $index++;
            $dump[] = $combo['ids'];
        }

        $out = fopen('php://output', 'w');

        $headers = ['G', 'G', 'G', 'G', 'G', 'G', 'G', 'G',];
        // $headers = ['WG', 'WG', 'WG', 'WG', 'WG', 'WG', '', 'Instructions'];

        fputcsv($out, $headers);

        foreach($dump as $line)
        {
            fputcsv($out, array_map("intval", explode(',' , $line) ));
        }

        fclose($out);

    }

    /**
     * Responsbile for generation all combinations
     *
     */
    private function generateCombinations()
    {
        while(count($this->combinations) < $this->count){
            if(count($this->combinations) < 1){
                $this->combinations[] = $this->generateCombination($this->data);
            }
            $combo = $this->generateCombination($this->data);
            if ($combo){
                $combo = $this->ensureUnique($combo);
                $this->combinations[] = $combo;
            } else {
                break;
            }

        }
        foreach($this->combinations as $key => $combination){
            $combo['names'] = implode(', ', array_column($combination, 'name'));
            $combo['total'] = (int) array_sum(array_column($combination, 'salary'));
            $combo['ids'] = implode(', ', array_column($combination, 'draft_kings_id'));
            $this->combinations[$key] = $combo;
        }
        return $this->combinations;
    }

    /**
     * Ensured value is unique combination and ensures salary limits are honored
     *
     */
    private function ensureUnique($newCombination)
    {
        foreach($this->combinations as $key => $combination){
            if(empty( array_diff_key($combination, $newCombination) ) ){
                return $this->ensureUnique($this->generateCombination($this->data));
            }
        }

        return $newCombination;
    }

    /**
     * Restricts to salary range
     *
     */
    private function ensureSalaryRange($newCombination){
        $total =(int) array_sum(array_column($newCombination, 'salary'));
        if($total > $this->maxSalary || $total < $this->minSalary){
            return $this->generateCombination($this->data);
        }
        return $newCombination;
    }

    /**
     * Generations a single combination
     *
     */
    private function generateCombination($data)
    {
        $combination = [];

        for($i = 0; $i < $this->limit; $i++){
            $key = $this->getRandomWeightedElement($data);
            if($key){
                $combination[$key] = $data[$key];
                unset($data[$key]);
            } else {
                return false;
            }

        }

        return $this->ensureSalaryRange($combination);
    }

    /**
     * getRandomWeightedElement()
     * Utility function for getting random values with weighting.
     * Pass in an associative array, such as array('A'=>5, 'B'=>45, 'C'=>50)
     * An array like this means that "A" has a 5% chance of being selected, "B" 45%, and "C" 50%.
     * The return value is the array key, A, B, or C in this case.  Note that the values assigned
     * do not have to be percentages.  The values are simply relative to each other.  If one value
     * weight was 2, and the other weight of 1, the value with the weight of 2 has about a 66%
     * chance of being selected.  Also note that weights should be integers.
     */
    function getRandomWeightedElement(array $weightedValues)
    {
        try{
            $rand = mt_rand(1, (int) array_sum(array_column($weightedValues, 'weight')));

            foreach ($weightedValues as $key => $value) {
                $rand -= $value['weight'];
                if ($rand <= 0) {
                    return $key;
                }
            }
        } catch(\Exception $e){

        }

    }

    private function getStats()
    {
        $stats = [];
        $stats['totalSalaryUsed'] = array_sum(array_column(session('combinations'), 'total') );
        $stats['totalSpots'] = count(session('combinations')) * 6;
        $stats['totalSpotsUsed'] = $stats['totalSpots'];
        $stats['averageSalary'] = $stats['totalSalaryUsed'] / $stats['totalSpots'];
        $stats['totalSalaryAvailable'] = $this->maxSalary * $this->count;
        $stats['averageSalaryRemaining'] = money_format('$%i', ($stats['totalSalaryAvailable'] - $stats['totalSalaryUsed']) / 6 );

        $stats['totalSalaryUsed'] = money_format('$%i', $stats['totalSalaryUsed']);
        $stats['averageSalary'] = money_format('$%i', $stats['averageSalary']);
        $stats['totalSalaryAvailable'] = money_format('$%i', $stats['totalSalaryAvailable']);
        return $stats;
    }


}