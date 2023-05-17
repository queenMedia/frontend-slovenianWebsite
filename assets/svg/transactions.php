<?php
$date = date('Y-m-d', strtotime('last Monday'));
$transactions_year = date('Y', strtotime($date));
$date1 = date('d F', strtotime($date));
$date2 = date('d F', strtotime($date. ' -7 days'));
$date3 = date('d F', strtotime($date. ' -14 days'));
$date4 = date('d F', strtotime($date. ' -21 days'));
$date5 = date('d F', strtotime($date. ' -28 days'));
$date6 = date('d F', strtotime($date. ' -35 days'));
if ($transactions_year !== date('Y', strtotime($date. ' -35 days'))) {
    $transactions_year = date('Y', strtotime($date. ' -35 days')) . ' - ' . $transactions_year;
}
// Slovenian
$transactions = 'Transakcije';
$deposit_from = 'Polog od';
$interest = 'Obresti';
$transfer = 'Prenos';
function translate($date)
{
    $patterns = array(
        '~January~',
        '~February~',
        '~March~',
        '~April~',
        '~May~',
        '~June~',
        '~July~',
        '~August~',
        '~September~',
        '~October~',
        '~November~',
        '~December~',
    );
    $replacements = array(
        'Januar',
        'Februar',
        'Marec',
        'April',
        'Maj',
        'Junij',
        'Julij',
        'Avgust',
        'September',
        'Oktober',
        'November',
        'December',
    );
    $date = preg_replace($patterns, $replacements, $date);
//  $date = strtoupper($date);
    return $date;
}

$date1 = translate($date1);
$date2 = translate($date2);
$date3 = translate($date3);
$date4 = translate($date4);
$date5 = translate($date5);
$date6 = translate($date6);

