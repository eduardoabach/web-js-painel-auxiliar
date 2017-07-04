<?php
require_once strstr(__DIR__, '/modules/', true).'/modules/tools/core.php';
sys_set_module(__DIR__);

/*
É uma library PHP para cálculos envolvendo astros, em especial o sol e a lua. Suas posições e fases.
 
Baseado no trabalho: Vladimir Agafonkin's JavaScript library.

Cálculos solares baseados em: http://aa.quae.nl/en/reken/zonpositie.html
Cálculos lunares baseados em: http://aa.quae.nl/en/reken/hemelpositie.html

Cálculos de iluminação e parametros lunares baseados em:
Capítulo 48 de "Astronomical Algorithms" 2nd edition by Jean Meeus (Willmann-Bell, Richmond) 1998.
E na url: http://idlastro.gsfc.nasa.gov/ftp/pro/astro/mphase.pro 

Cálculos de posição da lua baseados em:
http://www.stargazing.net/kepler/moonrise.html
*/

// para facilitar a leitura de fórmulas
define('PI', M_PI);
define('rad', PI / 180);

// date/time constantes e conversões
define('daySec', 86400); //60 * 60 * 24
define('J1970', 2440588);
define('J2000', 2451545);
// cálculos gerais para posição
define('e', rad * 23.4397); // obliquidade da Terra
define('J0', 0.0009);


function toJulian($date) { return $date->getTimestamp() / daySec - 0.5 + J1970; }
function fromJulian($j)  {
    if (!is_nan($j)) {
        $dt = new DateTime("@".round(($j + 0.5 - J1970) * daySec));
        $dt->setTimezone((new DateTime())->getTimezone());
        return $dt;
    }
}
function toDays($date)   { return toJulian($date) - J2000; }

function rightAscension($l, $b) { return atan2(sin($l) * cos(e) - tan($b) * sin(e), cos($l)); }
function declination($l, $b)    { return asin(sin($b) * cos(e) + cos($b) * sin(e) * sin($l)); }

function azimuth($H, $phi, $dec)  { return atan2(sin($H), cos($H) * sin($phi) - tan($dec) * cos($phi)); }
function altitude($H, $phi, $dec) { return asin(sin($phi) * sin($dec) + cos($phi) * cos($dec) * cos($H)); }

function siderealTime($d, $lw) { return rad * (280.16 + 360.9856235 * $d) - $lw; }

// cálculo para o tempo solar
function julianCycle($d, $lw) { return round($d - J0 - $lw / (2 * PI)); }

function approxTransit($Ht, $lw, $n) { return J0 + ($Ht + $lw) / (2 * PI) + $n; }
function solarTransitJ($ds, $M, $L)  { return J2000 + $ds + 0.0053 * sin($M) - 0.0069 * sin(2 * $L); }

function hourAngle($h, $phi, $d) { return acos((sin($h) - sin($phi) * sin($d)) / (cos($phi) * cos($d))); }

// returns set time for the given sun altitude
function getSetJ($h, $lw, $phi, $dec, $n, $M, $L) {
    $w = hourAngle($h, $phi, $dec);
    $a = approxTransit($w, $lw, $n);
    return solarTransitJ($a, $M, $L);
}

// gerar cálculos gerais do sol
function solarMeanAnomaly($d){ return rad * (357.5291 + 0.98560028 * $d); }
function eclipticLongitude($M){
    $C = rad * (1.9148 * sin($M) + 0.02 * sin(2 * $M) + 0.0003 * sin(3 * $M)); // equation of center
    $P = rad * 102.9372; // periélio da Terra
    return $M + $C + $P + PI;
}

function hoursLater($date, $h) {
    $dt = clone $date;
    return $dt->add( new DateInterval('PT'.round($h*3600).'S') );
}

class DecRa {
    public $dec;
    public $ra;
    function __construct($d, $r) {
        $this->dec = $d;
        $this->ra  = $r;
    }
}

class DecRaDist extends DecRa {
    public $dist;
    function __construct($d, $r, $dist) {
        parent::__construct($d, $r);
        $this->dist = $dist;
    }
}

class AzAlt {
    public $azimuth;
    public $altitude;
    function __construct($az, $alt) {
        $this->azimuth = $az;
        $this->altitude = $alt;
    }
}

class AzAltDist extends AzAlt {
    public $dist;
    function __construct($az, $alt, $dist) {
        parent::__construct($az, $alt);
        $this->dist = $dist;
    }
}

function sunCoords($d) {
    $M = solarMeanAnomaly($d);
    $L = eclipticLongitude($M);
    return new DecRa(
        declination($L, 0),
        rightAscension($L, 0)
    );
}

