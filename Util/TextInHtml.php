<?php
/**
 * Created by PhpStorm.
 * User: CodingByJerez
 * Url: http://coding.by.jerez.me
 * Github: https://github.com/CodingByJerez
 * Date: 28/10/2019
 * Time: 16:21
 */

namespace CodingByJerez\MinecraftBundle\Util;


class TextInHtml
{

    static private $classColors = array(
        '0' => 'black', //Black
        '1' => 'dark_blue', //Dark Blue
        '2' => 'dark_green', //Dark Green
        '3' => 'dark_aqua', //Dark Aqua
        '4' => 'dark_red', //Dark Red
        '5' => 'dark_purple', //Dark Purple
        '6' => 'gold', //Gold
        '7' => 'gray', //Gray
        '8' => 'dark_gray', //Dark Gray
        '9' => 'blue', //Blue
        'a' => 'green', //Green
        'b' => 'aqua', //Aqua
        'c' => 'red', //Red
        'd' => 'light_purple', //Light Purple
        'e' => 'yellow', //Yellow
        'f' => 'white'  //White
    );

    static private $formatting = array(
        'k' => '',                               //Obfuscated
        'l' => 'bold',             //Bold
        'm' => 'strikethrough', //Strikethrough
        'n' => 'underline',    //Underline
        'o' => 'italic',            //Italic
        'r' => ''                                //Reset
    );


    /**
     * @param $desc
     * @return string
     */
    static public function GetInHTML($desc): string
    {
        if(gettype($desc) == 'object'){
            $description = '';
            if(isset($desc->text)){
                $color = isset($desc->color) ? htmlentities($desc->color, ENT_QUOTES, 'utf-8') : "";
                //$text = MinecraftColors::convertToHTML(str_replace(' ', '&nbsp;', $desc->text));
                $text = TextInHtml::convertToHTML($desc->text);
                $description = "<span class='minecraft $color'>$text</span>";
            }
            if(isset($desc->extra)){
                foreach($desc->extra as $item){
                    $bold = isset($item->bold) ? "bold" : "";
                    $color = isset($item->color) ? htmlentities($item->color, ENT_QUOTES, 'utf-8') : "";
                    $text = str_replace(' ', '&nbsp;', TextInHtml::convertToHTML($item->text));
                    $description .= "<span class='minecraft $bold $color'>$text</span>";
                }
            }
        }else{
            $description = TextInHtml::convertToHTML($desc);
        }

        return $description;
    }


    /**
     * @param $text
     * @return mixed|string
     */
    static private function convertToHTML($text){
        $text = htmlspecialchars($text, ENT_QUOTES, 'utf-8');

        preg_match_all('/(?:§)([0-9a-fklmnor])/i', $text, $offsets);
        $colors      = $offsets[0];
        $color_codes = $offsets[1];

        if(empty($color_codes))
            return $text;


        $open_tags = 0;
        foreach($colors as $index => $color){
            $color_code = strtolower($color_codes[$index]);
            if(isset(self::$classColors[$color_code])){
                $html = sprintf("<span class='minecraft %s'>", self::$classColors[$color_code]);
                if ($open_tags != 0) {
                    $html = str_repeat('</span>', $open_tags).$html;
                    $open_tags = 0;
                }
                $open_tags++;
            }else{
                switch ($color_code) {
                    case 'r':
                        $html = '';
                        if ($open_tags != 0) {
                            $html = str_repeat('</span>', $open_tags);
                            $open_tags = 0;
                        }
                        break;
                    case 'k':
                        $html = '';
                        break;
                    default:
                        $html = sprintf("<span class='minecraft %s'>", self::$formatting[$color_code]);
                        $open_tags++;
                        break;
                }
            }
            $text = preg_replace('/'.$color.'/', $html, $text, 1);
        }

        return $text;
    }


}