<?php

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
                    $hero_name = ucwords(str_replace('_', ' ', $e));
                    $hero_name = convertToLatin($hero_name);
                    $heroes[] = $hero_name;
                }
            }
            closedir($dh);
        }
    }
    if (isset($_GET['a'])) {
        $a = ucwords(str_replace('_', ' ', htmlspecialchars($_GET['a'])));
        $a = convertToLatin($a);
        if (in_array($a, $heroes)) {
            $heroes = array($a);
        }
    }
    return $heroes;
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

function productNames()
{
    $product_names = [];
    $dir = realpath(getcwd() . '/' . productDir());
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($e = readdir($dh)) !== false) {
                if (($e == ".") || ($e == "..")) {
                    continue;
                }
                if ($last_dot_position = strrpos($e, '.')) {
                    $base_name = substr($e, 0, $last_dot_position);
                    $check_string = '_popup';
                    $check_string_length = strlen($check_string);
                    if ($check_string_length && $check_string === substr($base_name, -$check_string_length)) {
                        $product_name = ucwords(str_replace('_', ' ', substr($base_name, 0, -$check_string_length)));
                        $product_names[] = $product_name;
                    }
                }
            }
            closedir($dh);
        }
    }
    if (isset($_GET['p'])) {
        $p = ucwords(str_replace('_', ' ', htmlspecialchars($_GET['p'])));
        if (in_array($p, $product_names)) {
            $product_names = array($p);
        }
    }
    return $product_names;
}

function convertToLatin($string)
{
    if (strpos($string = htmlentities($string, ENT_QUOTES, 'UTF-8'), '&') !== false) {
        $string = html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|tilde|uml);~i', '$1', $string), ENT_QUOTES, 'UTF-8');
    }
    return $string;
}

if ($heroes = getHeroes()) {
    if (!isset($_GET['a'])) {
        foreach ($heroes as $hero) {
            $link = 'http://' . $_SERVER['SERVER_NAME']. substr($_SERVER['REQUEST_URI'], 0, (strpos($_SERVER['REQUEST_URI'], '?') ?: strlen($_SERVER['REQUEST_URI'])))
                . '?a=' . str_replace(' ', '_', $hero);
            if (isset($_GET['qa'])) {
                $link .= '&qa';
            }
            echo '<a href="' . $link . '">' . $link . '</a><br>';
        }
    } elseif ($product_names = productNames()) {
        $links = '';
        foreach ($heroes as $hero) {
            foreach ($product_names as $product_name) {
                $link = 'http://' . $_SERVER['SERVER_NAME']. substr($_SERVER['REQUEST_URI'], 0, 1 + strrpos($_SERVER['REQUEST_URI'], '/'))
                    . '?a=' . str_replace(' ', '_', $hero)
                    . '&p=' . str_replace(' ', '_', $product_name);
                echo '<a href="' . $link . '" target="_blank">' . $link . '</a><br>';
                $links .= $link .PHP_EOL;
            }
        }
        if (isset($_GET['qa'])) {
            $link = 'http://' . $_SERVER['SERVER_NAME']. '/checker/index.php?urls=' . urlencode($links);
            echo '<br><a href="' . $link . '" target="_blank">http://' . $_SERVER['SERVER_NAME']. '/checker/</a><br>';
        }
    }
}



