<?php
namespace App\Models;

class LoginLdapAuto
{
    private static $instance = null;

    private static $options = [
        LDAP_OPT_PROTOCOL_VERSION => 3,
        LDAP_OPT_REFERRALS => 0,
    ];

    // .env
    private static $domain = '';
    private static $basedn = '';
    private static $attributes = [];
    private static $groups = [];
    private static $hosts = [];

    public static function setDefaults()
    {
        self::$domain = env('LDAP_DOMAIN');
        self::$basedn = env('LDAP_BASEDN');
        self::$attributes = json_decode(env('LDAP_ATTRS'));
        self::$groups = json_decode(env('LDAP_GROUPS'));
        self::$hosts = json_decode(env('LDAP_HOSTS'));
    }

    public static function connect()
    {
        self::setDefaults();

        $servers = self::$hosts;

        if (is_null($servers) || !is_array($servers)) {
            throw new \Exception("LDAP hosts configuration is invalid.");
        }

        $connection = false;
        foreach ($servers as $server) {
            $ldap = ldap_connect("ldap://{$server}");
            if ($ldap) {
                foreach (self::$options as $key => $value) {
                    ldap_set_option($ldap, $key, $value);
                }

                if (ldap_bind($ldap)) {
                    $connection = true;
                    break;
                }
            }
        }

        if ($connection) {
            self::$instance = $ldap;
            return true;
        }

        return false;
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::connect();
        }

        return self::$instance;
    }

    public static function attempt($user, $passwd)
    {
        $instance = self::getInstance();
        if ($instance) {
            if (@ldap_bind($instance, $user . "@" . self::$domain, $passwd)) {
                $dns = self::getDN($user);
                if (isset($dns, $dns['dn']) && self::checkGroup($instance, $dns['dn'])) {
                    return true;
                }

            }
        }
        return false;
    }

    public static function getDN($samaccountname)
    {
        $instance = self::getInstance();
        $result = ldap_search($instance, self::$basedn, "(samaccountname={$samaccountname})", self::$attributes);

        if ($result === false) {
            return false;
        }

        $entries = ldap_get_entries($instance, $result);

        if ($entries['count'] > 0) {
            return self::prepareEntry($entries[0]);
        }

        return false;
    }

    public static function checkGroup($ad, $userdn)
    {
        $attributes = ['memberof'];
        $result = ldap_read($ad, $userdn, '(memberof=*)', $attributes);
        if ($result === false) {
            return false;
        }

        $entries = ldap_get_entries($ad, $result);
        if ($entries['count'] > 0 && isset($entries[0], $entries[0]['memberof'], $entries[0]['memberof']['count'])) {
            $count = $entries[0]['memberof']['count'];

            for ($i = 0; $i < $count; $i++) {
                $group = preg_match("/^CN=([^,]+)/", $entries[0]['memberof'][$i], $m);
                if (isset($m) && isset($m[1])) {
                    $group = $m[1];
                    if (in_array($group, self::$groups)) {
                        return true;
                    }

                }
            }
        }
        return false;
    }

    private static function prepareEntry($entry)
    {
        $result = [];
        foreach ($entry as $key => $value) {
            $type = gettype($value);
            if ($type === 'string' && isset($entry[$value])) {
                $key = $value;
                $value = $entry[$value];
                unset($value['count']);
                if (count($value) === 1) {
                    $value = $value[0];
                }

            }
            // if is utf-8
            if (preg_match('//u', serialize($value))) {
                $result[$key] = $value;
            }

        }
        return $result;
    }

    public static function isAdmin($username)
    {
        // Obtener los grupos del usuario
        $userGroups = self::getUserGroups($username);

        // Obtener la lista de grupos de administradores del archivo .env
        $adminGroups = json_decode(env('LDAP_ADMINS', '[]'), true);

        // Verificar si el usuario está en la lista de administradores
        $isAdmin = false;
        foreach ($userGroups as $group) {
            if (in_array($group, $adminGroups)) {
                $isAdmin = true;
                break;
            }
        }

        return $isAdmin;
    }

    private static function getUserGroups($username)
    {
        $instance = self::getInstance();
        $result = ldap_search($instance, self::$basedn, "(samaccountname={$username})", ['memberof']);

        if ($result === false) {
            return [];
        }

        $entries = ldap_get_entries($instance, $result);

        if ($entries['count'] > 0 && isset($entries[0]['memberof'])) {
            $groups = [];
            for ($i = 0; $i < $entries[0]['memberof']['count']; $i++) {
                $group = preg_match("/^CN=([^,]+)/", $entries[0]['memberof'][$i], $matches);
                if ($group && isset($matches[1])) {
                    $groups[] = $matches[1];
                }
            }
            return $groups;
        }

        return [];
    }
}
