<?php 
class Wrapper {
    public $first;
    public $second;

    function __construct($first, $second) {
        $this->first = $first;
        $this->second = $second;
    }
}

class SnakeEat {

    public $n; // number of snakes
    public $q; // number of queries
    public $l = array(); // sanke lengths array
    public $query = array(); // query array
    public $count = array(); // maximum number of snake at least with length Ki 
    public $cur = 0;
    public $presum = 0;
    public $prev = 0;


    private function clear() {
        $this->l = array();
        $this->query = array();
        $this->cur = 0;
        $this->presum = 0;
        $this->prev = 0;
    }

    public function init() {
        $t = stream_get_line(STDIN, 100000000, PHP_EOL);
        for ($j=0; $j<$t; $j++) {
            $this->clear();
            $data = explode(' ', stream_get_line(STDIN, 100000000000, PHP_EOL));
            $this->n = $data[0];
            $this->q = $data[1];
            $this->l = explode(' ', stream_get_line(STDIN, 100000000000, PHP_EOL));
            
            for ($i=0; $i<$this->q; $i++) {
                $q = stream_get_line(STDIN, 200000000, PHP_EOL);
                $this->query[] = new Wrapper($q,$i); 
            }

            sort($this->l);  // sortujemy tablice z dlugosciami wezy w kolejnosci rosnacej
            sort($this->query); // sortujemy tablice z zapytaniami w kolejnosci rosnacej
            $this->l = array_combine(range(1, count($this->l)), $this->l); // reindex array from range 1..n instead of 0..n-1

            for ($i=1;;$i++) {
                $fir = $this->query[$this->cur]->first;  // 10 przykladowe pierwsze query
           
                while(isset($this->l[$i]) && ($this->l[$i] < $fir && $i<$this->n+1))
                {
                    $this->presum += ($fir-$this->l[$i]);  // od query odejmujemy najmniejsze elementy z dlugosci wezy i ta wartosc akumulujemy w presum, 
                    $i++;   // w presum powinna sie znalezc suma wszystkich elementow mniejszych od query
                }
                $i--;
                while($this->presum > $this->prev)
                {
                    $this->prev++;
                    $this->presum -= ($fir-$this->l[$this->prev]);  // zwiekszamy element prev o 1 oraz odejmujemy od presum roznice pomiedzy query a tym elementem,
                    // zaczynajac od elementu (weza) o najmniejszej dlugosci, robimy to az do momentu kiedy w presum mamy wiecej niz w prev
                    // mowiac najprosciej w prev wyliczamy ile najkrotszych wezy trzeba zabic
                }
                $this->count[$this->query[$this->cur]->second] = $this->n-$this->prev;  // dodajemy odpowiedz, jest to roznica pomiedzy calkowita liczba wezy a prev,
                // prev oznacza ilosc wezy o najmniejszej dlugosci jaka trzeba bylo zabic w kontekscie konkretnego query
                // roznica ktora zapisujemy jest zatem iloscia wezy jakie osiagnely dlugosc co najmniej query

                if ($this->cur === $this->q-1) {
                    break; // wykonuje sie wtedy kiedy wszystkie query dla danego testu zostana obsluzone
                }
				
                $this->presum = $this->presum + ($i-$this->prev)*($this->query[$this->cur+1]->first - $fir);
                // w presum na razie mamy roznice dla konkretnego query tzw. nadwyzke ktora nie mogla byc spozytkowana, 
                // $i - oznacza ilosc dlugosci wezy jaka na razie rozpatrzylismy w kontekscie konkretnego $this->query
                // $this->prev oznacza ilosc wezy zjedzonych w kontekscie konkretnego $this->query
                $this->cur++;
            }

            for($c=0;$c<$this->q;$c++) {
                echo $this->count[$c] . PHP_EOL;
            }
        }
    }

}


$snake = new SnakeEat();
$snake->init();
?>