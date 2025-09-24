<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Captcha
{
    /**
     * Build captcha config, store in session, and return code + image src.
     * - Uses random_int() (no manual seeding needed)
     * - Sanitizes and clamps numeric config to avoid warnings
     */
    public function main($config = array())
    {
        $this->load->helper('url');

        // Ensure GD is available
        if (!function_exists('gd_info')) {
            throw new Exception('Required GD library is missing');
        }

        // Defaults
        $captcha_config = array(
            'code'            => '',
            'min_length'      => 5,
            'max_length'      => 5,
            'png_backgrounds' => array(base_url('/assets/captcha/captcha_bg.png')),
            'fonts'           => array(FCPATH . '/assets/captcha/times_new_yorker.ttf'),
            'characters'      => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',
            'min_font_size'   => 24,
            'max_font_size'   => 30,
            'color'           => '#000',
            'angle_min'       => 0,
            'angle_max'       => 15,
            'shadow'          => true,
            'shadow_color'    => '#CCC',
            'shadow_offset_x' => -2,
            'shadow_offset_y' => 2,
        );

        // Override with provided config
        if (is_array($config)) {
            foreach ($config as $key => $value) {
                $captcha_config[$key] = $value;
            }
        }

        // --- Normalize & clamp numeric values to avoid "non-numeric" warnings ---
        $captcha_config['min_length']    = (int) $captcha_config['min_length'];
        $captcha_config['max_length']    = (int) $captcha_config['max_length'];
        $captcha_config['min_font_size'] = (int) $captcha_config['min_font_size'];
        $captcha_config['max_font_size'] = (int) $captcha_config['max_font_size'];
        $captcha_config['angle_min']     = (int) $captcha_config['angle_min'];
        $captcha_config['angle_max']     = (int) $captcha_config['angle_max'];
        $captcha_config['shadow_offset_x']= (int) $captcha_config['shadow_offset_x'];
        $captcha_config['shadow_offset_y']= (int) $captcha_config['shadow_offset_y'];

        // Safety clamps
        if ($captcha_config['min_length'] < 1) {
            $captcha_config['min_length'] = 1;
        }
        if ($captcha_config['max_length'] < $captcha_config['min_length']) {
            $captcha_config['max_length'] = $captcha_config['min_length'];
        }

        if ($captcha_config['angle_min'] < 0) {
            $captcha_config['angle_min'] = 0;
        }
        // Keep small angles; adjust if you want more rotation
        if ($captcha_config['angle_max'] > 15) {
            $captcha_config['angle_max'] = 15;
        }
        if ($captcha_config['angle_max'] < $captcha_config['angle_min']) {
            $captcha_config['angle_max'] = $captcha_config['angle_min'];
        }

        if ($captcha_config['min_font_size'] < 10) {
            $captcha_config['min_font_size'] = 10;
        }
        if ($captcha_config['max_font_size'] < $captcha_config['min_font_size']) {
            $captcha_config['max_font_size'] = $captcha_config['min_font_size'];
        }

        // Ensure characters set is not empty
        if (!isset($captcha_config['characters']) || $captcha_config['characters'] === '') {
            $captcha_config['characters'] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        }

        // --- DO NOT seed RNG; PHP auto-seeds. Use random_int() for secure randomness. ---

        // Generate CAPTCHA code if not provided
        if (empty($captcha_config['code'])) {
            $captcha_config['code'] = '';
            $chars        = $captcha_config['characters'];
            $charsLen     = strlen($chars);
            $targetLength = ($captcha_config['min_length'] === $captcha_config['max_length'])
                ? $captcha_config['min_length']
                : random_int($captcha_config['min_length'], $captcha_config['max_length']);

            // Guard against empty character set
            if ($charsLen < 1) {
                $chars        = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                $charsLen     = strlen($chars);
            }

            while (strlen($captcha_config['code']) < $targetLength) {
                $idx = random_int(0, $charsLen - 1);
                $captcha_config['code'] .= $chars[$idx];
            }
        }

        // Generate image src with cache-busting query param
        // Assumes you have a controller/route "viewcaptcha" that reads session('captcha_config')
        $image_src = site_url('viewcaptcha') . '?t=' . rawurlencode((string) microtime(true));

        // Persist config in session for the image renderer
        $this->session->set_userdata(array(
            'captcha_config' => serialize($captcha_config),
        ));

        return array(
            'code'      => $captcha_config['code'],
            'image_src' => $image_src,
        );
    }

    /**
     * Convert hex color to RGB array or string
     */
    public function hex2rgb($hex_str, $return_string = false, $separator = ',')
    {
        $hex_str = preg_replace("/[^0-9A-Fa-f]/", '', $hex_str); // sanitize
        $rgb_array = array();

        if (strlen($hex_str) === 6) {
            $color_val     = hexdec($hex_str);
            $rgb_array['r']= 0xFF & ($color_val >> 0x10);
            $rgb_array['g']= 0xFF & ($color_val >> 0x08);
            $rgb_array['b']= 0xFF & $color_val;
        } elseif (strlen($hex_str) === 3) {
            $rgb_array['r']= hexdec(str_repeat(substr($hex_str, 0, 1), 2));
            $rgb_array['g']= hexdec(str_repeat(substr($hex_str, 1, 1), 2));
            $rgb_array['b']= hexdec(str_repeat(substr($hex_str, 2, 1), 2));
        } else {
            return false;
        }

        return $return_string ? implode($separator, $rgb_array) : $rgb_array;
    }

    /**
     * CI superobject passthrough
     */
    public function __get($var)
    {
        return get_instance()->$var;
    }
}
