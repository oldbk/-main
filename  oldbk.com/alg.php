<?

if (!function_exists('in_smdp')) {
    function in_smdp($input)
    {
        // �� ������ �������
        $c = xxtea_encrypt($input, 'A2b3AGdHjx00x11');
        //return mysql_real_escape_string($c);
        return ($c);

    }
}


if (!function_exists('out_smdp')) {
    // ���� �� ������������
    function out_smdp($input)
    {
        $c = xxtea_decrypt($input, 'A2b3AGdHjx00x11');
        return $c;
    }
}


if (!function_exists('in_smdp_new')) {
    function in_smdp_new($input)
    {
        // �� ������ �������
        $c = xxtea_encrypt($input, 'B5cHAfdsFz14x55');
        //return mysql_real_escape_string($c);
        return ($c);
    }
}


if (!function_exists('out_smdp_new')) {
    // ���� �� ������������
    function out_smdp_new($input)
    {

        $c = xxtea_decrypt($input, 'B5cHAfdsFz14x55');
        return $c;
    }
}


if (!function_exists('long2str')) {
    function long2str($v, $w)
    {
        $len = count($v);
        $n = ($len - 1) << 2;
        if ($w) {
            $m = $v[$len - 1];
            if (($m < $n - 3) || ($m > $n)) return false;
            $n = $m;
        }
        $s = array();
        for ($i = 0; $i < $len; $i++) {
            $s[$i] = pack("V", $v[$i]);
        }
        if ($w) {
            return substr(join('', $s), 0, $n);
        } else {
            return join('', $s);
        }
    }
}


if (!function_exists('str2long')) {
    function str2long($s, $w)
    {
        $v = unpack("V*", $s . str_repeat("\0", (4 - strlen($s) % 4) & 3));
        $v = array_values($v);
        if ($w) {
            $v[count($v)] = strlen($s);
        }
        return $v;
    }
}

if (!function_exists('int32')) {
    function int32($n)
    {
        while ($n >= 2147483648) $n -= 4294967296;
        while ($n <= -2147483649) $n += 4294967296;
        return (int)$n;
    }
}


if (!function_exists('xxtea_encrypt')) {
    function xxtea_encrypt($str, $key)
    {
        if ($str == "") {
            return "";
        }
        $v = str2long($str, true);
        $k = str2long($key, false);
        if (count($k) < 4) {
            for ($i = count($k); $i < 4; $i++) {
                $k[$i] = 0;
            }
        }
        $n = count($v) - 1;

        $z = $v[$n];
        $y = $v[0];
        $delta = 0x9E3779B9;
        $q = floor(6 + 52 / ($n + 1));
        $sum = 0;
        while (0 < $q--) {
            $sum = int32($sum + $delta);
            $e = $sum >> 2 & 3;
            for ($p = 0; $p < $n; $p++) {
                $y = $v[$p + 1];
                $mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
                $z = $v[$p] = int32($v[$p] + $mx);
            }
            $y = $v[0];
            $mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
            $z = $v[$n] = int32($v[$n] + $mx);
        }
        return long2str($v, false);
    }
}

if (!function_exists('xxtea_decrypt')) {
    function xxtea_decrypt($str, $key)
    {
        if ($str == "") {
            return "";
        }
        $v = str2long($str, false);
        $k = str2long($key, false);
        if (count($k) < 4) {
            for ($i = count($k); $i < 4; $i++) {
                $k[$i] = 0;
            }
        }
        $n = count($v) - 1;

        $z = $v[$n];
        $y = $v[0];
        $delta = 0x9E3779B9;
        $q = floor(6 + 52 / ($n + 1));
        $sum = int32($q * $delta);
        while ($sum != 0) {
            $e = $sum >> 2 & 3;
            for ($p = $n; $p > 0; $p--) {
                $z = $v[$p - 1];
                $mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
                $y = $v[$p] = int32($v[$p] - $mx);
            }
            $z = $v[$n];
            $mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
            $y = $v[0] = int32($v[0] - $mx);
            $sum = int32($sum - $delta);
        }
        return long2str($v, true);
    }
}