function moonCoords($d){ // Coordenadas eclípticas geocêntricas da lua
    $L = rad * (218.316 + 13.176396 * $d); // ecliptic longitude
    $M = rad * (134.963 + 13.064993 * $d); // mean anomaly
    $F = rad * (93.272 + 13.229350 * $d);  // mean distance

    $l  = $L + rad * 6.289 * sin($M); // longitude
    $b  = rad * 5.128 * sin($F);     // latitude
    $dt = 385001 - 20905 * cos($M);  // distance to the moon in km

    return new DecRaDist(
        declination($l, $b),
        rightAscension($l, $b),
        $dt
    );
}

class Planetas {
    var $date;
    var $lat;
    var $lng;

    // configuração do tempo solar (angle, morning name, evening name)
    private $times = [
        [-0.833, 'nascerSol',       'porSol'   ], // 'sunrise',       'sunset'
        [  -0.3, 'nascerSolFim',    'porSolIni'], // 'sunriseEnd',    'sunsetStart'
        [    -6, 'amanhecer',     'crepusculo' ], // 'dawn',          'dusk'
        [   -12, 'nauticoIni',     'nauticoFim'], // 'nauticalDawn',  'nauticalDusk'
        [   -18, 'noiteFim',          'noite'  ], // 'nightEnd',      'night'
        [     6, 'horaDouradaFim','horaDourada'] // 'goldenHourEnd', 'goldenHour'
    ];

    // adicionar tempo customizado na config
    private function addTime($angle, $riseName, $setName) {
        $this->times[] = [$angle, $riseName, $setName];
    }

    function __construct($date=null, $lat=null, $lng=null) {
        $this->date = $date;

        if(!$lat || !$lng){
            $posGeoDefault = sys_pos_geo();
            $lat = $posGeoDefault['lat'];
            $lng = $posGeoDefault['lng'];
        }

        $this->lat  = $lat;
        $this->lng  = $lng;
    }

    function getInfo($date=null){
        if($date)
            $this->date = $date;

        $info = $this->getInfoSol();
        $info['lua'] = $this->getInfoLua($infoSol['luz_dia_naut']);
        return $info;
    }

    /* Informar o tempo de luz do dia para cálculo opicional da visibilidade da lua */
    function getInfoLua($tempoLuzDia=array()){
        $momentos = array();
        $dtDia = $this->date->format('Y-m-d');

        $luaLuz = $this->getMoonIllumination();
        if(is_array($luaLuz) && count($luaLuz) > 0){
            $momentos['fase'] = $luaLuz['phase'];
            $momentos['luz'] = $luaLuz['fraction'];
            $momentos['angulo'] = $luaLuz['angle'];
        }

        $luaPresenca = $this->getMoonTimes();
        if(is_array($luaPresenca) && count($luaPresenca) > 0){

            // não existe saida quando o ciclo for completo
            if(!isset($luaPresenca['lua_sair']))
                $luaPresenca['lua_sair'] = new DateTime($dtDia.' 23:59:59');
            
            $segLuaPresent = segundos_entre_datas($luaPresenca['lua_sair']->format('Y-m-d H:i:s'), $luaPresenca['lua_nascer']->format('Y-m-d H:i:s'));
            $momentos['presenca']['nascer'] = $luaPresenca['lua_nascer']->format('H:i:s');
            $momentos['presenca']['sair'] = $luaPresenca['lua_sair']->format('H:i:s');
            $momentos['presenca']['tempo'] = segundos_to_hora($segDiaAstr);
            $momentos['presenca']['segundos'] = $segLuaPresent;

            if(isset($tempoLuzDia['ini']) && isset($tempoLuzDia['fim'])){
                // Para o visível vou ter que verificar quais dos eventos de exibicao acontece por ultimo, e qual dos de saida acontece primeiro
                $luaAparece = $momentos['presenca']['nascer'];
                $luaVisivel = $tempoLuzDia['fim'];
                $luaPresencaAntesEstarVisivel = segundos_entre_horas($luaAparece, $luaVisivel); // valor negativo significa antes
                $horaUltiEventVisivel = ($luaPresencaAntesEstarVisivel < 0) ? $luaVisivel : $luaAparece;
                $luaDtVisIni = new DateTime($dtDia.' '.$horaUltiEventVisivel);

                $luaSair = $momentos['presenca']['sair'];
                $luaNaoVisivel = $tempoLuzDia['ini'];
                $luaSairAntesNaoVisivel = segundos_entre_horas($luaSair, $luaNaoVisivel);
                $horaPrimeiroEventInvisivel = ($luaSairAntesNaoVisivel > 0) ? $luaSair : $luaNaoVisivel;
                $luaDtVisFim = new DateTime($dtDia.' '.$horaPrimeiroEventInvisivel);

                $segLuaVisivel = segundos_entre_datas($luaDtVisFim->format('Y-m-d H:i:s'), $luaDtVisIni->format('Y-m-d H:i:s'));
                $momentos['presen_visivel_noite']['visivel'] = $horaUltiEventVisivel;
                $momentos['presen_visivel_noite']['fora'] = $horaPrimeiroEventInvisivel;
                $momentos['presen_visivel_noite']['tempo'] = segundos_to_hora($segLuaVisivel);
                $momentos['presen_visivel_noite']['segundos'] = $segLuaVisivel;
            }
        }

        return $momentos;
    }

