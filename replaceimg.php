/**
     * 下载外链图片
* @param string $xstr 内容
* @param string $keyword 创建文件名的关键字
* @param string $oriweb 网址
* @return string
     */
    function replaceimg($xstr,$keyword){
        //保存路径
        $d = date('Ymd', time());
        $dirslsitss = dirname(dirname(dirname(dirname(__FILE__)))).'/Public/ueditor/image/'.$keyword.'/';//分类是否存在
        if(!is_dir($dirslsitss)){
           @mkdir($dirslsitss, 0777);
        }
    
        //匹配图片的src
        preg_match_all('#<img.*? src="([^"]*)"[^>]*>#i', $xstr, $match);
        
        //针对微信文章 ---- 匹配图片的data-src
        preg_match_all('#<img.*? data-src="([^"]*)"[^>]*>#i', $xstr, $match2);
        foreach($match2[1] as $imgurl){
            $xstr =str_replace($imgurl,'',$xstr);
        }
        //针对微信文章 ---- 匹配图片的data-croporisrc
        preg_match_all('#<img.*? data-croporisrc="([^"]*)"[^>]*>#i', $xstr, $match2);
        foreach($match2[1] as $imgurl){
            $xstr =str_replace($imgurl,'',$xstr);
        }
        
        foreach($match[1] as $imgurl){
            //跳过本地上传的
            if (strpos($imgurl, 'http://images.rntd.cn')===0){
                continue;
            }
            if((is_int(strpos($imgurl, 'http')) || is_int(strpos($imgurl, 'https')))){
                $arcurl = $imgurl;
                
                //获取图片扩展名
                $imghttp = get_headers($imgurl,true);
                $type = $imghttp['Content-Type'];
                $types = array(
                    'image/gif'=>'gif',
                    'image/jpeg'=>'jpeg',
                    'image/png'=>'png',
                );
                $ext = $types[$type] ? $types[$type] : 'image/jpeg';
                
                //             var_dump($type);die();
                $img=file_get_contents($arcurl);
                
                if(!empty($img)) {
                
                    $fileimgname = time()."-".rand(1000,9999).".".$ext;
                    $filecachs=$dirslsitss.$fileimgname;
                    $fanhuistr = file_put_contents( $filecachs, $img );
                    $saveimgfile = $this->imgurl.'/Public/ueditor/image/'.$keyword.'/'.$fileimgname;
                    $xstr =str_replace($imgurl,$saveimgfile,$xstr);
                }
                
            }
        }
        return $xstr;
    }
