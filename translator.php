<?php 

  ## Simple CSRF token check. Uses the POST method for user changes. Pure backend.

    if (!isset($_SESSION['pcstLV'])) {
        $_SESSION['pcstLV'] = bin2hex(random_bytes(32));
    }
    
    /*if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['language'])) {
        $csrf_tokenLV = $_POST['pcstvalueLV'] ?? '';
        if (empty($_SESSION['pcstLV']) || empty($csrf_tokenLV) || !hash_equals($_SESSION['pcstLV'], $csrf_tokenLV)) {
            $_SESSION['pcstLV'] = bin2hex(random_bytes(32));
            die('Invalid CSRF-Token.');
        }
        $languages = ['de', 'en', 'fr', 'tr', 'da', 'cz', 'pl', 'ua', 'ru', 'nl'];
        if (in_array($_POST['language'], $languages, true)) {
            $_SESSION['userLanguage'] = $_POST['language'];
        }
        header("Location: " . $_SERVER['REQUEST_URI']);
    }*/

    class Translator
    {
        private $translations = [];
        private $language = 'en';

        public function __construct($language = 'en')
        {
            $file = 'translation.json';
            if (file_exists($file)) {
                $this->translations = json_decode(file_get_contents($file), true);
            }
            $this->setLanguage($language);
        }

        public function setLanguage($language)
        {
            if (isset($this->translations[$language])) {
                $this->language = $language;
            } else {
                error_log("Language '$language' not found, falling back to 'en'.");
                $this->language = 'en';
            }
        }

        public function translate($key)
        {
            return $this->translations[$this->language][$key] 
            ?? $this->translations['en'][$key] 
            ?? "[$key]";
        }
    }

    if(!isset($_SESSION['userLanguage'])){
        $userLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        $_SESSION['userLanguage'] = ($userLang === 'de') ? 'de' : 'en';
    }
    $userLang = $_SESSION['userLanguage'];

    try {
        $translator = new Translator($userLang);
    } catch (Exception $e) {
        error_log($e->getMessage()); 
        $translator = new Translator('en');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        echo $translator->translate('welcome');
    ?>
</body>
</html>