    function getInfoSol(){
        $momentos = array();
        $hSol = $this->getSunTimes();
        if(is_array($hSol) && count($hSol) > 0){
            $momentos['meio_dia_solar'] = $hSol['solMeioDia']->format('H:i:s');

            $segDiaPleno = segundos_entre_datas($hSol['horaDourada']->format('Y-m-d H:i:s'), $hSol['horaDouradaFim']->format('Y-m-d H:i:s'));
            $momentos['luz_dia_plena']['ini'] = $hSol['horaDouradaFim']->format('H:i:s');
            $momentos['luz_dia_plena']['fim'] = $hSol['horaDourada']->format('H:i:s');
            $momentos['luz_dia_plena']['tempo'] = segundos_to_hora($segDiaPleno);
            $momentos['luz_dia_plena']['segundos'] = $segDiaPleno;

            $segDiaCiv = segundos_entre_datas($hSol['crepusculo']->format('Y-m-d H:i:s'), $hSol['amanhecer']->format('Y-m-d H:i:s'));
            $momentos['luz_dia_civ']['ini'] = $hSol['amanhecer']->format('H:i:s');
            $momentos['luz_dia_civ']['fim'] = $hSol['crepusculo']->format('H:i:s');
            $momentos['luz_dia_civ']['tempo'] = segundos_to_hora($segDiaCiv);
            $momentos['luz_dia_civ']['segundos'] = $segDiaCiv;

            $segDiaNaut = segundos_entre_datas($hSol['nauticoFim']->format('Y-m-d H:i:s'), $hSol['nauticoIni']->format('Y-m-d H:i:s'));
            $momentos['luz_dia_naut']['ini'] = $hSol['nauticoIni']->format('H:i:s');
            $momentos['luz_dia_naut']['fim'] = $hSol['nauticoFim']->format('H:i:s');
            $momentos['luz_dia_naut']['tempo'] = segundos_to_hora($segDiaNaut);
            $momentos['luz_dia_naut']['segundos'] = $segDiaNaut;

            $segDiaAstr = segundos_entre_datas($hSol['noite']->format('Y-m-d H:i:s'), $hSol['noiteFim']->format('Y-m-d H:i:s'));
            $momentos['luz_dia_astr']['ini'] = $hSol['noiteFim']->format('H:i:s');
            $momentos['luz_dia_astr']['fim'] = $hSol['noite']->format('H:i:s');
            $momentos['luz_dia_astr']['tempo'] = segundos_to_hora($segDiaAstr);
            $momentos['luz_dia_astr']['segundos'] = $segDiaAstr;
            
            $momentos['nascer_sol']['ini'] = $hSol['nascerSol']->format('H:i:s');
            $momentos['nascer_sol']['fim'] = $hSol['nascerSolFim']->format('H:i:s');

            $momentos['por_sol']['ini'] = $hSol['porSolIni']->format('H:i:s');
            $momentos['por_sol']['fim'] = $hSol['porSol']->format('H:i:s');
        }

        return $momentos;
    }

    // calcular a posição do sol por uma data e latitude/longitude
    function getSunPosition($date=null) {
        $d = ($date !== null) ? toDays($date) : toDays($this->date);
        $lw  = rad * -$this->lng;
        $phi = rad * $this->lat;

        $c   = sunCoords($d);
        $H   = siderealTime($d, $lw) - $c->ra;

        return new AzAlt(
            azimuth($H, $phi, $c->dec),
            altitude($H, $phi, $c->dec)
        );
    }

