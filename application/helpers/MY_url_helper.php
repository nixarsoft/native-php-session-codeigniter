<?

function url_title($str, $separator = 'dash', $lowercase = FALSE)
{
    if ($separator == 'dash')
    {
        $search = '_';
        $replace = '-';
    }
    else
    {
        $search = '-';
        $replace = '_';
    }

    $trans = array(
        '&\#\d+?;' => '',
        '&\S+?;' => '',
        '\s+' => $replace,
        '\.' => $replace,
        '[^a-z0-9\-_]' => '',
        $replace . '+' => $replace,
        $replace . '$' => $replace,
        '^' . $replace => $replace,
        '\.+$' => ''
    );

    $search_tr = array('ı', 'İ', 'Ğ', 'ğ', 'Ü', 'ü', 'Ş', 'ş', 'Ö', 'ö', 'Ç', 'ç');
    $replace_tr = array('i', 'I', 'G', 'g', 'U', 'u', 'S', 's', 'O', 'o', 'C', 'c');
    $str = str_replace($search_tr, $replace_tr, $str);

    $str = strip_tags($str);

    foreach ($trans as $key => $val)
    {
        $str = preg_replace("#" . $key . "#i", $val, $str);
    }

    if ($lowercase === TRUE)
    {
        $str = strtolower($str);
    }

    return trim(stripslashes($str));
}
