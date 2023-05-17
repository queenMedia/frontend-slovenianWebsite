<?php

$dynamic_param_names = array(
    "sxid",
    "country",
    "region",
    "city",
    "campid",
    "offerid",

    "" // last element, no comma
);

$lang = 'sl';
$currency = '€';
$deposit = '300';
$current_year = date('Y');

$step1 = 'https://www.lotharen.com/click';


$product_name = 'Bitcoin Code';
$product_name = productName($product_name, 'p', array('_popup.svg'));
$product_image = productDir() . imageName($product_name);
$product_dir = productDir();

$gender = 1;
$hero = '';
$hero = getHero($hero, 'a');
$hero_first_name = substr($hero, 0, strpos($hero, " "));
$hero_last_name = substr($hero, strpos($hero, " ") + 1);
$hero_last_name_accusative = '<span style="color:red"> [!!! need to set accusative !!!] </span>';
$hero_last_name_instrumental = '<span style="color:red"> [!!! need to set instrumental !!!] </span>';

$article_dir = getArticleDir($hero);

if (isset($article_dir) && $article_dir) {
    $hero_file = $article_dir . '/hero.php';
    if (isset($hero_file) && $hero_file && file_exists($hero_file)) {
        include_once $hero_file;
    }
}

$title = 'POSEBNO POROČILO: Najnovej&scaron;a Investicija ' . $hero_accusative . ' Je Prestra&scaron;ila Vlado In Velike Banke';
$h1 = '<u>POSEBNO POROČILO:</u> Najnovej&scaron;a Investicija ' . $hero_accusative . ' Je Prestra&scaron;ila Vlado In Velike Banke';

$header = getHeader();

function getHeader($default = 'default')
{
  $header = (isset($_GET['header']) && $_GET['header']) ? $_GET['header'] : $default;
  $header = htmlspecialchars($header);
  if (!$header || !is_dir("parts/header/${header}")) {
    $header = $default;
  }
  return $header;
}

function hero($gender, $param)
{
    $hero = array(
        'his' => array('her', 'his', 'their'),
        'he' => array('she', 'he', 'they'),
        'Mr.' => array('Ms.', 'Mr.', ''),
        'goes' => array('goes', 'goes', 'go'),
        'is' => array('is', 'is', 'are'),
        'was' => array('was', 'was', 'were'),
    );
    $gender = isset($gender) ? (int)$gender : 1;
    if (isset($hero[$param]) && isset($hero[$param][$gender])) {
        return $hero[$param][$gender];
    }
    return $param;
}

function getHeroes()
{
    $heroes = [];
    $dir = realpath(getcwd() . '/articles/');
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($e = readdir($dh)) !== false) {
                if (($e == ".") || ($e == "..")) {
                    continue;
                }
                $article_dir = $dir . '/' . $e;
                if (is_dir($article_dir)) {
                    $hero_name = str_replace('_', ' ', $e);
                    $hero_name = mb_convert_case($hero_name, MB_CASE_TITLE, "UTF-8");
                    $heroes[] = $hero_name;
                }
            }
            closedir($dh);
        }
    }
    return $heroes;
}

function getHero($hero = '', $param = 'a')
{
    $heroes = getHeroes();
    if (isset($param) && $param && isset($_GET[$param]) && $_GET[$param]) {
        $hero_name = str_replace('_', ' ', urldecode($_GET[$param]));
        $hero_name = mb_convert_case($hero_name, MB_CASE_TITLE, "UTF-8");
        if (isset($heroes) && is_array($heroes) && $heroes) {
            $latin_hero_name = convertToLatin($hero_name);
            foreach ($heroes as $dir_hero_name) {
                if ($latin_hero_name === convertToLatin($dir_hero_name)) {
                    $hero = $dir_hero_name;
                    break;
                }
            }
        }
    }
    if ($hero === '' && isset($heroes) && is_array($heroes) && isset($heroes[0])) {
        $hero = $heroes[0];
    }
    $hero = customizeHeroName($hero);
    return $hero;
}

function customizeHeroName($hero)
{
    $hero = str_replace(' And ', ' and ', $hero);
    $hero = str_replace(' Van ', ' van ', $hero);
    $hero = str_replace(' Der ', ' der ', $hero);
    $hero = str_replace(' De ', ' de ', $hero);
    $hero = preg_replace_callback('~O\'.~', function ($matches) {
        return strtoupper($matches[0]);
    }, $hero);
    return $hero;
}

function getArticleDir($hero)
{
    $article_dir = '';
    $hero_dir = '';
    if (isset($hero)) {
        $hero_name = trim($hero, '/');
        if ($hero_name) {
            $hero_dir = str_replace(' ', '_', mb_strtolower($hero_name, "UTF-8"));
        }
    }
    if ($hero_dir) {
        $article_dir = './articles/' . $hero_dir;
    }
    return $article_dir;
}

