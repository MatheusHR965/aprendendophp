<?php 

    //TRATANDO DATAS

    $raw = '22.11.1968';
    $start = DateTime::createFromFormat('d.m.Y', $raw);
    echo "Data de inicio:" .$start -> format('Y-m-D'). "\n";

    $end = clone $start;
    $end -> add(new Dateinterval('P1M6D'));
    
    $diff = $end -> diff($start);
    echo "diferença:".$diff -> format('%m mês, %d dias (total: %a dias)'). "\n";

    if($start < $end) {
        echo "começo antes do fim!\n";
    
    }

    $periodointerval = Dateinterval::createFromDateString('first thursday');
    $periodointerator = new Dateperiod($start, $periodointerval, $end, 
    DatePeriod::EXCLUDE_START_DATE);

    foreach($periodointerator as $date) {
            echo $date -> format('d-m-Y'). "";
    }
?>