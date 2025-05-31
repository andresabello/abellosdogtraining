<?php

namespace App\Shortcodes;

class VideoContainer implements ShortCodePresenter
{
    /**
     * @var array
     */
    protected static $defaultAttributes = [
        'height' => '320px',
        'video_id' => '',
        'video_url' => '',
        'video_background' => '',
        'width' => '480px',
        'auto_play' => true,
        'indicators' => true,
        'full_screen' => false,
        'loop' => false,
        'show_info' => false,
        'auto_hide' => true,
        'disable_keyBoard' => true,
        'opacity' => '50',
        'youtube' => false,
        'lazy_load' => true
    ];

    /**
     * @param array $attributes
     * @param string $content
     * @param string $name
     *
     * @return mixed
     */
    public static function render($attributes, $content = '', $name = '')
    {
        $allAttrs = shortcode_atts(self::$defaultAttributes, $attributes, $name);
        $videoId = $allAttrs['video_id'];
        $videoUrl = $allAttrs['video_url'];
        $videoBackground = $allAttrs['video_background'];
        $containerHeight = json_encode($allAttrs['height']);
        $height = json_encode($allAttrs['height']);
        $width = $allAttrs['width'];
        $showInfo = json_encode(boolval($allAttrs['show_info']));
        $disableKeyBoard = json_encode((bool)$allAttrs['disable_keyBoard']);
        $autoPlay = $allAttrs['auto_play'] === 'false' || !$allAttrs['auto_play'] ? false : true;
        $autoPlay = json_encode($autoPlay);
        $autoHide = $allAttrs['auto_hide'] === 'false' || !$allAttrs['auto_hide']? false : true;
        $autoHide = json_encode($autoHide);
        $loop = $allAttrs['loop'] === 'false' || !$allAttrs['loop'] ? false : true;
        $loop = json_encode($loop);
        $youtube = $allAttrs['youtube'] === 'false' || !$allAttrs['youtube'] ? false : true;
        $lazyLoad = $allAttrs['lazy_load'] === 'false' || !$allAttrs['lazy_load']? false : true;
        $lazyLoad = json_encode($lazyLoad);
        $indicators = $allAttrs['indicators'] === 'false' || !$allAttrs['indicators']? false : true;
        $indicators = json_encode($indicators);
        $opacity = $allAttrs['opacity'];
        $rgbaWithOpacity = json_encode("rgba(1, 1, 1, .{$opacity})");
        $id = uniqid();

        if ($youtube) {
            $videoSource = $videoId ? "video-id='$videoId'" : "video-url='$videoUrl'";
            return "<div class='yt-player yt-player-$id' data-id='$id'>
                <yt-player $videoSource 
                :height='$height' 
                :container-height='$height' 
                :lazy='$lazyLoad' 
                :loop='$loop' 
                :auto-play='$autoPlay' 
                :auto-hide='$autoHide' 
                :controls='$indicators'>$content</yt-player>
            </div>";

        }

        return "<div class='video-container video-container-$id' data-id='$id'>
                    <video-wrapper video-url='$videoUrl' video-background='$videoBackground' :loop='$loop' 
                    :show-info='$showInfo' :auto-play='$autoPlay' :auto-hide='$autoHide' :controls='$indicators' 
                    :video-overlay-background='$rgbaWithOpacity' :container-height='$containerHeight'>"
            . do_shortcode($content) .
            "</video-wrapper>
        </div>";
    }

}