function convertToLatin($string)
{
    if (strpos($string = htmlentities($string, ENT_QUOTES, 'UTF-8'), '&') !== false) {
        $string = html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|tilde|uml);~i', '$1', $string), ENT_QUOTES, 'UTF-8');
    }
    return $string;
}

function assetsDir()
{
    return 'assets/';
}

function productDir()
{
    return assetsDir() . 'product/';
}

function imageName($product_name)
{
    return str_replace(' ', '_', strtolower(trim($product_name)));
}

function productName($product_name, $param, $images_required)
{
    if (isset($product_name) && $product_name
        && isset($param) && $param && in_array($param, array('p', 'p1', 'p2'))
        && isset($images_required) && is_array($images_required) && $images_required
    ) {
        if (isset($_GET[$param]) && $_GET[$param]) {
            $funnel_name = str_replace('_', ' ', urldecode($_GET[$param]));
            $funnel_image_name = imageName($funnel_name);
            $images_found = true;
            foreach ($images_required as $image_required) {
                if (!file_exists('./' . productDir() . $funnel_image_name . $image_required)) {
                    $images_found = false;
                    break;
                }
            }
            if ($images_found) {
                $product_name = $funnel_name;
            }
        }
    }
    return $product_name;
}

$dynamic_param_values = array();
foreach ($dynamic_param_names as $param_name) {
    if ($param_name !== "") {
        $param_value = (isset($_GET[$param_name]) && (strlen($_GET[$param_name]) > 0)) ? $_GET[$param_name] : "na";
        $dynamic_param_values[$param_name] = $param_value;
    }
}

$param_name = "sxid";
if (isset($_GET[$param_name]) && (0 < strlen($_GET[$param_name]))) {
    $step1 = $step1 . "?sxid=" . $_GET[$param_name];
} else {
    $step1 = $step1 . "?sxid=0";
}

/* prelander id */
if (file_exists('prelander_id.php')) {
    require_once 'prelander_id.php';
}

$is_mobile = false;

$useragent = $_SERVER['HTTP_USER_AGENT'];

if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
    $is_mobile = true;
}

if (($is_mobile == false)) {
    $show_popup = true;
}

$popup_link_url = $step1 . "&popup_ind=exit";

if (isset($show_popup) && ($show_popup == true)) {
    $popup_link_url .= "&campid=" . $dynamic_param_values["campid"];
    $popup_link_url .= "&offerid=" . $dynamic_param_values["offerid"];
    $popup_link_url .= "&clkid=" . $dynamic_param_values["sxid"];

    $popup_link_cpn = $popup_link_url . "&clkloc=cpn";
    $popup_link_notnx = $popup_link_url . "&clkloc=notnx";
    $popup_link_frame = $popup_link_url . "&clkloc=frame";

    $exit_popup_header = 'Dont miss out!';
    $exit_popup_paragraph = 'This is your LAST chance to enter the';
    $exit_popup_button = 'Start Now';

    $translations_file = 'exit-popup/translations/translations.php';
    if (file_exists($translations_file) && isset($lang)) {
        require_once $translations_file;
        if (isset($translations) && is_array($translations) && isset($translations[$lang])) {
            if (isset($translations[$lang][0])) {
                $exit_popup_header = $translations[$lang][0];
            }
            if (isset($translations[$lang][1])) {
                $exit_popup_paragraph = $translations[$lang][1];
            }
            if (isset($translations[$lang][2])) {
                $exit_popup_button = $translations[$lang][2];
            }
        }
    }

    $html_markup = '<a href="' . $popup_link_cpn . '" target="_blank"><div class="modal-images">'
        . '<div class="cta_popup_btn_wrap"><div class="cta_popup_btn ' . imageName($product_name) . '_product_style">' . $exit_popup_button . '</div></div>'
        . '<object id="svg-id" type="image/svg+xml" data="' . $product_image . '_popup.svg">'
        . '<param name="popup" value="true"></object></div></a>';
}
if (isset($article_dir) && $article_dir) {
    $title_file = $article_dir . '/title.php';
    if (isset($title_file) && $title_file && file_exists($title_file)) {
        include_once $title_file;
    }
}

$blocks_file = './parts/blocks/blocks.php';

if (file_exists($blocks_file)) {
    $blocks = include_once($blocks_file);
}
// read more button
$read_more = readMore();

function readMore() {
    $read_more_param = (isset($_GET['readmore']) && $_GET['readmore'] === 'off') ? 'false' : 'true';
    return $read_more_param;
}

// tweeter post param
$twitter = twitter();

function twitter() {
    $twitter_param = (isset($_GET['twitter']) && $_GET['twitter'] === 'on') ? true : false;
    return $twitter_param;
}