    // calculates sun times for a given date and latitude/longitude
    function getSunTimes($date=null) {
        $d = ($date !== null) ? toDays($date) : toDays($this->date);
        $lw = rad * -$this->lng;
        $phi = rad * $this->lat;

        $n = julianCycle($d, $lw);
        $ds = approxTransit(0, $lw, $n);

        $M = solarMeanAnomaly($ds);
        $L = eclipticLongitude($M);
        $dec = declination($L, 0);

        $Jnoon = solarTransitJ($ds, $M, $L);

        $result = [
            'solMeioDia' => fromJulian($Jnoon),
            'solMaxOposicao' => fromJulian($Jnoon - 0.5)
        ];

        for ($i = 0, $len = count($this->times); $i < $len; $i += 1) {
            $time = $this->times[$i];

            $Jset = getSetJ($time[0] * rad, $lw, $phi, $dec, $n, $M, $L);
            $Jrise = $Jnoon - ($Jset - $Jnoon);

            $result[$time[1]] = fromJulian($Jrise);
            $result[$time[2]] = fromJulian($Jset);
        }

        return $result;
    }

    function getMoonPosition($date=null){
        $d = ($date !== null) ? toDays($date) : toDays($this->date);
        $lw  = rad * -$this->lng;
        $phi = rad * $this->lat;

        $c = moonCoords($d);
        $H = siderealTime($d, $lw) - $c->ra;
        $h = altitude($H, $phi, $c->dec);

        // altitude correction for refraction
        $h = $h + rad * 0.017 / tan($h + rad * 10.26 / ($h + rad * 5.10));

        return new AzAltDist(
            azimuth($H, $phi, $c->dec),
            $h,
            $c->dist
        );
    }

    function getMoonIllumination($date=null){
        $d = ($date !== null) ? toDays($date) : toDays($this->date);
        $s = sunCoords($d);
        $m = moonCoords($d);

        $sdist = 149598000; // distance from Earth to Sun in km

        $phi = acos(sin($s->dec) * sin($m->dec) + cos($s->dec) * cos($m->dec) * cos($s->ra - $m->ra));
        $inc = atan2($sdist * sin($phi), $m->dist - $sdist * cos($phi));
        $angle = atan2(cos($s->dec) * sin($s->ra - $m->ra), sin($s->dec) * cos($m->dec) - cos($s->dec) * sin($m->dec) * cos($s->ra - $m->ra));

        return [
            'fraction' => (1 + cos($inc)) / 2,
            'phase'    => 0.5 + 0.5 * $inc * ($angle < 0 ? -1 : 1) / PI,
            'angle'    => $angle
        ];
    }

    function getMoonTimes($inUTC=false, $date=null){
        // $t = clone $this->date;
        $t = ($date !== null) ? clone $date : clone $this->date;
        if ($inUTC) $t->setTimezone(new DateTimeZone('UTC'));

        $t->setTime(0, 0, 0);

        $hc = 0.133 * rad;
        $h0 = $this->getMoonPosition($t, $this->lat, $this->lng)->altitude - $hc;
        $rise = 0;
        $set = 0;

        // go in 2-hour chunks, each time seeing if a 3-point quadratic curve crosses zero (which means rise or set)
        for ($i = 1; $i <= 24; $i += 2) {
            $h1 = $this->getMoonPosition(hoursLater($t, $i), $this->lat, $this->lng)->altitude - $hc;
            $h2 = $this->getMoonPosition(hoursLater($t, $i + 1), $this->lat, $this->lng)->altitude - $hc;

            $a = ($h0 + $h2) / 2 - $h1;
            $b = ($h2 - $h0) / 2;
            $xe = -$b / (2 * $a);
            $ye = ($a * $xe + $b) * $xe + $h1;
            $d = $b * $b - 4 * $a * $h1;
            $roots = 0;

            if ($d >= 0) {
                $dx = sqrt($d) / (abs($a) * 2);
                $x1 = $xe - $dx;
                $x2 = $xe + $dx;
                if (abs($x1) <= 1) $roots++;
                if (abs($x2) <= 1) $roots++;
                if ($x1 < -1) $x1 = $x2;
            }

            if ($roots === 1) {
                if ($h0 < 0) $rise = $i + $x1;
                else $set = $i + $x1;

            } else if ($roots === 2) {
                $rise = $i + ($ye < 0 ? $x2 : $x1);
                $set = $i + ($ye < 0 ? $x1 : $x2);
            }

            if ($rise != 0 && $set != 0) break;

            $h0 = $h2;
        }

        $result = [];

        if ($rise != 0) $result['lua_nascer'] = hoursLater($t, $rise);
        if ($set != 0) $result['lua_sair'] = hoursLater($t, $set);

        if ($rise==0 && $set==0) $result[$ye > 0 ? 'alwaysUp' : 'alwaysDown'] = true;

        return $result;
    }
}