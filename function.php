# weixinimg
正常引用显示微信图片

    /**
     * 处理文章内容的图片src属性
     * @param string $str 微信文章源码内容
     */
    public function imgsrc($str){
        $APP_URL = C('APP_HTTPURL');//项目访问地址
        //处理微信图片无法正常显示问题
        $msg = preg_replace("/src=\"https:\/\/mmbiz\./", " data-src=\"".$APP_URL."index.php/ArticleIndex/pic/https://mmbiz.", $str);
        $msg = preg_replace("/src=\"http:\/\/mmbiz\./", " data-src=\"".$APP_URL."index.php/ArticleIndex/pic/http://mmbiz.", $msg);
        $msg = preg_replace("/tp=webp\&/", "", $msg);
        
        //视频不加载
        $msg = preg_replace("/a\.removeAttribute\(\'src\'\);/", " ", $msg);
        $msg = preg_replace("/a\.style\.display = \"none\";/", " ", $msg);
        $msg = preg_replace("/a.setAttribute\(\"data-src\"/", "a.setAttribute(\"src\"", $msg);
        $msg = preg_replace("/mydiv\.style\.cssText = \"/", "mydiv.style.cssText = \"display: none;", $msg);
        
        // 图片延迟加载
        //$msg = preg_replace("/\ssrc/", " data-src", $msg);
        return $msg;
    }

    /**
     *显示微信图片方法
     *微信图片地址样例
     *$imgurl = 'http://mmbiz.qpic.cn/mmbiz_jpg/mxaa4wWaSsLTJP7sc76y6wyu8AFPV1XfgM8IXHLiaZmZbtr3XpicE0dOGUek6lh0HaO3yGABNz5lL00bmGFd8plQ/640?wx_fmt=jpeg&wxfrom=5&wx_lazy=1'
     */
    public function pic(){
        $url =  $_SERVER["REQUEST_URI"]; 
        $imgurl = substr($url, 28);
        $imgtype = $_GET['wx_fmt'];
        
        header( "Content-type: image/{$imgtype}");
        echo file_get_contents($imgurl);;
    }
    
    