?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="BREAKING">
  <title><?php echo $title; ?></title>
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
    <link href="assets/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css" type="text/css">
  <link rel="stylesheet" href="assets/logo.css" type="text/css">
  <link href="//fonts.googleapis.com/css?family=Anton" rel="stylesheet">
  <meta name="referrer" content="none">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script src="assets/today.js"></script>
</head>
<body data-rsssl="1" class="article-page news"><?php
if (isset($show_popup) && ($show_popup == true)) {
    ?> <!-- placed here to override bootstrap clash -->
  <link rel="stylesheet" href="./exit-popup/popup-assets/css/ouibounce.css"/>
  <script src="./exit-popup/popup-assets/js/ouibounce.js"></script>
  <script>
      var _ouibounce = ouibounce({
          aggressive: true,
          timer: 0,
          cookieExpire: 30,
          htmlMarkup: '<?php echo $html_markup; ?>',
          linkUrl: '<?php echo $popup_link_cpn; ?>',
          headerTranslation: '<?php echo $exit_popup_header; ?>',
          paragraphTranslation: '<?php echo $exit_popup_paragraph; ?>'
      });
  </script><?php
}
?>
<?php
$part = './parts/twitter/index.php';
if (isset($part) && $part && file_exists($part)) {
    include_once $part;
}
?>
<?php
if (isset($header) && $header) {
  $header_file = "./parts/header/${header}/header.php";
  if (file_exists($header_file)) {
    include_once $header_file;
  }
}
?>

