# PHP-JSON Translator – A Simple Multi-Language Solution

This PHP Translator allows you to easily implement multi-language support in your web projects using JSON-based translation files. 
It automatically detects the user's preferred language and provides CSRF protection for language changes.

Requirements: PHP Sessions 

## How It Works:

1. The user's preferred language is detected via HTTP_ACCEPT_LANGUAGE.
2. If no language is set, it defaults to English (en).
3. Translations are stored in a translation.json file.
4. A CSRF token is generated to prevent unauthorized language changes.
5. The Translator class fetches the correct translation based on the user's selected language.



## Example form for the language settings and the CSFR-Token:

```html
<form method="POST">
     <input type="hidden" name="pcstvalueLV" value="<?php echo $_SESSION['pcstLV']; ?>">
    <select name="language">
        <option value="en">English</option>
        <option value="de">Deutsch</option>
    </select>
    <button type="submit">Change Language</button>
</form>
```

## Possible changes and extensions

-> Add more languages by updating translation.json.
-> Implement AJAX for smoother language switching.
-> Store user preferences in a database instead of $_SESSION.
