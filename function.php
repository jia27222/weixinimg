# weixinimg
正常引用显示微信图片

    /**
     * 处理文章内容的图片src属性
     * @param unknown $str
     */
    public function imgsrc($str){
        $APP_URL = C('APP_HTTPURL');//项目访问地址
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

/**
     * 显示微信图片
     微信图片地址样例
     *$imgurl = 'http://mmbiz.qpic.cn/mmbiz_jpg/mxaa4wWaSsLTJP7sc76y6wyu8AFPV1XfgM8IXHLiaZmZbtr3XpicE0dOGUek6lh0HaO3yGABNz5lL00bmGFd8plQ/640?wx_fmt=jpeg&wxfrom=5&wx_lazy=1'
     */
    public function pic(){
//         print_r($_GET);die();
        $url =  $_SERVER["REQUEST_URI"]; 
//         echo $url;
        $imgurl = substr($url, 28);
//         echo $imgurl;
        $imgtype = $_GET['wx_fmt'];
        
        header( "Content-type: image/{$imgtype}");
        echo file_get_contents($imgurl);;
    }
    
    