<section class="content-box">
  <div class="container content">
    <div class="row" id="story">
      <div class="col-md-8">
        <!--                <h1><a href="--><?php //echo $step1; ?><!--" style="text-decoration: none; color: inherit;" target="_blank"><u>POSEBNO-->
        <!--                            POROČILO:</u> --><?php //echo $hero; ?><!--Najnovej&scaron;a Investicija Damjana Murka Je Prestra&scaron;ila-->
        <!--                        Vlado In Velike Banke</a></h1>-->
        <h1>
          <a href="<?php echo $step1; ?>" style="text-decoration: none; color: inherit;" target="_blank"><?php echo $h1; ?></a>
        </h1>
        <p>
          <em>Slovenski državljani že kopičijo milijone evrov od doma z uporabo te "vrzeli bogastva" - ampak je to zakonito?</em>
        </p>
        <a href="<?php echo $step1; ?>" target="_blank"><img src="assets/as-seen-on-image-CA.png" class="img-responsive" style="padding: 0px;" alt=""></a>
          <?php
          if (isset($article_dir) && $article_dir) {
              $article_file = $article_dir . '/article.php';
              if (isset($article_file) && $article_file && file_exists($article_file)) {
                  include_once $article_file;
              }
          }
          ?>
          <?php
          $index_gender_file = "./parts/index_gender_${gender}.php";
          if (isset($index_gender_file) && $index_gender_file && file_exists($index_gender_file)) {
              include_once $index_gender_file;
          }
          ?>


        <p></p>

        <h2>
          <a href="<?php echo $step1; ?>" style="text-decoration: none; color: inherit;" target="_blank"><b style="text-transform: uppercase; text-align: center">kako začetni z <?php echo $product_name; ?> (mesta so omejena)</b></a>
        </h2>
        <p class="m-t-25">Da začnete boste potrebovali le va&scaron; računalnik, pametni telefon ali tablico z dostopom do spleta. Ne potrebujete določenih ve&scaron;čin razen poznavanja uporabe računalnika ter brskanja spleta. Ne potrebujete kakr&scaron;nih koli izku&scaron;en s tehnologijo ali kriptovalutami, zaradi programske opreme in va&scaron;ega osebnega investitorja,
          <a href="<?php echo $step1; ?>" target="_blank">ki jamčita, da boste ustvarili prihodek</a>. </p>
        <p class="m-t-25">&Scaron;e ena prednost tega programa je, da začnete, ko si to želite. Ustvarite lahko va&scaron; lasten urnik - bodisi 5 ur tedensko ali 50 ur tedensko. Samo zaženite samodejno programsko opremo trgovanja, ko si to želite in ustavite jo lahko kadarkoli si želite (ampak ne vem zakaj bi jo sploh kdaj ustavili).</p>
        <p class="m-t-25">Da prihranimo čas na&scaron;ih bralcev smo &scaron;e enkrat preverili funkcionalnost platforme, Lovro Kos je bil prijazno ustvaril vodič o začetkih pri tem sistemu. </p>
        <h2>
          <a href="<?php echo $step1; ?>" style="text-decoration: none; color: inherit;" target="_blank"><b style="text-transform: uppercase; text-align: center">Tukaj je Moj korak za korakom vodič:</b></a>
        </h2>
        <p class="m-t-25">Prva stvar, ki jo vidite je video, ki kaže moč
          <a href="<?php echo $step1; ?>" target="_blank"><?php echo $product_name; ?></a>. Ogla&scaron;evanje je veliko in drzno ter v va&scaron;em obrazu, ampak to je ameri&scaron;ki proizvod in tako oni to počnejo. Kakorkoli, vi
          <a href="<?php echo $step1; ?>" target="_blank">enostavno vnesete va&scaron;e ime ter e-po&scaron;tni naslov</a> zraven posnetka, tako da takoj začnete.
        </p>
        <p class="m-t-25"><em>(<strong>Nasvet</strong>: Tudi če se niste odločili investirati denarja, priporočam
            <a href="<?php echo $step1; ?>" target="_blank">da se sedaj prijavite</a>, ker je to brezplačno in registracije za prebivalce Slovenije se lahko katerikoli trenutek končajo)</em>
        </p>
        <a href="<?php echo $step1; ?>" target="_blank"><img src="<?php echo $product_image; ?>_body_step1.png" class="img-responsive" style="padding: 0px;"></a>
        <p class="m-t-25">Nato vas bodo prosili, da
          <a href="<?php echo $step1; ?>" target="_blank">financirate va&scaron; račun</a>. Ko sem krmaril po strani vplačila je zazvonil moj telefon. Bila je mednarodna &scaron;tevilka, tako da sem bil neodločen glede odgovarjanja, ampak nato sem ugotovil od koga to očitno je.
        </p>
        <a href="<?php echo $step1; ?>" target="_blank"><img src="assets/cta2.jpg.png" class="img-responsive" style="padding: 0px;"></a>
        <p class="m-t-25">Dejansko je bilo od mojega osebnega voditelja računa. Njegova storitev je bila odlična. Popeljal me je skozi celoten postopek financiranja. Sprejemajo vse velike kreditne kartice kot so Visa, MasterCard ter American Express. Nadaljeval sem in vplačal minimalno količino, ki je <?php echo $currency; ?><?php echo $deposit; ?>.</p>
        <a href="<?php echo $step1; ?>" target="_blank"><img src="assets/cta3.jpg.png" class="img-responsive" style="padding: 0px;"></a>
        <p class="m-t-25">Ko je bilo financiranja končano, sem krmaril do odseka "Samodejni Trgovec" programske opreme, nastavil količino izmenjav na priporočenih <?php echo $currency; ?>50 ter ga omogočil. Programska oprema je začela hitro ustvarjati izmenjave in najprej me je bilo strah, ampak omogočil sem ji samostojno delovanje.</p>

        <p class="m-t-25">
          <em>"Vsi si želijo postati bogati, ampak nihče ne ve kako to storiti. No to je priložnost življenja za gradnjo bogastva, ki vam bo omogočilo, da živite življenje, ki si ga res želite. To NE bo za vedno obstajalo, tako da ne zamudite."</em> - <strong> <?php echo $hero; ?></strong>
          <strong></strong></p>
        <h2>
          <a href="<?php echo $step1; ?>" style="text-decoration: none; color: inherit;" target="_blank"><b style="text-transform: uppercase; text-align: center">POSODOBITEV</b></a>
        </h2>
        <p>Pravkar smo prejeli novico, da od danes dalje (<script> today("<?php echo $lang; ?>"); </script>) so skoraj vsi položaji za prebivalce Slovenije zapolnjeni.
          <a href="<?php echo $step1; ?>" target="_blank"><?php echo $product_name; ?></a> sprejema lahko samo omejeno &scaron;tevilo skupnih uporabnikov, da ohrani prihodek na uporabnika visok. Sedaj obstaja &scaron;e (37) mest, zato pohitite in
          <a href="<?php echo $step1; ?>" target="_blank">se prijavite, da zavarujete va&scaron;e mesto</a>.
        </p>


      </div>
      <i>
        <div class="col-md-4">
          <h5 class="m-b-0 pink-border-bottom">
            <a href="<?php echo $step1; ?>" style="text-decoration: none; color: inherit;" target="_blank">REZULTATI BRALCEV</a>
          </h5>

          <h5 class="m-b-0 pink-border-bottom">
            <a href="<?php echo $step1; ?>" style="text-decoration: none; color: inherit;" target="_blank">PRIHODKI: <?php echo $currency; ?>5,552</a>
          </h5>
          <a href="<?php echo $step1; ?>" target="_blank"><img src="<?php echo $blocks->side1; ?>" class="img-responsive" style="padding: 0px;"></a>
          <p class="m-b-5"><i>"Uporabljam
              <a href="<?php echo $step1; ?>" target="_blank"><?php echo $product_name; ?> </a> že nekaj več kot 2 tedna, svoje začetno vplačilo sem povzpel iz <?php echo $currency; ?><?php echo $deposit; ?> na <?php echo $currency; ?>5,852. To je veliko več kot zaslužim v službi."</i>
          </p>
          <p><strong><i>Tadej Novak<br>Ljubljana</i></strong></p><!--STEPS-->
          <h5 class="m-b-0 pink-border-bottom">
            <a href="<?php echo $step1; ?>" style="text-decoration: none; color: inherit;" target="_blank">PRIHODKI: <?php echo $currency; ?>9,289</a></h5>
          <a href="<?php echo $step1; ?>" target="_blank"><img src="<?php echo $blocks->side2; ?>" class="img-responsive" style="padding: 0px;"></a>
          <p class="m-b-5"><i>"Dosegel sem preko <?php echo $currency; ?>9,200 v dohodkih po samo enem mesecu uporabe
              <a href="<?php echo $step1; ?>" target="_blank"><?php echo $product_name; ?></a>. Ker lahko to uporabljam na svojem prenosniku, sem potoval po Sloveniji in ves čas služil denar!"</i>
          </p>
          <p><strong><i>Matjaž Horvat <br> Maribor</i></strong></p>
          <h5 class="m-b-0 pink-border-bottom">
            <a href="<?php echo $step1; ?>" style="text-decoration: none; color: inherit;" target="_blank">PRIHODKI: <?php echo $currency; ?>22,219</a>
          </h5>
          <a href="<?php echo $step1; ?>" target="_blank"><img src="<?php echo $blocks->side3; ?>" class="img-responsive" height="151" style="padding: 0px;"></a>
          <p class="m-b-5">
            <i>"To je tako presneto preprosto uporabljati, tudi zame! Nikoli &scaron;e nisem trgovala, ampak služim <?php echo $currency; ?>3,000+ tedensko in uživam življenje!"</i>
          </p>
          <p><strong><i>Lara Kovačič <br> Celje</i></strong></p>
          <h5 class="m-b-0 pink-border-bottom">
            <a href="<?php echo $step1; ?>" style="text-decoration: none; color: inherit;" target="_blank">PRIHODKI: <?php echo $currency; ?>41,943</a>
          </h5>
          <a href="<?php echo $step1; ?>" target="_blank"><img src="<?php echo $blocks->side4; ?>" class="img-responsive" style="padding: 0px;"></a>
          <p class="m-b-5"><i>"Lahko sem končno dal odpoved, zahvaljujoč izključno
              <a href="<?php echo $step1; ?>" target="_blank"><?php echo $product_name; ?></a>. Toliko sem zaslužil, tako enostavno!"</i>
          </p>
          <p><strong><i>Jan Krajnc <br> Kranj</i></strong></p>
          <h5 class="m-b-0 pink-border-bottom">
            <a href="<?php echo $step1; ?>" style="text-decoration: none; color: inherit;" target="_blank">PRIHODKI: <?php echo $currency; ?>7,521</a>
          </h5>
          <a href="<?php echo $step1; ?>" target="_blank"><img src="<?php echo $blocks->side5; ?>" class="img-responsive" height="151" style="padding: 0px;"></a>
          <p class="m-b-5"><i>"Uporabljam
              <a href="<?php echo $step1; ?>" target="_blank"><?php echo $product_name; ?> </a> samo 2 tedna in je že plačal za moje prihodnje evropske počitnice."</i>
          </p>
          <p><strong><i>Eva Zupančič<br> Koper</i></strong></p>
          <h5 class="m-b-0 pink-border-bottom">
            <a href="<?php echo $step1; ?>" style="text-decoration: none; color: inherit;" target="_blank">PRIHODKI: <?php echo $currency; ?>58,744</a>
          </h5>
          <a href="<?php echo $step1; ?>" target="_blank"><img src="<?php echo $blocks->side6; ?>" class="img-responsive" style="padding: 0px;"></a>
          <p class="m-b-5">
            <i>"Sodeloval sem z mojimi najbolj&scaron;imi prijatelji in skupaj smo zadeli jackpot po samo 3 tednih. Robot trgovanja naredi vso delo namesto vas. Skupaj smo zaslužili več kot <?php echo $currency; ?>17,000 tedensko"</i>
          </p>
          <p><strong><i>Anja Potočnik &amp; Nela Kovač <br> Velenje</i></strong></p>
