<?php
$is_twitter_required = isset($_GET['twitter']) && $_GET['twitter'] === 'on';

if ($is_twitter_required) {

    $product_name = isset($product_name) ? $product_name : 'Brand Name';
    $brand_hash = '#' . str_replace(' ', '', $product_name);
    $hero = isset($hero) ? $hero : 'Hero Name';
    $twitter_name = isset($twitter_name) ? $twitter_name : $hero;
    $hero_nickname = isset($hero_nickname) ? $hero_nickname : '@' . str_replace(' ', '', $hero);
    $lang = (isset($lang)) ? $lang : 'en';
    $twitter_avatar_dir = (isset($article_dir)) ? $article_dir . '/images/' : 'assets/images/twitter_images/';

    $twitter = array(
        //English
        'en' => "While I have expressed doubts about Bitcoin in the past, the $product_name system is showing great promise and has my full endorsement as a wealth system.",

        //Swedish
        'sv' => "Även om jag har uttryckt tvivel om Bitcoin tidigare, så uppvisar $product_name-systemet stora löften och har mitt fulla stöd som ett förmögenhetssystem.",

        //Danish
        'da' => "Selv om jeg tidligere har givet udtryk for mine tvivl angående Bitcoin, ser $product_name-systemet meget lovende ud og har min fulde tilslutning som et system til at opnå velstand.",
        //Danish (wrong 2 letter code, but don't touch it)
        'dk' => "Selv om jeg tidligere har givet udtryk for mine tvivl angående Bitcoin, ser $product_name-systemet meget lovende ud og har min fulde tilslutning som et system til at opnå velstand.",

        //Turkish
        'tk' => "Bitcoin hakkında geçmişte kuşkularımı belirttiysem de $product_name büyük bir potansiyel içeriyor ve varlık sistemi olarak tam desteğime sahip.",

        //French
        'fr' => "Pendant que j'aie exprimé des doutes sur Bitcoin autrefois, le système de $product_name est très prometteur et à mon plein appui en tant que système de richesse.",

        //Spanish
        'es' => "Aunque expresé mis dudas sobre el bitcóin en el pasado, el sistema $product_name parece muy prometedor y tiene todo mi respaldo como sistema para hacerse rico.",

        //German
        'de' => "Obwohl ich in der Vergangenheit Zweifel an Bitcoin geäußert habe, erscheint das $product_name-System sehr vielversprechend und hat meine volle Unterstützung als System zur Vermögensbildung.",

        //Italian
        'it' => "Anche se in passato ho espresso i miei dubbi su Bitcoin, il sistema $product_name promette con una grande prospectiva. Attualmente ha la mia piena approvazione come un nuovo sistema di ricchezza.",

        //Dutch
        'nl' => "Hoewel ik in het verleden mijn twijfels over Bitcoin uitte, vind ik dat het $product_name-systeem zeer veelbelovend is en onderschrijf ik het volledig als een welvaartssysteem.",

        //Greek
        'gr' => "Aν και έχω εκφράσει αμφιβολίες για το Bitcoin στο παρελθόν, το σύστημα $product_name υπόσχεται πολλά και έχει την πλήρη έγκρισή μου ως σύστημα πλουτισμού.",
    );

    $twitter_text = isset($twitter[$twitter_lang]) ? $twitter[$twitter_lang] : $twitter['en'];

?>

<style>
    .twitter_block_wrap,
    .twitter_block_wrap:hover {
        text-decoration: none;
        outline: none;
    }

    .twitter_block_wrap {
        margin: 20px 0;
        display: block;
        font-family: "Arial", sans-serif !important;
        font-size: 16px;
        line-height: 1.5;
        width: 100%;
    }

    .twitter_block {
        border: 1px solid #EBEEF0;
        padding: 15px;
        display: flex;
        flex-wrap: wrap;
        background-color: #fff;
    }

    .twitter_block__header {
        width: 100%;
        padding: 0 0 0 30px;
        display: flex;
        align-items: center;
        font-size: 13px;
        font-weight: bold;
        color: #5b7083;
        margin-bottom: 10px;
    }

    .twitter_block__header img {
        height: 16px;
        margin-right: 10px;
    }

    .twitter_block__avatar {
        width: 50px;
        margin-right: 15px;
    }

    .twitter_block__avatar img {
        width: 100%;
        border-radius: 50%;
    }

    .twitter_block__body {
        width: calc(100% - 65px);
    }

    .twitter_body__header {
        display: flex;
        align-items: center;
    }

    .twitter_character_name {
        font-size: 15px;
        color: #000;
        font-weight: bold;
        margin-right: 5px;
    }

    .account_verif_img {
        width: 16px;
        display: block;
        margin-right: 5px;
    }

    .twitter_character_nickname {
        font-size: 15px;
        color: #5b7083;
    }

    .twitter_block_more_btn {
        margin-left: auto;
        width: 18px;
        display: block;
    }

    .twitter_body__text {
        margin-top: 5px;
        color: #000;
        font-size: 15px;
    }

    .twitter_body__hashtag {
        color: #1b95e0;
    }

    .twitter_block__footer {
        display: flex;
        align-items: center;
        margin: 10px 0 0 65px;
    }

    .twitter_block_footer__item {
        color: #5b7083;
        font-size: 13px;
        display: flex;
        align-items: center;
        margin-right: 50px;
    }

    .twitter_block_footer__item img {
        width: 18px;
        margin-right: 10px;
    }

    @media(max-width: 550px) {
        .twitter_block_footer__item {
            margin-right: 30px;
        }
    }

    @media(max-width: 450px) {
        .twitter_block_footer__item {
            margin-right: 15px;
        }

        .twitter_block_footer__item img {
            margin-right: 5px;
        }

        .twitter_character_name {
            order: 1;
            font-size: 14px;
        }

        .account_verif_img {
            order: 2;
        }

        .twitter_character_nickname {
            order: 4;
            width: 100%;
            font-size: 14px;
            word-break: break-all;
        }

        .twitter_block_more_btn {
            order: 3;
        }

        .twitter_body__header {
            flex-wrap: wrap;
        }

        .twitter_block {
            padding: 10px;
        }
    }
</style>

<a href="<?php echo $step1?>" class="twitter_block_wrap" target="_blank">
    <div class="twitter_block">
        <div class="twitter_block__header">
            <img src="./parts/twitter/images/thumbtack.svg" alt="">
            <span>Pinned Tweet</span>
        </div>
        <div class="twitter_block__avatar">
            <img src="<?php echo $twitter_avatar_dir; ?>twitter_avatar.jpg" alt="">
        </div>
        <div class="twitter_block__body">
            <div class="twitter_body__header">
                <span class="twitter_character_name">
                    <?php echo $twitter_name; ?>
                </span>
                <img src="./parts/twitter/images/verified_account.svg" class="account_verif_img" alt="">
                <span class="twitter_character_nickname">
                    <?php echo $hero_nickname; ?>
                </span>
                <img src="./parts/twitter/images/dots.svg" class="twitter_block_more_btn" alt="">
            </div>
            <div class="twitter_body__text">
                <span class="twitter_body__hashtag">
                    <?php echo $brand_hash; ?>
                </span>
                <?php echo $twitter_text; ?>
            </div>
        </div>
        <div class="twitter_block__footer">
            <div class="twitter_block_footer__item">
                <img src="./parts/twitter/images/comment.svg" alt="">
                <span>82</span>
            </div>
            <div class="twitter_block_footer__item">
                <img src="./parts/twitter/images/retweet.svg" alt="">
                <span>140</span>
            </div>
            <div class="twitter_block_footer__item">
                <img src="./parts/twitter/images/heart.svg" alt="">
                <span>617</span>
            </div>
            <div class="twitter_block_footer__item">
                <img src="./parts/twitter/images/share.svg" alt="">
            </div>
        </div>
    </div>
</a>

<?php 
}
