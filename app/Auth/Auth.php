<?php

namespace App\Auth;

use App\Models\User;
use App\Models\Sessions;
use App\Models\UserLogs;

class Auth
{

    public function user()
    {
        if (isset($_COOKIE["user"]))
            return User::find($_COOKIE["user"]);
    }

    public function check()
    {
        if (isset($_COOKIE["user"]))
            return $_COOKIE["user"];
    }


    public function attempt($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->password)) {
            setcookie("user", $user->id, time() + 604800, "/");
            $this->user_log($user->id);
            return true;
        }

        return false;
    }


    public function logout()
    {
        setcookie("user", "", time() - 3600, "/");
    }

    public function user_log($id)
    {
        $browser = $this->get_browser_name();

        $ip = $this->get_user_ip();

        $device_type = $this->get_device_type();


        $session = Sessions::create([
            'user_id'       => $id,
            'user_ip'       => $ip,
            'device_type'   => $device_type,
            'browser'       => $browser
        ]);


        UserLogs::create([
            'user_id'           => $id,
            'session_id'       =>  $session->id,
            'created_at'        => date("Y-m-d H:i:s"),
        ]);
    }

    public function get_browser_name()
    {

        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        // Make case insensitive.
        $t = strtolower($user_agent);

        // If the string *starts* with the string, strpos returns 0 (i.e., FALSE). Do a ghetto hack and start with a space.
        // "[strpos()] may return Boolean FALSE, but may also return a non-Boolean value which evaluates to FALSE."
        //     http://php.net/manual/en/function.strpos.php
        $t = " " . $t;

        // Humans / Regular Users     
        if (strpos($t, 'opera') || strpos($t, 'opr/')) return 'Opera';
        elseif (strpos($t, 'edge')) return 'Edge';
        elseif (strpos($t, 'chrome')) return 'Chrome';
        elseif (strpos($t, 'safari')) return 'Safari';
        elseif (strpos($t, 'firefox')) return 'Firefox';
        elseif (strpos($t, 'msie') || strpos($t, 'trident/7')) return 'Internet Explorer';

        // Search Engines 
        elseif (strpos($t, 'google')) return '[Bot] Googlebot';
        elseif (strpos($t, 'bing')) return '[Bot] Bingbot';
        elseif (strpos($t, 'slurp')) return '[Bot] Yahoo! Slurp';
        elseif (strpos($t, 'duckduckgo')) return '[Bot] DuckDuckBot';
        elseif (strpos($t, 'baidu')) return '[Bot] Baidu';
        elseif (strpos($t, 'yandex')) return '[Bot] Yandex';
        elseif (strpos($t, 'sogou')) return '[Bot] Sogou';
        elseif (strpos($t, 'exabot')) return '[Bot] Exabot';
        elseif (strpos($t, 'msn')) return '[Bot] MSN';

        // Common Tools and Bots
        elseif (strpos($t, 'mj12bot')) return '[Bot] Majestic';
        elseif (strpos($t, 'ahrefs')) return '[Bot] Ahrefs';
        elseif (strpos($t, 'semrush')) return '[Bot] SEMRush';
        elseif (strpos($t, 'rogerbot') || strpos($t, 'dotbot')) return '[Bot] Moz or OpenSiteExplorer';
        elseif (strpos($t, 'frog') || strpos($t, 'screaming')) return '[Bot] Screaming Frog';

        // Miscellaneous
        elseif (strpos($t, 'facebook')) return '[Bot] Facebook';
        elseif (strpos($t, 'pinterest')) return '[Bot] Pinterest';

        // Check for strings commonly used in bot user agents  
        elseif (
            strpos($t, 'crawler') || strpos($t, 'api') ||
            strpos($t, 'spider') || strpos($t, 'http') ||
            strpos($t, 'bot') || strpos($t, 'archive') ||
            strpos($t, 'info') || strpos($t, 'data')
        ) return '[Bot] Other';

        return 'Other (Unknown)';
    }

    public function get_user_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    public function get_device_type()
    {
        $User_Agent = $_SERVER["HTTP_USER_AGENT"];
        $Device_Types = array(
            "COMPUTER" => array("trident", "msie 10", "msie 9", "msie 8", "edge", "windows.*firefox", "windows.*chrome", "x11.*chrome", "x11.*firefox", "macintosh.*chrome", "macintosh.*firefox", "opera"),
            "TABLET"   => array("tablet", "android", "ipad", "tablet.*firefox"),
            "MOBILE"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini"),
            "BOT"      => array("googlebot", "mediapartners-google", "adsbot-google", "duckduckbot", "msnbot", "bingbot", "ask", "facebook", "yahoo", "addthis")

        );

        foreach ($Device_Types as $deviceType => $My_Devices) {
            foreach ($My_Devices as $device) {
                if (preg_match("/" . $device . "/i", $User_Agent)) {
                    $deviceName = $deviceType;
                }
            }
        }
        return ucfirst($deviceName);
    }
}
