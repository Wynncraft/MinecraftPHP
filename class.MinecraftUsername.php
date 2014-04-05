<?php
/**
 * Class MinecraftUsername
 *
 * A really simple class with useful functions for a Minecraft username
 *
 * @author  Chris Ireland <ireland63@gmail.com>
 * @license MIT <http://opensource.org/licenses/MIT>
 */

class MinecraftUsername
{

    /**
     * Sets a default username for the class
     *
     * @var string
     */
    public $username = 'Steve';

    /**
     * Create a new MinecraftUsername object with a username parameter.
     *
     * @param string $username
     */
    function __construct($username = 'Steve')
    {
        $this->username = $username;
    }

    /**
     * Check if a Minecraft username is premium.
     *
     * @return bool
     */
    public function checkPremium()
    {
        // Create a curl resource
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://minecraft.net/haspaid.jsp?user=' . $this->username);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Execute and close the curl resource
        $query = curl_exec($ch);
        curl_close($ch);

        // Return a boolean based on the string query result
        if ($query == 'true')
            return true;

        return false;
    }

    /**
     * Get a Minecraft user's unique user identification number.
     *
     * @return mixed
     */
    public function getUUID()
    {
        // Create a curl resource
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.mojang.com/profiles/page/1');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            '{
                    "name": "' . $this->username . '",
					"agent": "minecraft"
				}'
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Execute and close the curl resource
        $uuid = curl_exec($ch);
        curl_close($ch);

        // Decode the UUID
        $uuid = json_decode($uuid, true);
        $uuid = $uuid['profiles'][0]['id'];

        return $uuid;
    }


    /**
     * Gets a Minecraft avatar from the Minecraft skin servers.
     * - Avatar function from https://github.com/jamiebicknell/Minecraft-Avatar
     * 
     * @param int $size
     */
    public function getAvatar($size = 16)
    {
        // Get the username and default fallback
        $username = $this->username;

        if($this->username === 'Steve')
            $username = 'char';

        // Get avatar
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://s3.amazonaws.com/MinecraftSkins/' . $username . '.png');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $output = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // The default skin should fallback
        if ($status != '200') {
            $output = 'iVBORw0KGgoAAAANSUhEUgAAAEAAAAAgCAMAAACVQ462AAAABGdBTUEAALGPC/xhBQAAAwBQTFRFAAAAHxALIxcJJBgIJBgKJhgLJhoKJx';
            $output .= 'sLJhoMKBsKKBsLKBoNKBwLKRwMKh0NKx4NKx4OLR0OLB4OLx8PLB4RLyANLSAQLyIRMiMQMyQRNCUSOigUPyoVKCgoPz8/JiFbMChyAFt';
            $output .= 'bAGBgAGhoAH9/Qh0KQSEMRSIOQioSUigmUTElYkMvbUMqb0UsakAwdUcvdEgvek4za2trOjGJUj2JRjqlVknMAJmZAJ6eAKioAK+vAMzM';
            $output .= 'ikw9gFM0hFIxhlM0gVM5g1U7h1U7h1g6ilk7iFo5j14+kF5Dll9All9BmmNEnGNFnGNGmmRKnGdIn2hJnGlMnWpPlm9bnHJcompHrHZaq';
            $output .= 'n1ms3titXtnrYBttIRttolsvohst4Jyu4lyvYtyvY5yvY50xpaA////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
            $output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
            $output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
            $output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
            $output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
            $output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
            $output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAPSUN6AAAAQB0Uk5T////////////////////////////////////////';
            $output .= '/////////////////////////////////////////////////////////////////////////////////////////////////////////';
            $output .= '/////////////////////////////////////////////////////////////////////////////////////////////////////////';
            $output .= '//////////////////////////////////////////////////////////////////////////////////////////AFP3ByUAAAAYdEV';
            $output .= 'YdFNvZnR3YXJlAFBhaW50Lk5FVCB2My4zNqnn4iUAAAKjSURBVEhLpZSLVtNAEIYLpSlLSUITLCBaGhNBQRM01M2mSCoXNUURIkZFxQvv';
            $output .= '/wz6724Wij2HCM7J6UyS/b+dmZ208rsww6jiqo4FhannZb5yDqjaNgDVwE/8JAmCMqF6fwGwbU0CKjD/+oAq9jcM27gxAFpNQxU3Bwi9A';
            $output .= 'jy8fgmGZuvaGAcIuwFA12CGce1jJESr6/Ot1i3Tnq5qptFqzet1jRA1F2XHWQFAs3RzwTTNhQd3rOkFU7c0DijmohRg1TR9ZmpCN7/8+P';
            $output .= 'X954fb+sTUjK7VLKOYi1IAaTQtUrfm8pP88/vTw8M5q06sZoOouSgHEDI5vrO/eHK28el04yxf3N8ZnyQooZiLfwA0arNb6d6bj998/+v';
            $output .= 'x8710a7bW4E2Uc1EKsEhz7WiQBK9eL29urrzsB8ngaK1JLDUXpYAkGSQH6e7640fL91dWXjxZ33138PZggA+Sz0WQlAL4gmewuzC1uCen';
            $output .= 'qXevMPWc9XrMX/VXh6Hicx4ByHEeAfRg/wtgSMAvz+CKEkYAnc5SpwuD4z70PM+hUf+4348ixF7EGItjxmQcCx/Dzv/SOkuXAF3PdT3GI';
            $output .= 'ujjGLELNYwxhF7M4oi//wsgdlYZdMXCmEUUSsSu0OOBACMoBTiu62BdRPEjYxozXFyIpK7IAE0IYa7jOBRqGlOK0BFq3Kdpup3DthFwP9';
            $output .= 'QDlBCGKEECoHEBEDLAXHAQMQnI8jwFYRQw3AMOQAJoOADoAVcDAh0HZAKQZUMZdC43kdeqAPwUBEsC+M4cIEq5KEEBCl90mR8CVR3nxwC';
            $output .= 'dBBS9OAe020UGnXb7KcxzPY9SXoEEIBZtgE7UDgBKyLMhgBS2YdzjMJb4XHRDAPiQhSGjNOxKQIZTgC8BiMECgarxprjjO0OXiV4MAf4A';
            $output .= '/x0nbcyiS5EAAAAASUVORK5CYII=';
            $output = base64_decode($output);
        }

        $skin = $output;

        // Scale and merge the image
        $im = imagecreatefromstring($skin);
        $av = imagecreatetruecolor($size, $size);
        imagecopyresized($av, $im, 0, 0, 8, 8, $size, $size, 8, 8); //Face
        imagecolortransparent($im, imagecolorat($im, 63, 0)); // Black Hat Issue
        imagecopyresized($av, $im, 0, 0, 40, 8, $size, $size, 8, 8); // Accessories

        // Create the image as a png
        header('Content-type: image/png');
        imagepng($av);

        imagedestroy($im);
        imagedestroy($av);
    }

} 