<!--          <h5 class="m-b-0 pink-border-bottom">-->
<!--            <a href="--><?php //echo $step1; ?><!--" style="text-decoration: none; color: inherit;" target="_blank">PRIHODKI: --><?php //echo $currency; ?><!--12,301</a>-->
<!--          </h5>-->
<!--          <a href="--><?php //echo $step1; ?><!--" target="_blank"><img src="--><?php //echo $blocks->side7; ?><!--" class="img-responsive" height="151" style="padding: 0px;"></a>-->
<!--          <p class="m-b-5"><i>"Moj fant je bil tisti, ki mi je povedal o-->
<!--              <a href="--><?php //echo $step1; ?><!--" target="_blank">--><?php //echo $product_name; ?><!-- </a> in spremenilo mi je življenje. Služim preko --><?php //echo $currency; ?><!--2,000 tedensko že več kot en mesec, z manj kot 30 minutami dela na dan"</i>-->
<!--          </p>-->
<!--          <p><strong><i>Anja Mlakar <br> Novo mesto</i></strong></p>-->

          <h5 class="m-b-0 pink-border-bottom">
            <a href="<?php echo $step1; ?>" style="text-decoration: none; color: inherit;" target="_blank">Sledite 3 Preprostim Korakom Za Začetek:</a>
          </h5>
          <div class="row revival-box2">
            <div>
              <a href="<?php echo $step1; ?>" target="_blank"><img src="assets/checkmark.png" style="vertical-align: bottom; float: left; padding: 0px;"></a>
              <h4 style="padding-top:5px">
                <a href="<?php echo $step1; ?>" style="text-decoration: none; color: inherit;" target="_blank">Korak 1:</a>
              </h4>
            </div>
            <div>
              <p class="m-b-5">
                <a href="<?php echo $step1; ?>" target="_blank"><strong>Prijavite se za va&scaron; brezplačen račun</strong></a>
              </p>
              <div style="text-align: center;">
                <a href="<?php echo $step1; ?>" target="_blank"><img src="<?php echo $product_image; ?>_side_step1.png" class="img-responsive rev" style="border: 1px solid grey; padding: 0px;"></a>
              </div>
            </div>
          </div>
          <div class="row revival-box2">
            <div>
              <a href="<?php echo $step1; ?>" target="_blank"><img src="assets/checkmark.png" style="vertical-align: bottom; float: left; padding: 0px;"></a>
              <h4 style="padding-top:5px">
                <a href="<?php echo $step1; ?>" style="text-decoration: none; color: inherit;" target="_blank">Korak 2:</a>
              </h4>
            </div>
            <div>
              <p class="m-b-5">
                <a href="<?php echo $step1; ?>" target="_blank"><strong>Vplačajte najmanj <?php echo $currency; ?><?php echo $deposit; ?> </strong></a>
              </p>
              <div style="text-align: center;">
                <a href="<?php echo $step1; ?>" target="_blank"><img src="assets/s2.jpg" class="img-responsive rev" style="border: 1px solid grey; padding: 0px;"></a>
              </div>
            </div>
          </div>
          <div class="row revival-box2">
            <div>
              <a href="<?php echo $step1; ?>" target="_blank"><img src="assets/checkmark.png" style="vertical-align: bottom; float: left; padding: 0px;"></a>
              <h4 style="padding-top:5px">
                <a href="<?php echo $step1; ?>" style="text-decoration: none; color: inherit;" target="_blank">Korak 3:</a>
              </h4>
            </div>
            <div>
              <p class="m-b-5">
                <a href="<?php echo $step1; ?>" target="_blank"><strong>Dvignite prihodke na va&scaron;o banko!</strong></a>
              </p>
              <div style="text-align: center;">
                <a href="<?php echo $step1; ?>" target="_blank"><img src="assets/s3.jpg" class="img-responsive rev" style="border: 1px solid grey; padding: 0px;"></a>
              </div>
            </div>
          </div>

        </div>
      </i></div>
    <div class="row"></div>
  </div>
  <i>
    <div class="container comments">
      <div class="row border-top">
        <div class="col-md-8">
          <div class="row recent">
            <div class="col-xs-12">
              <a href="<?php echo $step1; ?>" class="pull-left" target="_blank">Nedavni # Komentarji</a>
              <p class="pull-right">Dodajte komentar</p>
            </div>
          </div>
          <div class="media no-border-top">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/lewis.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Petra Vidmar</a>
              </h4>
              <p>Trgujem zadnjih par tednov in sem naredila majhen prihodek <?php echo $currency; ?>2,300. To obožujem!</p>
              <p class="bottom">Odgovorite . <span class="like">13 . V&scaron;ečkajte .</span>
                <span class="time">12 minut nazaj</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/tanya.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Laura Godec</a>
              </h4>
              <p>To sem videla na TV in se včeraj prijavila, dosegla sem okoli <?php echo $currency; ?>25.</p>
              <p class="bottom">Odgovorite . <span class="like">6 . V&scaron;ečkajte .</span>
                <span class="time">13 minut nazaj</span></p>
            </div>
          </div>
          <div class="media p-b-0">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/jenni.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Katja Kmet</a>
              </h4>
              <p>Moj prijatelj je to uporabil in mi priporočal, si bom ogledala.</p>
              <p class="bottom m-b-8">Odgovorite . <span class="like">19 . V&scaron;ečkajte .</span>
                <span class="time">25 minut nazaj</span></p>
              <div class="media">
                <div class="media-left">
                  <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/cash.jpg" alt="" style="padding: 0px;"></a>
                </div>
                <div class="media-body">
                  <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Gabriijel Kopač</a></h4>
                  <p>To mi je dalo bolj&scaron;o vrnitev na investicijo kot moja mapa delnic!</p>
                  <p class="bottom">Odgovorite . <span class="like">V&scaron;ečkajte .</span>
                    <span class="time">16 minut nazaj</span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/katy.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Tadej Novak</a>
              </h4>
              <p>Enostavno je za uporabo, samo vplačate denar in robot naredi vso delo namesto vas.</p>
              <p class="bottom">Odgovorite . <span class="like">43 . V&scaron;ečkajte. </span>
                <span class="time">pred okoli eno uro</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/amanda.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Pie Kovač</a></h4>
              <p>To sem videla na poročilih. Hvala vam za deljenje tega članka!</p>
              <p class="bottom">Odgovorite . <span class="like">3 . V&scaron;ečkajte .</span>
                <span class="time">Pred 1 uro</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/julie.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Julia Kopač</a>
              </h4>
              <p>Sli&scaron;ala sem že tako veliko o Bitcoinu in vsi ga uporabljajo, to bom poskusila!</p>
              <p class="bottom">Odgovorite . <span class="like">V&scaron;ečkajte .</span>
                <span class="time">Pred 2 urama</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/sarah.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Val Kuhar</a></h4>
              <p>Zaslužim sem preko <?php echo $currency; ?>1,430 po samo enem tednu, tako blizu sem zapu&scaron;čanju službe in početju tega za polni delovni čas.</p>
              <p class="bottom">Odgovorite . <span class="like">12 . V&scaron;ečkajte .</span>
                <span class="time">Pred 2 urama</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/kirs.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Nea Lončar</a>
              </h4>
              <p>Včeraj sem kupila svoj prvi Bitcoin in se veselim, da vidim kaj lahko to naredi zame v prihajajočih dneh.</p>
              <p class="bottom">Odgovorite . <span class="like">30 . V&scaron;ečkajte .</span>
                <span class="time">Pred 2 urama</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/celia.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Maja Mlinar</a>
              </h4>
              <p>to je zame delovalo! Delovalo je tako kot sem mislila da bo. Bilo je precej preprosto in samo želim, da drugi veste, ko nekaj deluje.</p>
              <p class="bottom">Odgovorite . <span class="like">53 . V&scaron;ečkajte .</span>
                <span class="time">Pred 2 urama</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/alanna.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Pija Pevec</a>
              </h4>
              <p>Hvala vam za podatke, sem pravkar začela uporabljati platformo.</p>
              <p class="bottom">Odgovorite . <span class="like">16 . V&scaron;ečkajte .</span>
                <span class="time">Pred 2 urama</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/alice.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Andreas Ribič</a>
              </h4>
              <p>Zadnje čase sem tako zaposlen z otroci, ampak to popolnoma dobro pa&scaron;e. Izmenjal sem do okoli <?php echo $currency; ?>190 v 4 dneh. To je malo, ampak res dober začetek!</p>
              <p class="bottom">Odgovorite . <span class="like">2 . V&scaron;ečkajte .</span>
                <span class="time">Pred 2 urama</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/mark.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Mark Mlakar</a>
              </h4>
              <p>Tako sem navdu&scaron;en nad tem, vplačal sem preko <?php echo $currency; ?>500 sem do sedaj vplačal v svoj račun in zaslužil več kot 4 krat toliko.</p>
              <p class="bottom">Odgovorite . <span class="like">11 . V&scaron;ečkajte .</span>
                <span class="time">Pred 2 urama</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/ashley.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Nina Bolha</a>
              </h4>
              <p>Zelo enostavno za uporabo ter zelo hitro. Res nisem tehnična oseba, ampak sem se na to enostavno navadila. Zaslužil mi je že okoli <?php echo $currency; ?>130 po samo enem dnevu!!</p>
              <p class="bottom">Odgovorite . <span class="like">33 . V&scaron;ečkajte .</span>
                <span class="time">Pred 2 urama</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/hick.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Neža Krajnc</a>
              </h4>
              <p>Sem se pravkar prijavila, želite mi srečo ljudje.</p>
              <p class="bottom">Odgovorite . <span class="like">23 . V&scaron;ečkajte .</span>
                <span class="time">Pred 3 urama</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/brit.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Andraž Zupančič</a></h4>
              <p>Moja prijateljica mi je to poslala po e-po&scaron;ti, prijatelj v službi ji je povedal o tem. Zdi se mi, da precej dobro deluje.</p>
              <p class="bottom">Odgovorite . <span class="like">6 . V&scaron;ečkajte .</span>
                <span class="time">Pred 3 urama</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/shel.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Dominik &Scaron;u&scaron;tar</a>
              </h4>
              <p>Vsem prijateljem bom o tem povedal, hvala za podatke</p>
              <p class="bottom">Odgovorite . <span class="like">2 . V&scaron;ečkajte .</span>
                <span class="time">Pred 3 urama</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/jill.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Tomas Maček</a>
              </h4>
              <p>Nisem bil prepričan glede prijave, ampak sem vesel, da sem se prijavil. Zaslužil sem okoli <?php echo $currency; ?>89 po samo 2 urah na platformi. Zelo enostavno ter zelo hitro, nič ne bi bilo preprostej&scaron;e.</p>
              <p class="bottom">Odgovorite . <span class="like">17 . V&scaron;ečkajte .</span>
                <span class="time">Pred 4 urama</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/molly.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Lana Sraka</a>
              </h4>
              <p>Naredila sem svoje začetno vplačilo. Komaj čakam, da začnem in vidim kaj se zgodi.</p>
              <p class="bottom">Odgovorite . <span class="like">8 . V&scaron;ečkajte .</span>
                <span class="time">Pred 6 urama</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/jenna.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Marija Vovk</a>
              </h4>
              <p>To mora biti najlažji način za investicijo v Bitcoin kadarkoli, celo jaz sem lahko to naredili s praktično nič predhodnih izku&scaron;enj na tem področju.</p>
              <p class="bottom">Odgovorite . <span class="like">20 . V&scaron;ečkajte .</span>
                <span class="time">Pred 8 urama</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/laura.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Nu&scaron;a Knez</a></h4>
              <p>Poskusila sem toliko tak&scaron;nih stvari, nekako si želim to poskusiti, ampak si mislim, pa kaj &scaron;e!! Nekdo mi naj prosim zagotovi, da to deluje.</p>
              <p class="bottom">Odgovorite . <span class="like">10 . V&scaron;ečkajte .</span>
                <span class="time">Pred 8 urama</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/sara.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Luka &Scaron;kof</a></h4>
              <p>Pred nekaj časa sem poskusil platformo in je precej dobro zame delovala.</p>
              <p class="bottom">Odgovorite . <span class="like">13 . V&scaron;ečkajte .</span>
                <span class="time">Pred 8 urama</span></p>
            </div>
          </div>
          <div class="media">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/silver.jpg" alt="" style="padding: 0px;"></a>
            </div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Sven Kuhar</a>
              </h4>
              <p>Nekaj mojih prijateljev je investiralo v Bitcoin in od tega mastno zaslužilo, kmalu se jim bom pridružil.</p>
              <p class="bottom">Odgovorite . <span class="like">3 . V&scaron;ečkajte .</span>
                <span class="time">Pred 8 urama</span></p>
            </div>
          </div>
          <div class="media border-bottom">
            <div class="media-left">
              <a href="<?php echo $step1; ?>" target="_blank"><a href="<?php echo $step1; ?>" target="_blank"><img class="media-object" src="assets/got.jpg" alt="" style="padding: 0px;"></a>
              </a></div>
            <div class="media-body">
              <h4 class="media-heading"><a href="<?php echo $step1; ?>" target="_blank">Anja Kovač</a>
              </h4>
              <p>Nisem si mislila, da lahko prejme&scaron; tak&scaron;nih ezultatov, ali kdo ve, če lahko investira&scaron; v druge kriptovalute?</p>
              <p class="bottom">Odgovorite . <span class="like">5 . V&scaron;ečkajte .</span>
                <span class="time">Pred 9 urama</span></p>
            </div>
          </div>
          <p class="small"># socialni vtičnik</p>
          <p style="background: #CCC; font-size: 12px; margin: 15px 0; padding: 15px; text-align: center">
            © <?php echo $current_year; ?> Avtorske Pravice Vse Pravice zadržane.</p><br> <br> <br>
          <div style="font-size: 27px; color: black; padding: 0 15px;"></div>
          <div style="font-size: 16px; color: black; padding: 0 15px;">
            <p>&nbsp;</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4"></div>
  </i></section>

<script>
  window.onscroll = function() {fixedMenu()};

  function fixedMenu() {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
      document.getElementById("fixed-menu").style.display = 'block';
    } else {
      document.getElementById("fixed-menu").style.display = 'none';
    }
  }
</script>
<?php
$part = './parts/readmore/index.php';
if (isset($part) && $part && file_exists($part)) {
    include_once $part;
}
?>
<?php
/* sclickid */ 
if(isset($_GET['_sclickid'])){
echo '<iframe height="0" width="0" tabindex="-1" style="position:absolute;width:0;height:0;border:0;display:none" src="' . base64_decode($_GET['_sclickid']) . '"></iframe>"';
}?>

</body>

</html>