?>
<!-- Generator: Adobe Illustrator 23.0.1, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     viewBox="0 0 267 519" class="hero-deposit-svg" xml:space="preserve">
                        <style type="text/css">
                            .st0{fill:#CECCCF;}
                            .st1{fill:#F5F1F2;}
                            .st2{fill:#28283A;}
                            .st3{font-family:'Arial-BoldMT';}
                            .st4{font-size:14px;}
                            .st5{font-size:9px;}
                            .st6{font-family:'ArialMT';}
                            .st7{font-size:11px;}
                            .st8{fill:#217C3F;}
                            .st9{font-size:12px;}
                            .st10{fill:none;stroke:#000000;stroke-width:0.75;stroke-miterlimit:10;}
                        </style>
    <rect y="43" class="st0" width="267" height="18"/>
    <rect y="125" class="st0" width="267" height="18"/>
    <rect y="207" class="st0" width="267" height="18"/>
    <rect y="290" class="st0" width="267" height="18"/>
    <rect y="372" class="st0" width="267" height="18"/>
    <rect y="454" class="st0" width="267" height="18"/>
    <rect class="st1" width="267" height="33"/>
    <text transform="matrix(1 0 0 1 7.1064 20.1274)" class="st2 st3 st4"> <?php echo $transactions; ?> <?php echo $transactions_year; ?></text>
    <text transform="matrix(1 0 0 1 5.1064 55.1274)" class="st2 st3 st5"><?php echo $date1; ?></text>
    <text transform="matrix(1 0 0 1 23.1064 111.1274)" class="st2 st6 st7"><?php echo $interest; ?></text>
    <text transform="matrix(1 0 0 1 188.1064 83.1274)" class="st8 st6 st9">+<?php echo $currency; ?>25,493.30</text>
    <text transform="matrix(1 0 0 1 188.1064 101.1274)" class="st2 st6 st9"><?php echo $currency; ?>489,796.13</text>
    <text transform="matrix(1 0 0 1 23.1064 84.5942)"><tspan x="0" y="0" class="st2 st6 st4"><?php echo $deposit_from; ?> </tspan><tspan x="0" y="13" class="st2 st6 st4"><?php echo $product_name; ?></tspan></text>
    <text transform="matrix(1 0 0 1 5.1064 138.1274)" class="st2 st3 st5"><?php echo $date2; ?></text>
    <text transform="matrix(1 0 0 1 5.1064 220.1274)" class="st2 st3 st5"><?php echo $date3; ?></text>
    <text transform="matrix(1 0 0 1 5.1064 302.1274)" class="st2 st3 st5"><?php echo $date4; ?></text>
    <text transform="matrix(1 0 0 1 5.1064 384.1274)" class="st2 st3 st5"><?php echo $date5; ?></text>
    <text transform="matrix(1 0 0 1 5.1064 467.1274)" class="st2 st3 st5"><?php echo $date6; ?></text>
    <polyline class="st10" points="6,88.3 11,93.6 16,88.3 "/>
    <text transform="matrix(1 0 0 1 23.1064 276.1274)" class="st2 st6 st7"><?php echo $interest; ?></text>
    <text transform="matrix(1 0 0 1 188.1064 248.1274)" class="st8 st6 st9">+<?php echo $currency; ?>19,583.39</text>
    <text transform="matrix(1 0 0 1 188.1064 266.1274)" class="st2 st6 st9"><?php echo $currency; ?>440,809.49</text>
    <text transform="matrix(1 0 0 1 23.1064 249.5942)"><tspan x="0" y="0" class="st2 st6 st4"><?php echo $deposit_from; ?> </tspan><tspan x="0" y="13" class="st2 st6 st4"><?php echo $product_name; ?></tspan></text>
    <polyline class="st10" points="6,253.3 11,258.6 16,253.3 "/>
    <text transform="matrix(1 0 0 1 23.1064 357.1274)" class="st2 st6 st7"><?php echo $interest; ?></text>
    <text transform="matrix(1 0 0 1 188.1064 329.1274)" class="st8 st6 st9">+<?php echo $currency; ?>10,394.43</text>
    <text transform="matrix(1 0 0 1 188.1064 347.1274)" class="st2 st6 st9"><?php echo $currency; ?>421,226.10</text>
    <text transform="matrix(1 0 0 1 23.1064 330.5942)"><tspan x="0" y="0" class="st2 st6 st4"><?php echo $deposit_from; ?> </tspan><tspan x="0" y="13" class="st2 st6 st4"><?php echo $product_name; ?></tspan></text>
    <polyline class="st10" points="6,334.3 11,339.6 16,334.3 "/>
    <text transform="matrix(1 0 0 1 23.1064 440.1274)" class="st2 st6 st7"><?php echo $interest; ?></text>
    <text transform="matrix(1 0 0 1 188.1064 412.1274)" class="st8 st6 st9">+<?php echo $currency; ?>17,393.33</text>
    <text transform="matrix(1 0 0 1 188.1064 430.1274)" class="st2 st6 st9"><?php echo $currency; ?>410,831.67</text>
    <text transform="matrix(1 0 0 1 23.1064 413.5942)"><tspan x="0" y="0" class="st2 st6 st4"><?php echo $deposit_from; ?> </tspan><tspan x="0" y="13" class="st2 st6 st4"><?php echo $product_name; ?></tspan></text>
    <text transform="matrix(1 0 0 1 188.1064 494.1274)" class="st8 st6 st9">+<?php echo $currency; ?>11,394.22</text>
    <text transform="matrix(1 0 0 1 23.1064 495.5942)"><tspan x="0" y="0" class="st2 st6 st4"><?php echo $deposit_from; ?> </tspan><tspan x="0" y="13" class="st2 st6 st4"><?php echo $product_name; ?></tspan></text>
    <polyline class="st10" points="6,417.3 11,422.6 16,417.3 "/>
    <text transform="matrix(1 0 0 1 23.1064 193.1274)" class="st2 st6 st7"><?php echo $transfer; ?></text>
    <text transform="matrix(1 0 0 1 188.1064 165.1274)" class="st8 st6 st9">+<?php echo $currency; ?>23,493.34</text>
    <text transform="matrix(1 0 0 1 188.1064 183.1274)" class="st2 st6 st9"><?php echo $currency; ?>464,302.83</text>
    <text transform="matrix(1 0 0 1 23.1064 166.5942)"><tspan x="0" y="0" class="st2 st6 st4"><?php echo $deposit_from; ?> </tspan><tspan x="0" y="13" class="st2 st6 st4"><?php echo $product_name; ?></tspan></text>
    <polyline class="st10" points="6,170.4 11,175.7 16,170.4 "/>
</svg>