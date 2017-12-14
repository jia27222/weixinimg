# weixinimg
正常引用显示微信图片

/**
     * 处理文章内容的图片src属性
     * @param unknown $str
     */
    public function imgsrc($str){
        $APP_URL = C('APP_HTTPURL');
        //处理微信图片无法正常显示问题
        $msg = preg_replace("/src=\"https:\/\/mmbiz\./", " data-src=\"".$APP_URL."index.php/ArticleIndex/pic/https://mmbiz.", $str);
        $msg = preg_replace("/src=\"http:\/\/mmbiz\./", " data-src=\"".$APP_URL."index.php/ArticleIndex/pic/http://mmbiz.", $msg);
        //tp=webp&
        $msg = preg_replace("/tp=webp\&/", "", $msg);
        
        //视频不加载
        $msg = preg_replace("/a\.removeAttribute\(\'src\'\);/", " ", $msg);
        $msg = preg_replace("/a\.style\.display = \"none\";/", " ", $msg);
        $msg = preg_replace("/a.setAttribute\(\"data-src\"/", "a.setAttribute(\"src\"", $msg);
        $msg = preg_replace("/mydiv\.style\.cssText = \"/", "mydiv.style.cssText = \"display: none;", $msg);
        //style="display: none;
        
        // 图片延迟加载
        //$msg = preg_replace("/\ssrc/", " data-src", $msg);
        return $msg;
    }
