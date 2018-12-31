# SNAKEEAT

Snake Eat problem - https://www.codechef.com/SNCKQL17/problems/SNAKEEAT

## Problem

Opis: 
Hodowca ma węże, które się wzajemnie zjadają pod warunkiem, że Li ≥ Lj gdzie Li - to długość i-tego węża a Lj to długość j-tego węża
Kiedy węże się zjedzą wąż Li zwiększa swoją długość o jeden Li =+ 1, natomiast wąż Lj ginie. 
Uwzględniając powyższy warunke, każdy wąż może zjeść wiele innych węży. 

Celem hodowy jest uzyskanie określonej liczby węży w programie opisanej jak Ki, twoim zadaniem jest obliczenie tej właśnie liczby węży.

Na wejściu dostajemy: 
- liczbę testów $t
- dwie zmienne $N (liczba węzy dla każdgo testu) i $Q (liczba zapytań dla każdego testu)
- następna linia zawiera $N zmiennych L1, L2, .., LN - oznaczających długości węży
- następnie w $Q liniach mamy K1, K2, .., Ki - zmiennych oznaczających zapytanie dla danego testu 

Na wyjściu drukujemy:
- Dla każdego testu i każdego Ki - obliczamy maksymalną liczbę węzy o długości co najamniej Ki


## Algorytm

1. Posortować w kolejności rosnącej tablicę $L

2. Obliczamy dwie tablicę $L i $R które będą miały za zadanie sprawdzić najdłuższy sukcesywny blok elementów równych $A[$mid]. 
Tablicę $L obliczmy w następujący sposób:
- do pierwszego elementu przypisujemy $L[0] = 1
- następnie robimy pętle
```php
$L[1] = 1;
for ($i=2; $i<=$n; $i++) {
    if $A[$i] == $A[$i - 1]:
        $L[$i] = $L[$i - 1]
    else
        $L[$i] = $i;
}

// analogicznie tablica $R
$R[$n] = $n;
for ($i=$n-1; $i<=1; $i--) {
    if $A[$i] == $A[$i + 1]:
        $R[$i] = $R[$i + 1]
    else
        $R[$i] = $i;
}

```
Na podstawie tych dwóch tablic $L i $R i wartości które się w nich znajdują będziemy mogli obliczyć, ilość sukcesywnie powtarzającego się elementu $mid
a następnie sprawdzić czy ta wielkość jest większa lub równa $k jeśli tak to ją drukujemy na wyjście, jeśli nie to drukujemy -1.

3. Oznaczmy jako $repeat - ilość sukcesywnie powtarzjącego się elementu $mid w przedziale <$l, $r>. Wartość tą obliczamy następująco:
```php
$repeat = min($R[$mid],$r)−max($L[$mid],$l)+1;

/* 
    przyklad 1 
    $A = [1,2,2,2,2];
    $n = 5; $m = 1; $l = 1; $r = 5; $k =3; przy czym 3 >= floor((5-1+1)/2) = 3 >= 2
    czyli mamy znalezc liczbe z przedzialu <1,5> ktora sie powatrza co najmniej $k = 3 razy
    obliczamy $mid = ceil(l + 5) / 2 = 3;
    oliczamy $L = [1,2,2,2,2]; 
    obliczamy $R = [1,5,5,5,5];
    oliczamy $repeat = min($R[3], 5) - max($L[3],1) + 1 = min(5,5) - max(2,1) + 1 = 5 - 2 + 1 = 4
    co się zgadza bo element $A[$mid] = 2 występuje sukcesywnie w przedziale <$l,$r> 4 razy

    przyklad 2 
    $A = [1,1,2,2,3,3,3,3];
    $n = 8; $m = 1; $l = 2; $r = 7; $k =3; przy czym 3 >= floor((7-2+1)/2) = 3 >= 3
    czyli mamy znalezc liczbe z przedzialu <2,7> ktora sie powatrza co najmniej $k = 3 razy
    obliczamy $mid = ceil(2 + 7) / 2 = 5;
    oliczamy $L = [1,1,3,3,5,5,5,5]; 
    obliczamy $R = [2,2,4,4,8,8,8,8];
    oliczamy $repeat = min($R[5], 7) - max($L[5],2) + 1 = min(8,7) - max(5,2) + 1 = 7 - 5 + 1 = 3
    co się zgadza bo element $A[$mid] = 3 występuje sukcesywnie w przedziale <$l,$r> 3 razy

    przyklad 3 
    $A = [1,1,2,2,3,3,3,3,1,2];
    $n = 10; $m = 1; $l = 2; $r = 5; $k =2; przy czym 2 >= floor((5-2+1)/2) = 2 >= 2
    czyli mamy znalezc liczbe z przedzialu <2,5> ktora sie powatrza co najmniej $k = 2 razy
    obliczamy $mid = ceil(2 + 5) / 2 = 4;
    oliczamy $L = [1,1,3,3,5,5,5,5,9,10]; 
    obliczamy $R = [2,2,4,4,8,8,8,8,9,10];
    oliczamy $repeat = min($R[4], 5) - max($L[4],2) + 1 = min(4,5) - max(3,2) + 1 = 4 - 3 + 1 = 2
    co się zgadza bo element $A[$mid] = 2 występuje sukcesywnie w przedziale <$l,$r> 2 razy

    przyklad 4 
    $A = [1,1,2,3,3,3,3,3,3,2];
    $n = 10; $m = 1; $l = 2; $r = 10; $k =7; przy czym 7 >= floor((10-2+1)/2) = 7 >= 4
    czyli mamy znalezc liczbe z przedzialu <2,10> ktora sie powatrza co najmniej $k = 7 razy
    obliczamy $mid = ceil(2 + 10) / 2 = 6;
    oliczamy $L = [1,1,3,4,4,4,4,4,4,10]; 
    obliczamy $R = [2,2,3,9,9,9,9,9,9,10];
    oliczamy $repeat = min($R[6], 10) - max($L[6],2) + 1 = min(9,10) - max(4,2) + 1 = 9 - 4 + 1 = 6 
    co się zgadza bo element $A[$mid] = 3 występuje sukcesywnie w przedziale <$l,$r> 6 razy
    


*/
```
5. Porównujemy czy wynik sukcesywnych powtórzeń w zadanym przedziale <$l,$r> jest większy lub równy od podanego $k 
Jeśli tak jest to zwracamy liczbę $A[$mid] jako odpowiedź, gdyż ten element powtarza się sukcesywnie w przedziale <$l,$r>
więcej $k lub więcej razy, jeśli nie to zwracamy -1

```php
$output = $repeat >= $k ? $A[$mid] : -1;
```

4. Złożoność obliczeniowa algorytmu: **O(n + m)**
 

