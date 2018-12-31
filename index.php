<?php 
class SnakeEat {

    public $n; // number of snakes
    public $q; // number of queries
    public $l = array(); // sanke lengths array
    public $query; // single query
    public $finalArr = array(); // final array of snake length (without the snakes with length greater or equal Ki)
    public $count; // maximum number of snake at least with length Ki 


    private function binarySearch($array, $value) {
        // Set the left pointer to 0.
        $left = 0;
        // Set the right pointer to the length of the array -1.
        $right = count($array) - 1;
     
        while ($left <= $right) {
          // Set the initial midpoint to the rounded down value of half the length of the array.
          $midpoint = (int) floor(($left + $right) / 2);
     
          if ($array[$midpoint] < $value) {
            // The midpoint value is less than the value.
            $left = $midpoint + 1;
          } elseif ($array[$midpoint] > $value) {
            // The midpoint value is greater than the value.
            $right = $midpoint - 1;
          } else {
            // This is the key we are looking for.
            return $midpoint;
          }
        }
        // The value was not found.
        return (int) ceil(($left + $right) / 2);
    }

    private function process() {
        $lessNumber = $this->query - 0.5;
        $treshold = $this->binarySearch($this->l, $lessNumber);
        $this->finalArr = array_slice($this->l, 0, $treshold);
        $right = count($this->finalArr);
        $this->count = $this->n - $treshold;  // all snakes with length >= ki will be added to pool

        //print_r($this->finalArr);
        $diff = 0;
        $cumulative = 0;
        $i = (int) floor($right / 2);

        for ($n=$right-1; $i<=$right; $i+=$diff,$n--) { // $n = 2, $right = 3, $i = 0
            $diff = $this->query - $this->finalArr[$n];  // how many elements lack to treshold, $diff = 10 - 9 = 1
            $diff = ($this->query * $i) - (array_sum(array_slice($this->finalArr, 0, $i)));

            $cumulative += $diff;  // $cumulative = 0 + 1 = 1
            if ($diff > $right - ($i + $cumulative)) {  // if there is not enough elements in array, break it
                break;
            } else {
                ++$this->count;
            }
            
        }

    }

    public function init() {
        $t = stream_get_line(STDIN, 20000000000, PHP_EOL);
        for ($j=0; $j<$t; $j++) {
            $data = explode(' ', stream_get_line(STDIN, 10000000000000, PHP_EOL));
            $this->n = $data[0];
            $this->q = $data[1];
            $this->l = explode(' ', stream_get_line(STDIN, 10000000000000, PHP_EOL)); 
            sort($this->l);  // sorts length of snakes in asc order
            for ($i=0; $i<$this->q; $i++) {
                $this->query = stream_get_line(STDIN, 20000000000, PHP_EOL);
                $this->process();
                echo $this->count . PHP_EOL;
            }
            
            
        }
    }

}


$snake = new SnakeEat();
$snake->init();
?>