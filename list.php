<?php

define('ROOT_DIR', __DIR__);

function escape($str)
{
    return htmlspecialchars($str, ENT_COMPAT, 'UTF-8', false);
}

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Auto-blogs</title>
    <style type="text/css" media="screen,projection">
    * { margin: 0; padding: 0; }
    body { font-family:"Trebuchet MS",Verdana,Arial,Helvetica,sans-serif; background-color: #3E4B50; padding: 1%; color: #000; }
    .header h1 { text-shadow: 2px 2px 2px #000; }
    .header h1 a { text-decoration: none; color: #eee; }
    .header { padding: 1% 3%; color: #eee; margin: 0 10%; border-bottom: 1px solid #aaa; background: #6A6A6A; }
    .header p a { color: #bbb; }
    .header p a:hover { color:#FFFFC9; text-decoration:none;}
    .article .title h2 { margin: 0; color:#666; text-shadow: 1px 1px 1px #fff; }
    .article .title h2 a { color:#666; text-decoration:none; }
    .article .title h2 a:hover { color:#403976; }
    .article { margin: 0 10%; padding: 1% 2%; background: #ccc; border-bottom: 1px solid #888; }
    .article h4 { font-weight: normal; font-size: small; color: #666; }
    .article .title { margin-bottom: 1em; }
    .footer { text-align:center; font-size: x-small; color:#aaa; clear: both; }
    .footer a { color:#ccc; }
    .footer a:hover { color:#FFFFC9; }
    .content ul { margin: 1em 2em; }
    </style>
</head>
<body>

<div class="header">
    <h1>Auto-blogs</h1>
    <p>Using VroumVroumBlog</p>
</div>
';

$dir = dir(ROOT_DIR);

while ($file = $dir->read())
{
    if ($file[0] == '.')
        continue;

    if (is_dir(ROOT_DIR . '/' . $file)
        && file_exists(ROOT_DIR . '/' . $file . '/vvb.ini'))
    {
        $ini = parse_ini_file(ROOT_DIR . '/' . $file . '/vvb.ini');
        $config = new stdClass;

        foreach ($ini as $key=>$value)
        {
            $key = strtolower($key);
            $config->$key = $value;
        }

        unset($ini);

        echo '
        <div class="article">
            <div class="title">
                <h2><a href="'.escape($file).'/">'.escape($config->site_title).'</a></h2>
                <h4>From <a href="'.escape($config->site_url).'">'.escape($config->site_url).'</a></h4>
            </div>
            <div class="content">
                <ul>
                    <li><a href="'.escape($file).'/">Autoblog</a></li>
                    <li><a href="'.escape($file).'/vvb.ini">Configuration</a></li>
                </ul>
            </div>
        </div>';
    }
}

$dir->close();

echo '
<div class="footer">
    Download <a href="https://github.com/bugsysop/autoblot">Source Code</a>
</div>
</body>
</html>';

?>